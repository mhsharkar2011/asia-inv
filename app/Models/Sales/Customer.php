<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'customer_code',
        'customer_name',
        'customer_type',
        'contact_person',
        'phone',
        'email',
        'address',
        'notes',
        'tin',
        'bin_number',
        'tax_reg_number',
        'credit_limit',
        'payment_terms',
        'opening_balance',
        'account_number',
        'bank_name',
        'ifsc_code',
        'website',
        'industry',
        'status',
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
        'opening_balance' => 'decimal:2',
    ];

    /**
     * Get the invoices for the customer.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(\App\Models\Invoice::class, 'customer_id');
    }

    /**
     * Get the sales orders for the customer.
     */
    public function salesOrders(): HasMany
    {
        return $this->hasMany(\App\Models\Sales\SalesOrder::class, 'customer_id');
    }

    /**
     * Get the total invoice amount for the customer.
     */
    public function getTotalInvoiceAmountAttribute()
    {
        return $this->invoices()->sum('total_amount');
    }

    /**
     * Get the total sales order amount for the customer.
     */
    public function getTotalOrderAmountAttribute()
    {
        return $this->salesOrders()->sum('total_amount');
    }

    /**
     * Get the total outstanding amount for the customer.
     */
    public function getTotalOutstandingAttribute()
    {
        return $this->invoices()->where('status', '!=', 'paid')->sum('balance_due');
    }

    /**
     * Check if customer has exceeded credit limit.
     */
    public function hasExceededCreditLimit(): bool
    {
        if (!$this->credit_limit) {
            return false;
        }

        $totalOutstanding = $this->getTotalOutstandingAttribute();
        return $totalOutstanding > $this->credit_limit;
    }

    /**
     * Get customer's credit utilization percentage.
     */
    public function getCreditUtilizationAttribute()
    {
        if (!$this->credit_limit) {
            return 0;
        }

        $totalOutstanding = $this->getTotalOutstandingAttribute();
        return ($totalOutstanding / $this->credit_limit) * 100;
    }

    /**
     * Scope a query to only include active customers.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include customers with outstanding balance.
     */
    public function scopeWithOutstanding($query)
    {
        return $query->whereHas('invoices', function ($q) {
            $q->where('status', '!=', 'paid')
                ->where('balance_due', '>', 0);
        });
    }

    /**
     * Generate customer code.
     */
    public static function generateCustomerCode()
    {
        $prefix = 'CUST-';
        $year = date('Y');
        $month = date('m');

        $lastCustomer = self::where('customer_code', 'like', $prefix . $year . $month . '%')
            ->orderBy('customer_code', 'desc')
            ->first();

        if ($lastCustomer) {
            $lastNumber = intval(substr($lastCustomer->customer_code, -4));
            $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '0001';
        }

        return $prefix . $year . $month . $nextNumber;
    }
}
