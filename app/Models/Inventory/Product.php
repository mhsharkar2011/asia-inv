<?php

namespace App\Models\Inventory;

use App\Models\Inventory\Category;
use App\Models\Inventory\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'category_id',
        'product_code',
        'product_name',
        'description',
        'unit_of_measure',
        'reorder_level',
        'min_stock',
        'max_stock',
        'hsn_sac_code',
        'tax_rate',
        'purchase_price',
        'selling_price',
        'mrp',
        'track_batch',
        'track_expiry',
        'is_active'
    ];

    protected $casts = [
        'tax_rate' => 'decimal:2',
        'purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'mrp' => 'decimal:2',
        'track_batch' => 'boolean',
        'track_expiry' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Temporarily comment out until we create Inventory model
    // public function inventories()
    // {
    //     return $this->hasMany(Inventory::class, 'product_id');
    // }

    // Get total available stock across all warehouses
    public function getTotalStockAttribute()
    {
        // Temporarily return 0 until we have inventory
        return 0;
        // return $this->inventories->sum('quantity_available');
    }

    // Get total reserved stock across all warehouses
    public function getTotalReservedAttribute()
    {
        // Temporarily return 0 until we have inventory
        return 0;
        // return $this->inventories->sum('quantity_reserved');
    }

    // Get total inventory value
    public function getTotalInventoryValueAttribute()
    {
        // Temporarily return 0 until we have inventory
        return 0;
        // return $this->inventories->sum(function ($inventory) {
        //     return $this->purchase_price * $inventory->quantity_available;
        // });
    }

    // Check if product is low stock
    public function getIsLowStockAttribute()
    {
        return $this->total_stock <= $this->reorder_level && $this->total_stock > 0;
    }

    // Check if product is out of stock
    public function getIsOutOfStockAttribute()
    {
        return $this->total_stock <= 0;
    }

    // Check if product is overstock
    public function getIsOverstockAttribute()
    {
        if (!$this->max_stock) {
            return false;
        }
        return $this->total_stock > $this->max_stock;
    }

    // Scope for active products
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for low stock products
    public function scopeLowStock($query)
    {
        // Simplified for now - check only against reorder level
        return $query->where('reorder_level', '>', 0);
        // Original complex query:
        // return $query->whereRaw('(SELECT COALESCE(SUM(quantity_available), 0) FROM inventories WHERE product_id = products.id) <= reorder_level')
        //     ->whereRaw('(SELECT COALESCE(SUM(quantity_available), 0) FROM inventories WHERE product_id = products.id) > 0');
    }

    // Scope for out of stock products
    public function scopeOutOfStock($query)
    {
        // Simplified for now - always return none
        return $query->where('id', '<', 0);
        // Original:
        // return $query->whereRaw('(SELECT COALESCE(SUM(quantity_available), 0) FROM inventories WHERE product_id = products.id) <= 0');
    }
}
