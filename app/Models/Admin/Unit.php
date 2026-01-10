<?php

namespace App\Models\Admin;

use App\Models\Inventory\Product;
use App\Models\Purchase\PurchaseOrderItem;
use App\Models\Sales\SalesOrderItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'unit_code',
        'unit_name',
        'unit_type',
        'base_unit_multiplier',
        'base_unit_id',
        'is_fraction_allowed',
        'decimal_places',
        'is_active',
        'sort_order',
        'description',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'base_unit_multiplier' => 'decimal:6',
        'is_fraction_allowed' => 'boolean',
        'is_active' => 'boolean',
        'decimal_places' => 'integer',
        'sort_order' => 'integer',
    ];

    /**
     * Relationships
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function baseUnit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'base_unit_id');
    }

    public function childUnits(): HasMany
    {
        return $this->hasMany(Unit::class, 'base_unit_id');
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

    public function scopeStandard($query)
    {
        return $query->where('unit_type', 'standard');
    }

    public function scopePacking($query)
    {
        return $query->where('unit_type', 'packing');
    }

    public function scopeShipping($query)
    {
        return $query->where('unit_type', 'shipping');
    }

    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    /**
     * Check if unit is base unit
     */
    public function isBaseUnit(): bool
    {
        return is_null($this->base_unit_id);
    }

    /**
     * Convert quantity to base unit
     */
    public function convertToBase($quantity): float
    {
        return $quantity * $this->base_unit_multiplier;
    }

    /**
     * Convert from base unit to this unit
     */
    public function convertFromBase($quantity): float
    {
        if ($this->base_unit_multiplier == 0) {
            return 0;
        }
        return $quantity / $this->base_unit_multiplier;
    }

    /**
     * Format quantity according to unit's decimal places
     */
    public function formatQuantity($quantity): string
    {
        return number_format($quantity, $this->decimal_places, '.', '');
    }

    /**
     * Get full unit name with code
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->unit_name} ({$this->unit_code})";
    }
}
