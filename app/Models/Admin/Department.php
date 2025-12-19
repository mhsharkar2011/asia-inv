<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'description',
        'manager_id',
        'parent_id',
        'email',
        'phone',
        'staff_count',
        'budget',
        'location',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'staff_count' => 'integer',
        'budget' => 'decimal:2',
        'sort_order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = ['full_path'];

    // Relationships
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Department::class, 'parent_id')->orderBy('sort_order');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // Accessors
    public function getFullPathAttribute(): string
    {
        $path = [];
        $department = $this;

        while ($department) {
            $path[] = $department->name;
            $department = $department->parent;
        }

        return implode(' → ', array_reverse($path));
    }

    public function getIsLeafAttribute(): bool
    {
        return $this->children()->count() === 0;
    }

    public function getActiveStaffCountAttribute(): int
    {
        return $this->users()->where('is_active', true)->count();
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

    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeWithChildren($query)
    {
        return $query->with(['children' => function ($q) {
            $q->orderBy('sort_order');
        }]);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
    }

    // Methods
    public function canBeDeleted(): bool
    {
        return $this->users()->count() === 0 && $this->children()->count() === 0;
    }

    public function getHierarchyLevel(): int
    {
        $level = 0;
        $department = $this;

        while ($department->parent) {
            $level++;
            $department = $department->parent;
        }

        return $level;
    }

    // Auto-generate code
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($department) {
            if (empty($department->code)) {
                $department->code = 'DEPT' . str_pad(self::count() + 1, 3, '0', STR_PAD_LEFT);
            }
        });
    }
}
