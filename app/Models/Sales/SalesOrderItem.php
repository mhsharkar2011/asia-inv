<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalesOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_order_id',
        'description',
        'quantity',
        'unit_price',
        'discount_percentage',
        'discount_amount',
        'tax_amount',
        'total_amount',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get the sales order that owns the item.
     */
    public function salesOrder(): BelongsTo
    {
        return $this->belongsTo(SalesOrder::class);
    }

    /**
     * Calculate item totals.
     */
    public function calculateTotals()
    {
        $itemTotal = $this->quantity * $this->unit_price;
        $this->discount_amount = $itemTotal * ($this->discount_percentage / 100);
        $taxableAmount = $itemTotal - $this->discount_amount;
        $this->tax_amount = $taxableAmount * 0.18; // 18% GST
        $this->total_amount = $taxableAmount + $this->tax_amount;

        return $this;
    }
}
