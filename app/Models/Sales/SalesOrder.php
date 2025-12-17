<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalesOrder extends Model
{
    use HasFactory;

    // In SalesOrder model
    protected $fillable = [
        'order_number',
        'customer_id',
        'order_date',
        'delivery_date',
        'sales_person',
        'reference_number',
        'shipping_address',
        'billing_address',
        'shipping_method',
        'payment_terms',
        'payment_status',
        'due_date',
        'status',
        'tax_rate',
        'shipping_charges',
        'adjustment',
        'notes',
        'terms_conditions',
        'currency',
        'created_by',
        'subtotal',
        'discount',
        'total_amount',
        'taxable_amount',
        'tax_amount',
        'total_amount',
        'description',
    ];


    protected $guarded = [];

    protected $casts = [
        'order_date' => 'date',
        'delivery_date' => 'date',
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'taxable_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'shipping_charges' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get the customer that owns the sales order.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the items for the sales order.
     */
    public function items()
    {
        // return $this->hasMany(SalesOrderItem::class);
    }

    /**
     * Scope a query to only include draft orders.
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope a query to only include confirmed orders.
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Generate a unique order number.
     */
    public static function generateOrderNumber()
    {
        $prefix = 'SO-';
        $year = date('Y');
        $month = date('m');

        $lastOrder = self::where('order_number', 'like', $prefix . $year . $month . '%')
            ->orderBy('order_number', 'desc')
            ->first();

        if ($lastOrder) {
            $lastNumber = intval(substr($lastOrder->order_number, -4));
            $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '0001';
        }

        return $prefix . $year . $month . $nextNumber;
    }

    /**
     * Calculate order totals.
     */
    public function calculateTotals()
    {
        $subtotal = 0;
        $totalDiscount = 0;

        foreach ($this->items as $item) {
            $subtotal += $item->quantity * $item->unit_price;
            $totalDiscount += $item->discount;
        }

        $taxableAmount = $subtotal - $totalDiscount;
        $taxAmount = $taxableAmount * 0.18; // 18% GST
        $totalAmount = $taxableAmount + $taxAmount + $this->shipping_charges;

        $this->update([
            'subtotal' => $subtotal,
            'discount' => $totalDiscount,
            'taxable_amount' => $taxableAmount,
            'tax_amount' => $taxAmount,
            'total_amount' => $totalAmount,
        ]);
    }
}
