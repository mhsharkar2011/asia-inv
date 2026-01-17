<?php

namespace App\Models\Admin;

use App\Models\Admin\User;
use App\Models\Inventory\Inventory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'location',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'phone',
        'email',
        'manager_name',
        'manager_phone',
        'manager_email',
        'capacity',
        'used_capacity',
        'status',
        'is_default',
        'notes',
        'settings',
        'created_by',
        'updated_by',
        'deleted_at',
    ];

    protected $casts = [
        'capacity' => 'decimal:2',
        'used_capacity' => 'decimal:2',
        'is_default' => 'boolean',
        'settings' => 'array',
    ];

    protected $attributes = [
        'status' => '1',
    ];

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // public function zones()
    // {
    //     return $this->hasMany(WarehouseZone::class);
    // }

    // public function racks()
    // {
    //     return $this->hasMany(WarehouseRack::class);
    // }

    // public function bins()
    // {
    //     return $this->hasMany(WarehouseBin::class);
    // }

    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    // Methods
    public function getAvailableCapacityAttribute()
    {
        return $this->capacity - $this->used_capacity;
    }

    public function getCapacityPercentageAttribute()
    {
        if ($this->capacity <= 0) {
            return 0;
        }
        return ($this->used_capacity / $this->capacity) * 100;
    }

    public function isFull()
    {
        return $this->available_capacity <= 0;
    }

    public function markAsDefault()
    {
        // Remove default from other warehouses
        self::where('is_default', true)->update(['is_default' => false]);

        // Set this as default
        $this->update(['is_default' => true]);
    }

    public function updateUsedCapacity($quantity)
    {
        $this->used_capacity += $quantity;
        if ($this->used_capacity < 0) {
            $this->used_capacity = 0;
        }
        $this->save();
    }
}
