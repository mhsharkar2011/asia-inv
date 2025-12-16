<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'order_date', 'total_amount', 'status'];

    // Relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Assumes an intermediary table for many-to-many relationship with Products
    public function items()
    {
        return $this->belongsToMany(
            \App\Models\Inventory\Product::class,
            'sales_order_items'
        )->withPivot('quantity', 'unit_price');
    }
}
