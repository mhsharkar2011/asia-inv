<?php

namespace App\Models\Admin;

use App\Models\Sales\Invoice;
use App\Models\Sales\SalesOrder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'type',
        'sub_type',
        'contact_person',
        'email',
        'phone',
        'mobile',
        'address',
        'city',
        'district',
        'country',
        'postal_code',
        'latitude',
        'longitude',
        'tin',
        'bin',
        'website',
        'logo',
        'currency',
        'is_active',
        'timezone',
        'language',
        'credit_limit',
        'outstanding_balance',
        'payment_terms',
        'advance_payment_percentage',
        'notes',
        'description'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sub_type' => 'string',
        'credit_limit' => 'decimal:2',
        'outstanding_balance' => 'decimal:2',
        'advance_payment_percentage' => 'decimal:2',
        'latitude' => 'decimal:10,8',
        'longitude' => 'decimal:11,8',
    ];


    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'customer_id');
    }
    public function salesOrders(): HasMany
    {
        return $this->hasMany(SalesOrder::class, 'customer_id');
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

    // Add local scopes
    public function scopeCompanies(Builder $query): Builder
    {
        return $query->where('type', 'company');
    }

    public function scopeCustomers(Builder $query): Builder
    {
        return $query->where('type', 'customer'); // or appropriate condition
    }

    public function scopeSuppliers(Builder $query): Builder
    {
        return $query->where('type', 'supplier'); // or appropriate condition
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
            ->orWhere('code', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->orWhere('phone', 'like', "%{$search}%")
            ->orWhere('contact_person', 'like', "%{$search}%");
    }

    // Relationships
    public function relatedCompanies(): HasMany
    {
        return $this->hasMany(OrganizationRelationship::class, 'related_id');
    }

    public function customers(): HasMany
    {
        return $this->hasMany(OrganizationRelationship::class, 'company_id')
            ->where('relationship_type', 'customer_of')
            ->with('relatedOrganization');
    }

    public function suppliers(): HasMany
    {
        return $this->hasMany(OrganizationRelationship::class, 'company_id')
            ->where('relationship_type', 'supplier_of')
            ->with('relatedOrganization');
    }

    // Helper Methods
    public function isCompany(): bool
    {
        return $this->type === 'company';
    }

    public function isCustomer(): bool
    {
        return $this->type === 'customer';
    }

    public function isSupplier(): bool
    {
        return $this->type === 'supplier';
    }

    // Auto-generate code based on type
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($organization) {
            if (empty($organization->code)) {
                $prefix = match ($organization->type) {
                    'company' => 'COMP',
                    'customer' => 'CUST',
                    'supplier' => 'SUPP',
                    default => 'ORG'
                };

                $count = self::where('type', $organization->type)->count() + 1;
                $organization->code = $prefix . str_pad($count, 5, '0', STR_PAD_LEFT);
            }
        });
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'company_id');
    }   
}
