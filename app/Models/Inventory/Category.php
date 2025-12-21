<?php

namespace App\Models\Inventory;

use App\Models\Admin\Organization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'category_code',
        'category_name',
        'parent_category_id',
        'description',
        'tax_rate_applicable'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($modal) {
            if (Auth::check()) {
                $modal->company_id = Auth::user()->company_id;
            }
        });
    }
    protected $casts = [
        'tax_rate_applicable' => 'decimal:2',
    ];

    // Relationship with Company
    public function company()
    {
        return $this->belongsTo(Organization::class, 'company_id');
    }

    // Self-referential relationship for parent category
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_category_id');
    }

    // Relationship with subcategories
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_category_id');
    }

    // Relationship with Products
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    // Get all ancestors of a category
    public function getAncestors()
    {
        $ancestors = collect();
        $category = $this;

        while ($category->parent) {
            $category = $category->parent;
            $ancestors->push($category);
        }

        return $ancestors->reverse();
    }

    // Get full category path (e.g., Electronics > Mobile > Smartphones)
    public function getFullPathAttribute()
    {
        $ancestors = $this->getAncestors();
        $ancestors->push($this);

        return $ancestors->pluck('category_name')->implode(' > ');
    }

    // Scope to get only parent categories (no parent)
    public function scopeParents($query)
    {
        return $query->whereNull('parent_category_id');
    }

    // Scope to get only child categories
    public function scopeChildren($query)
    {
        return $query->whereNotNull('parent_category_id');
    }

    // Scope to filter by company
    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }
}
