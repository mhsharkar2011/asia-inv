<?php

namespace App\Models\Sales;

use App\Models\Inventory\Product;
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
        'discount',
        'tax_amount',
        'amount',
    ];

    // protected $guarded = [];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
            $item->calculateTotals();
        });
    }

    public function getTotalAttribute()
    {
        return $this->quantity * $this->unit_price;
    }

    public function getTaxableAmountAttribute()
    {
        $itemTotal = $this->quantity * $this->unit_price;
        return $itemTotal - $this->discount;
    }

    public function getTotalAmountAttribute()
    {
        return $this->taxable_amount + $this->tax_amount;
    }

    public function getDiscountAttribute()
    {
        $itemTotal = $this->quantity * $this->unit_price;
        return (string)($itemTotal * ($this->discount_percentage / 100));
    }

    public function getTaxAmountAttribute()
    {
        $taxableAmount = $this->total - $this->discount;
        return (string)($taxableAmount * 0.18); // 18% GST
    }

    public function getAmountAttribute()
    {
        return (string)($this->taxable_amount + $this->tax_amount);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }


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
        $this->discount = (string)($itemTotal * ($this->discount_percentage / 100));
        $taxableAmount = $itemTotal - $this->discount;
        $this->tax_amount = (string)($taxableAmount * 0.18); // 18% GST
        $this->total_amount = (string)($taxableAmount + $this->tax_amount);

        return $this;
    }
}
