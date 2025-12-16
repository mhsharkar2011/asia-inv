<?php

namespace App\Models\Sales;

use App\Models\Inventory\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'gstin',
        'pan_number',
        'credit_limit',
        'outstanding_balance',
        'is_active',
        'notes'
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
        'outstanding_balance' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relationship with Company
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    // Relationship with Sales Orders
    public function salesOrders()
    {
        return $this->hasMany(SalesOrder::class, 'customer_id');
    }

    // Get total sales amount
    public function getTotalSalesAttribute()
    {
        return $this->salesOrders()->where('status', 'delivered')->sum('final_amount');
    }

    // Get pending sales orders count
    public function getPendingOrdersCountAttribute()
    {
        return $this->salesOrders()->whereIn('status', ['draft', 'confirmed', 'packed', 'shipped'])->count();
    }

    // Get completed sales orders count
    public function getCompletedOrdersCountAttribute()
    {
        return $this->salesOrders()->where('status', 'delivered')->count();
    }

    // Get credit available
    public function getCreditAvailableAttribute()
    {
        if (!$this->credit_limit) {
            return 0;
        }
        return max(0, $this->credit_limit - $this->outstanding_balance);
    }

    // Get credit usage percentage
    public function getCreditUsagePercentageAttribute()
    {
        if (!$this->credit_limit || $this->credit_limit <= 0) {
            return 0;
        }
        return ($this->outstanding_balance / $this->credit_limit) * 100;
    }

    // Check if credit limit exceeded
    public function getIsCreditLimitExceededAttribute()
    {
        if (!$this->credit_limit) {
            return false;
        }
        return $this->outstanding_balance > $this->credit_limit;
    }

    // Scope for active customers
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for customers with credit limit
    public function scopeHasCreditLimit($query)
    {
        return $query->whereNotNull('credit_limit')->where('credit_limit', '>', 0);
    }

    // Scope for customers with outstanding balance
    public function scopeHasOutstandingBalance($query)
    {
        return $query->where('outstanding_balance', '>', 0);
    }

    // Scope by customer type
    public function scopeByType($query, $type)
    {
        return $query->where('customer_type', $type);
    }

    // Format GSTIN for display
    public function getFormattedGstinAttribute()
    {
        if (!$this->gstin) {
            return null;
        }

        $gstin = strtoupper($this->gstin);
        if (strlen($gstin) === 15) {
            return substr($gstin, 0, 2) . '-' . substr($gstin, 2, 10) . '-' . substr($gstin, 12, 3);
        }

        return $gstin;
    }
}
