<?php

namespace App\Models\Admin;

use App\Models\Inventory\Product;
use App\Models\Purchase\PurchaseOrderItem;
use App\Models\Sales\Invoice;
use App\Models\Sales\SalesOrderItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tax extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'tax_code',
        'tax_name',
        'tax_rate',
        'tax_type',
        'is_compound',
        'is_active',
        'applicable_on',
        'effective_from',
        'effective_to',
        'description',
        'calculation_method',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tax_rate' => 'decimal:4',
        'is_compound' => 'boolean',
        'is_active' => 'boolean',
        'effective_from' => 'date',
        'effective_to' => 'date',
        'calculation_method' => 'array',
    ];

    /**
     * Relationships
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function purchaseItems(): HasMany
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function saleItems(): HasMany
    {
        return $this->hasMany(SalesOrderItem::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSales($query)
    {
        return $query->where('applicable_on', 'sales')->orWhere('applicable_on', 'both');
    }

    public function scopePurchase($query)
    {
        return $query->where('applicable_on', 'purchase')->orWhere('applicable_on', 'both');
    }

    public function scopePercentage($query)
    {
        return $query->where('tax_type', 'percentage');
    }

    public function scopeFixed($query)
    {
        return $query->where('tax_type', 'fixed');
    }

    public function scopeCompound($query)
    {
        return $query->where('is_compound', true);
    }

    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    public function scopeEffective($query, $date = null)
    {
        $date = $date ?? now();
        return $query->where(function ($q) use ($date) {
            $q->whereNull('effective_from')->orWhere('effective_from', '<=', $date);
        })->where(function ($q) use ($date) {
            $q->whereNull('effective_to')->orWhere('effective_to', '>=', $date);
        });
    }

    /**
     * Calculate tax amount
     */
    public function calculate($amount): float
    {
        if ($this->tax_type === 'percentage') {
            return ($amount * $this->tax_rate) / 100;
        }

        return $this->tax_rate; // For fixed tax
    }

    /**
     * Check if tax is currently effective
     */
    public function isEffective($date = null): bool
    {
        $date = $date ?? now();

        if ($this->effective_from && $this->effective_from > $date) {
            return false;
        }

        if ($this->effective_to && $this->effective_to < $date) {
            return false;
        }

        return true;
    }

    /**
     * Check if tax applies to sales
     */
    public function appliesToSales(): bool
    {
        return in_array($this->applicable_on, ['sales', 'both']);
    }

    /**
     * Check if tax applies to purchases
     */
    public function appliesToPurchases(): bool
    {
        return in_array($this->applicable_on, ['purchase', 'both']);
    }

    /**
     * Get full tax name with rate
     */
    public function getFullNameAttribute(): string
    {
        if ($this->tax_type === 'percentage') {
            return "{$this->tax_name} ({$this->tax_rate}%)";
        }

        return "{$this->tax_name} (₤{$this->tax_rate})";
    }

    /**
     * Get display rate
     */
    public function getDisplayRateAttribute(): string
    {
        if ($this->tax_type === 'percentage') {
            return "{$this->tax_rate}%";
        }

        return "₤{$this->tax_rate}";
    }
}
