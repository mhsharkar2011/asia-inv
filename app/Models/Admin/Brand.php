<?php

namespace App\Models\Admin;

use App\Models\Admin\User;
use App\Models\Inventory\Category;
use App\Models\Inventory\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Brand extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $table = 'brands';

    protected $fillable = [
        'company_id',
        'code',
        'name',
        'slug',
        'description',
        'logo',
        'website',
        'contact_email',
        'contact_phone',
        'country_of_origin',
        'established_year',
        'is_active',
        'is_featured',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'established_year' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'meta_keywords' => 'array',
    ];

    protected $appends = [
        'logo_url',
        'total_products',
        'is_popular',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($brand) {
            // Generate slug if not provided
            if (empty($brand->slug)) {
                $brand->slug = Str::slug($brand->name);
            }

            // Generate brand code if not provided
            if (empty($brand->code)) {
                $brand->code = self::generateBrandCode($brand->name);
            }

            // Set created_by if user is authenticated
            if (auth()->check()) {
                $brand->created_by = auth()->id();
            }
        });

        static::updating(function ($brand) {
            // Update slug if brand name changed
            if ($brand->isDirty('name')) {
                $brand->slug = Str::slug($brand->name);
            }

            // Set updated_by if user is authenticated
            if (auth()->check()) {
                $brand->updated_by = auth()->id();
            }
        });

        // Ensure unique slug per company
        static::saving(function ($brand) {
            $originalSlug = $brand->slug;
            $counter = 1;

            while (self::where('company_id', $brand->company_id)
                ->where('slug', $brand->slug)
                ->where('id', '!=', $brand->id)
                ->exists()) {
                $brand->slug = $originalSlug . '-' . $counter++;
            }
        });
    }

    /**
     * Generate brand code from brand name
     */
    public static function generateBrandCode($brandName)
    {
        $code = strtoupper(preg_replace('/[^A-Z]/', '', $brandName));

        if (empty($code)) {
            $code = 'BRD';
        }

        // Make sure code is unique within company
        $baseCode = $code;
        $counter = 1;

        while (self::where('code', $code)->exists()) {
            $code = $baseCode . str_pad($counter, 3, '0', STR_PAD_LEFT);
            $counter++;
        }

        return $code;
    }

    /**
     * Relationships
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category')
                    ->withTimestamps();
    }

    /**
     * Accessors & Mutators
     */
    protected function logoUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->logo) {
                    if (filter_var($this->logo, FILTER_VALIDATE_URL)) {
                        return $this->logo;
                    }
                    return asset('storage/brands/' . $this->logo);
                }

                // Try to get from media library
                $media = $this->getFirstMedia('brands');
                if ($media) {
                    return $media->getUrl();
                }

                return asset('images/default-brand.png');
            }
        );
    }

    protected function totalProducts(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->products()->count()
        );
    }

    protected function isPopular(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->total_products > 10 // Consider popular if has more than 10 products
        );
    }

    protected function descriptionExcerpt(): Attribute
    {
        return Attribute::make(
            get: fn () => str_limit($this->description, 150)
        );
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePopular($query)
    {
        return $query->has('products', '>', 10);
    }

    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->where('name', 'like', "%{$searchTerm}%")
              ->orWhere('code', 'like', "%{$searchTerm}%")
              ->orWhere('description', 'like', "%{$searchTerm}%");
        });
    }

    public function scopeWithProductsCount($query)
    {
        return $query->withCount('products');
    }

    public function scopeOrderByProductsCount($query, $direction = 'desc')
    {
        return $query->withCount('products')->orderBy('products_count', $direction);
    }

    /**
     * Business Logic Methods
     */
    public function activate()
    {
        $this->is_active = true;
        $this->save();
    }

    public function deactivate()
    {
        $this->is_active = false;
        $this->save();
    }

    public function toggleStatus()
    {
        $this->is_active = !$this->is_active;
        $this->save();
    }

    public function feature()
    {
        $this->is_featured = true;
        $this->save();
    }

    public function unfeature()
    {
        $this->is_featured = false;
        $this->save();
    }

    /**
     * Get all products count by category
     */
    public function getProductsByCategory()
    {
        return $this->products()
            ->selectRaw('category_id, count(*) as total')
            ->groupBy('category_id')
            ->with('category')
            ->get()
            ->pluck('total', 'category.name');
    }

    /**
     * Check if brand can be deleted
     */
    public function canDelete()
    {
        return $this->products()->count() === 0;
    }

    /**
     * Delete brand with all its products (use with caution)
     */
    public function deleteWithProducts()
    {
        if ($this->products()->count() > 0) {
            $this->products()->delete();
        }

        return $this->delete();
    }

    /**
     * Get brand statistics
     */
    public function getStatistics()
    {
        return [
            'total_products' => $this->products()->count(),
            'active_products' => $this->products()->where('is_active', true)->count(),
            'total_stock' => $this->products()->sum('stock_quantity'),
            'average_price' => $this->products()->avg('selling_price'),
            'total_value' => $this->products()->sum(DB::raw('stock_quantity * cost_price')),
        ];
    }

    /**
     * Register media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('brands')
            ->useDisk('public')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'])
            ->singleFile()
            ->withResponsiveImages();
    }

    /**
     * Add brand logo
     */
    public function addLogo($file)
    {
        return $this->addMedia($file)
            ->toMediaCollection('brands');
    }

    /**
     * Get brands with their top products
     */
    public static function getBrandsWithTopProducts($limit = 3)
    {
        return self::with(['products' => function ($query) use ($limit) {
            $query->active()
                  ->orderBy('total_sold', 'desc')
                  ->limit($limit);
        }])->active()->get();
    }

    /**
     * Import brands from array
     */
    public static function importFromArray(array $brands, $companyId, $userId)
    {
        $imported = [];
        $skipped = [];

        foreach ($brands as $brandData) {
            // Check if brand already exists
            $existing = self::where('company_id', $companyId)
                ->where('code', $brandData['code'] ?? null)
                ->orWhere('name', $brandData['name'])
                ->first();

            if ($existing) {
                $skipped[] = $brandData['name'];
                continue;
            }

            $brand = self::create([
                'company_id' => $companyId,
                'code' => $brandData['code'] ?? self::generateBrandCode($brandData['name']),
                'name' => $brandData['name'],
                'description' => $brandData['description'] ?? null,
                'website' => $brandData['website'] ?? null,
                'contact_email' => $brandData['contact_email'] ?? null,
                'country_of_origin' => $brandData['country_of_origin'] ?? null,
                'is_active' => $brandData['is_active'] ?? true,
                'created_by' => $userId,
                'updated_by' => $userId,
            ]);

            $imported[] = $brand;
        }

        return [
            'imported' => $imported,
            'skipped' => $skipped,
            'total_imported' => count($imported),
            'total_skipped' => count($skipped),
        ];
    }

    /**
     * Export brands to array
     */
    public function toExportArray()
    {
        return [
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'website' => $this->website,
            'contact_email' => $this->contact_email,
            'contact_phone' => $this->contact_phone,
            'country_of_origin' => $this->country_of_origin,
            'established_year' => $this->established_year,
            'is_active' => $this->is_active ? 'Yes' : 'No',
            'is_featured' => $this->is_featured ? 'Yes' : 'No',
            'total_products' => $this->total_products,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
