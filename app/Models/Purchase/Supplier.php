<?php

namespace App\Models\Purchase;

use App\Models\Inventory\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'supplier_code',
        'supplier_name',
        'contact_person',
        'phone',
        'email',
        'address',
        'gstin',
        'pan_number',
        'credit_limit',
        'payment_terms',
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

    // Relationship with Purchase Orders
    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class, 'supplier_id');
    }

    // Get total purchases amount
    public function getTotalPurchasesAttribute()
    {
        return $this->purchaseOrders()->where('status', 'completed')->sum('final_amount');
    }

    // Get pending purchase orders count
    public function getPendingOrdersCountAttribute()
    {
        return $this->purchaseOrders()->whereIn('status', ['draft', 'pending', 'partial'])->count();
    }

    // Get completed purchase orders count
    public function getCompletedOrdersCountAttribute()
    {
        return $this->purchaseOrders()->where('status', 'completed')->count();
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

    // Scope for active suppliers
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for suppliers with credit limit
    public function scopeHasCreditLimit($query)
    {
        return $query->whereNotNull('credit_limit')->where('credit_limit', '>', 0);
    }

    // Scope for suppliers with outstanding balance
    public function scopeHasOutstandingBalance($query)
    {
        return $query->where('outstanding_balance', '>', 0);
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
