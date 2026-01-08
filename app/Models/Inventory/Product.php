<?php

namespace App\Models\Inventory;

use App\Models\Admin\Company;
use App\Models\Inventory\Category;
use App\Models\Admin\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $table = 'products';

    protected $fillable = [
        'company_id',
        'category_id',
        'product_code',
        'product_name',
        'description',
        'short_description',
        'barcode',
        'sku',
        'unit_of_measure',
        'brand',
        'model',
        'weight',
        'dimensions',
        'color',
        'material',
        'cost_price',
        'purchase_price',
        'selling_price',
        'wholesale_price',
        'mrp',
        'tax_rate',
        'discount_percentage',
        'stock_quantity',
        'available_quantity',
        'min_stock',
        'max_stock',
        'reorder_level',
        'hsn_sac_code',
        'hs_code',
        'ait_rate',
        'manufacturer',
        'country_of_origin',
        'warranty_period',
        'expiry_date',
        'track_batch',
        'track_expiry',
        'is_active',
        'is_featured',
        'has_variants',
        'rating',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'cost_price' => 'decimal:2',
        'purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'wholesale_price' => 'decimal:2',
        'mrp' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'ait_rate' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'weight' => 'decimal:3',
        'rating' => 'decimal:2',
        'stock_quantity' => 'integer',
        'available_quantity' => 'integer',
        'min_stock' => 'integer',
        'max_stock' => 'integer',
        'reorder_level' => 'integer',
        'track_batch' => 'boolean',
        'track_expiry' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'has_variants' => 'boolean',
        'expiry_date' => 'date',
    ];

    protected $appends = [
        'final_price',
        'in_stock',
        'stock_status',
        'stock_status_text',
        'stock_status_badge',
        'inventory_value',
        'profit_margin',
        'profit_amount',
        'thumbnail_url',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->product_code)) {
                $product->product_code = self::generateProductCode();
            }

            if (empty($product->sku)) {
                $product->sku = 'SKU-' . strtoupper(substr(md5(rand()), 0, 8));
            }

            if (empty($product->barcode)) {
                $product->barcode = '8' . str_pad(rand(0, 99999999999), 11, '0', STR_PAD_LEFT);
            }

            if (auth()->check()) {
                $product->created_by = auth()->id();
            }
        });

        static::updating(function ($product) {
            if (auth()->check()) {
                $product->updated_by = auth()->id();
            }

            // Update available quantity if stock changes
            if ($product->isDirty('stock_quantity')) {
                $product->available_quantity = $product->stock_quantity;
            }
        });
    }

    /**
     * Relationships
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Accessors & Mutators
     */
    protected function finalPrice(): Attribute
    {
        return Attribute::make(
            get: function () {
                $price = $this->selling_price;

                // Apply discount if exists
                if ($this->discount_percentage > 0) {
                    $price = $price - ($price * $this->discount_percentage / 100);
                }

                return round($price, 2);
            }
        );
    }

    protected function inStock(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->available_quantity > 0
        );
    }

    protected function stockStatus(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->available_quantity <= 0) {
                    return 'out_of_stock';
                } elseif ($this->available_quantity <= $this->reorder_level) {
                    return 'low_stock';
                } else {
                    return 'in_stock';
                }
            }
        );
    }

    protected function stockStatusText(): Attribute
    {
        return Attribute::make(
            get: function () {
                switch ($this->stock_status) {
                    case 'out_of_stock':
                        return 'Out of Stock';
                    case 'low_stock':
                        return 'Low Stock';
                    default:
                        return 'In Stock';
                }
            }
        );
    }

    protected function stockStatusBadge(): Attribute
    {
        return Attribute::make(
            get: function () {
                switch ($this->stock_status) {
                    case 'out_of_stock':
                        return 'danger';
                    case 'low_stock':
                        return 'warning';
                    default:
                        return 'success';
                }
            }
        );
    }

    protected function inventoryValue(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->stock_quantity * $this->cost_price
        );
    }

    protected function profitMargin(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->cost_price <= 0) return 0;
                $profit = $this->selling_price - $this->cost_price;
                return round(($profit / $this->cost_price) * 100, 2);
            }
        );
    }

    protected function profitAmount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->selling_price - $this->cost_price
        );
    }

    protected function thumbnailUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                $media = $this->getFirstMedia('products');
                if ($media) {
                    return $media->getUrl();
                }
                return asset('images/default-product.png');
            }
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

    public function scopeLowStock($query)
    {
        return $query->whereColumn('available_quantity', '<=', 'reorder_level')
            ->where('available_quantity', '>', 0)
            ->where('is_active', true);
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('available_quantity', '<=', 0)
            ->where('is_active', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('available_quantity', '>', 0)
            ->where('is_active', true);
    }

    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->where('product_name', 'like', "%{$searchTerm}%")
              ->orWhere('product_code', 'like', "%{$searchTerm}%")
              ->orWhere('sku', 'like', "%{$searchTerm}%")
              ->orWhere('barcode', 'like', "%{$searchTerm}%")
              ->orWhere('description', 'like', "%{$searchTerm}%")
              ->orWhere('hsn_sac_code', 'like', "%{$searchTerm}%");
        });
    }

    /**
     * Business Logic Methods
     */
    public function addStock($quantity, $location = 'default')
    {
        $this->stock_quantity += $quantity;
        $this->available_quantity += $quantity;
        $this->save();

        // Log inventory transaction
        $this->logInventoryTransaction('in', $quantity, $location);
    }

    public function removeStock($quantity, $location = 'default')
    {
        if ($this->available_quantity < $quantity) {
            throw new \Exception('Insufficient stock available');
        }

        $this->stock_quantity -= $quantity;
        $this->available_quantity -= $quantity;
        $this->save();

        // Log inventory transaction
        $this->logInventoryTransaction('out', $quantity, $location);
    }

    public function reserveStock($quantity)
    {
        if ($this->available_quantity < $quantity) {
            throw new \Exception('Insufficient stock available for reservation');
        }

        $this->available_quantity -= $quantity;
        $this->save();
    }

    private function logInventoryTransaction($type, $quantity, $location)
    {
        // Log to inventory table
        $this->inventories()->create([
            'transaction_type' => $type,
            'quantity' => $quantity,
            'location' => $location,
            'remarks' => ucfirst($type) . ' transaction',
            'created_by' => auth()->id() ?? $this->created_by,
        ]);
    }

    /**
     * Check if product is low in stock.
     */
    public function isLowStock()
    {
        return $this->available_quantity <= $this->reorder_level && $this->available_quantity > 0;
    }

    /**
     * Check if product is out of stock.
     */
    public function isOutOfStock()
    {
        return $this->available_quantity <= 0;
    }

    /**
     * Check if product needs reordering.
     */
    public function needsReorder()
    {
        return $this->available_quantity <= $this->reorder_level;
    }

    /**
     * Calculate reorder quantity.
     */
    public function getReorderQuantity()
    {
        if ($this->max_stock && $this->min_stock) {
            return $this->max_stock - $this->available_quantity;
        }
        return $this->reorder_level * 2; // Default to double reorder level
    }

    /**
     * Generate product code.
     */
    public static function generateProductCode()
    {
        $prefix = 'PROD-';
        $year = date('Y');
        $month = date('m');

        $lastProduct = self::where('product_code', 'like', $prefix . $year . $month . '%')
            ->orderBy('product_code', 'desc')
            ->first();

        if ($lastProduct) {
            $lastNumber = intval(substr($lastProduct->product_code, -4));
            $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '0001';
        }

        return $prefix . $year . $month . $nextNumber;
    }

    /**
     * Get formatted price with currency.
     */
    public function getFormattedPrice($priceType = 'selling_price')
    {
        $price = $this->{$priceType} ?? $this->selling_price;
        return 'BDT ' . number_format($price, 2);
    }

    /**
     * Check if product is on sale.
     */
    public function isOnSale()
    {
        return $this->discount_percentage > 0;
    }

    /**
     * Get discount amount.
     */
    public function getDiscountAmount()
    {
        return $this->selling_price * $this->discount_percentage / 100;
    }

    /**
     * Register media collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('products')
            ->useDisk('public')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
            ->withResponsiveImages();
    }

    /**
     * Add product image.
     */
    public function addProductImage($file)
    {
        return $this->addMedia($file)
            ->toMediaCollection('products');
    }
}
