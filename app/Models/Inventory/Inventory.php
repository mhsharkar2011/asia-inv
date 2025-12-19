<?php

namespace App\Models\Inventory;

use App\Models\Inventory\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'warehouse_id',
        'batch_number',
        'expiry_date',
        'quantity_available',
        'quantity_reserved',
        'average_purchase_price',
        'last_purchase_date',
        'last_sale_date'
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'last_purchase_date' => 'date',
        'last_sale_date' => 'date',
        'quantity_available' => 'decimal:2',
        'quantity_reserved' => 'decimal:2',
        'average_purchase_price' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function warehouse()
    {
        // return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    // Get total quantity (available + reserved)
    public function getTotalQuantityAttribute()
    {
        return $this->quantity_available + $this->quantity_reserved;
    }

    // Get inventory value
    public function getInventoryValueAttribute()
    {
        return $this->quantity_available * $this->average_purchase_price;
    }

    // Check if stock is low
    public function getIsLowStockAttribute()
    {
        if (!$this->product) {
            return false;
        }

        return $this->quantity_available <= $this->product->reorder_level && $this->quantity_available > 0;
    }

    // Check if out of stock
    public function getIsOutOfStockAttribute()
    {
        return $this->quantity_available <= 0;
    }
}
