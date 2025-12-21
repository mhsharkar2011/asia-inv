<?php

namespace App\Models\Admin;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'company_id',
        'branch_id',
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'avatar',
        'language_preference',
        'is_active',
        'last_login_at',
        'email_verified_at',
        'remember_token'
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

    public function roles()
    {
        return [
            'super_admin',
            'admin',
            'manager',
            'staff',
            'user',
            'customer'
        ];
    }
    public function company(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'company_id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    // In User model
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

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
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

    // Helper methods
    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'super_admin']);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isManager(): bool
    {
        return $this->role === 'manager';
    }

    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    public function getRoleBadgeAttribute(): string
    {
        $badges = [
            'super_admin' => '<span class="badge bg-danger">Super Admin</span>',
            'admin' => '<span class="badge bg-warning">Admin</span>',
            'manager' => '<span class="badge bg-info">Manager</span>',
            'staff' => '<span class="badge bg-primary">Staff</span>',
            'user' => '<span class="badge bg-secondary">User</span>',
        ];

        return $badges[$this->role] ?? '<span class="badge bg-light text-dark">Unknown</span>';
    }
    public function markAsLoggedIn(): void
    {
        $this->update(['last_login_at' => now()]);
    }

    public function canImpersonate(): bool
    {
        return $this->isAdmin() || $this->isSuperAdmin();
    }
}
