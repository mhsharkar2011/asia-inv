<?php

namespace App\Models\Sales;

use App\Models\Sales\Invoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'product_id',
        'description',
        'quantity',
        'unit_price',
        'total',
        // Add other fields as needed
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    // Relationships
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Inventory\Product::class);
    }

    // Calculate total before saving
    public static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
            if ($item->quantity && $item->unit_price) {
                $item->total = $item->quantity * $item->unit_price;
            }
        });
    }
}
