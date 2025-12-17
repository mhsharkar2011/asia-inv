<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'product_code',
        'product_name',
        'description',
        'category_id',
        'cost_price',
        'selling_price',
        'stock_quantity',
        'reorder_level',
        'hs_code',
        'ait_rate',
        'status',
        // Add these if you have them
        'unit_of_measure',
        'purchase_price',
        'mrp',
        'tax_rate',
        'hsn_sac_code',
        'min_stock',
        'max_stock',
        'track_batch',
        'track_expiry',
        'is_active',
    ];

    protected $casts = [
        'cost_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'reorder_level' => 'integer',
        'ait_rate' => 'decimal:2',
        'purchase_price' => 'decimal:2',
        'mrp' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'min_stock' => 'integer',
        'max_stock' => 'integer',
        'track_batch' => 'boolean',
        'track_expiry' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the inventories for the product.
     */
    public function inventories(): HasMany
    {
        return $this->hasMany(\App\Models\Inventory::class);
    }

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include low stock products.
     */
    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock_quantity', '<=', 'reorder_level')
            ->where('is_active', true);
    }

    /**
     * Scope a query to only include out of stock products.
     */
    public function scopeOutOfStock($query)
    {
        return $query->where('stock_quantity', '<=', 0)
            ->where('is_active', true);
    }

    /**
     * Check if product is low in stock.
     */
    public function isLowStock()
    {
        return $this->stock_quantity <= $this->reorder_level;
    }

    /**
     * Check if product is out of stock.
     */
    public function isOutOfStock()
    {
        return $this->stock_quantity <= 0;
    }

    /**
     * Get the total inventory value for this product.
     */
    public function getInventoryValueAttribute()
    {
        return $this->stock_quantity * $this->cost_price;
    }

    /**
     * Get the formatted inventory value.
     */
    public function getFormattedInventoryValueAttribute()
    {
        return '₹' . number_format($this->inventory_value, 2);
    }

    /**
     * Get the stock status.
     */
    public function getStockStatusAttribute()
    {
        if ($this->isOutOfStock()) {
            return 'out_of_stock';
        } elseif ($this->isLowStock()) {
            return 'low_stock';
        } else {
            return 'in_stock';
        }
    }

    /**
     * Get the stock status badge class.
     */
    public function getStockStatusBadgeAttribute()
    {
        switch ($this->stock_status) {
            case 'out_of_stock':
                return 'danger';
            case 'low_stock':
                return 'warning';
            default:
                return 'success';
        }
    }

    /**
     * Get the stock status text.
     */
    public function getStockStatusTextAttribute()
    {
        switch ($this->stock_status) {
            case 'out_of_stock':
                return 'Out of Stock';
            case 'low_stock':
                return 'Low Stock';
            default:
                return 'In Stock';
        }
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
}
