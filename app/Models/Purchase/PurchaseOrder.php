<?php

namespace App\Models\Purchase;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = ['supplier_id', 'order_date', 'total_amount', 'status'];

    // Relationships
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // Assumes an intermediary table for many-to-many relationship with Products
    public function items()
    {
        return $this->belongsToMany(
            \App\Models\Inventory\Product::class,
            'purchase_order_items'
        )->withPivot('quantity', 'unit_price');
    }
}
