<?php

namespace App\Models\Admin;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'company_id',
        'branch_id',
        'name',
        'email',
        'password',
        'phone',
        'address',
        'avatar',
        'language_preference',
        'is_active',
        'last_login_at',
        'email_verified_at',
        'remember_token',
        'username' // Add this if you're using username field
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Custom role array for legacy purposes (rename this method)
     */
    public function availableRoles(): array
    {
        return [
            'super_admin' => 'Super Admin',
            'admin' => 'Administrator',
            'manager' => 'Manager',
            'staff' => 'Staff',
            'user' => 'User',
            'customer' => 'Customer',
            'viewer' => 'Viewer'
        ];
    }

    /**
     * Get the user's legacy role (for backward compatibility)
     */
    public function getLegacyRoleAttribute(): string
    {
        // Get the first role name or fallback to 'user'
        return $this->getRoleNames()->first() ?? 'user';
    }

    /**
     * Set the legacy role (for backward compatibility)
     */
    public function setLegacyRoleAttribute($value): void
    {
        // Sync roles with the legacy role
        $this->syncRoles([$value]);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'company_id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            if (filter_var($this->avatar, FILTER_VALIDATE_URL)) {
                return $this->avatar;
            }
            if (str_starts_with($this->avatar, 'avatars/')) {
                return Storage::url($this->avatar);
            }
            return Storage::url('avatars/' . $this->avatar);
        }

        return null;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Scope for filtering by role (compatible with Spatie)
     */
    public function scopeByRole($query, $role)
    {
        if (is_array($role)) {
            return $query->whereHas('roles', function ($q) use ($role) {
                $q->whereIn('name', $role);
            });
        }

        return $query->whereHas('roles', function ($q) use ($role) {
            $q->where('name', $role);
        });
    }

    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    public function scopeByBranch($query, $branchId)
    {
        return $query->where('branch_id', $branchId);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->orWhere('phone', 'like', "%{$search}%");
    }

    // Helper methods - updated to work with Spatie
    public function isAdmin(): bool
    {
        return $this->hasRole('admin') || $this->hasRole('super_admin');
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super_admin');
    }

    public function isManager(): bool
    {
        return $this->hasRole('manager');
    }

    public function isStaff(): bool
    {
        return $this->hasRole('staff');
    }

    public function getRoleBadgeAttribute(): string
    {
        $role = $this->getRoleNames()->first() ?? 'user';

        $badges = [
            'super_admin' => '<span class="badge bg-danger">Super Admin</span>',
            'admin' => '<span class="badge bg-warning">Admin</span>',
            'manager' => '<span class="badge bg-info">Manager</span>',
            'staff' => '<span class="badge bg-primary">Staff</span>',
            'user' => '<span class="badge bg-secondary">User</span>',
            'customer' => '<span class="badge bg-success">Customer</span>',
            'viewer' => '<span class="badge bg-secondary">Viewer</span>',
        ];

        return $badges[$role] ?? '<span class="badge bg-light text-dark">' . ucfirst($role) . '</span>';
    }

    public function markAsLoggedIn(): void
    {
        $this->update(['last_login_at' => now()]);
    }

    public function canImpersonate(): bool
    {
        return $this->isAdmin() || $this->isSuperAdmin();
    }

    /**
     * Accessor for backward compatibility
     */
    public function getRoleAttribute()
    {
        return $this->getRoleNames()->first();
    }

    /**
     * Mutator for backward compatibility
     */
    public function setRoleAttribute($value)
    {
        if (!empty($value)) {
            $this->syncRoles([$value]);
        }
    }
}
