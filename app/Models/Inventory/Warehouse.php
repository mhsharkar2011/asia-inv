<?php

namespace App\Models\Inventory;

use App\Models\Branch;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'warehouse_code',
        'warehouse_name',
        'address',
        'capacity',
        'manager_id',
        'is_active'
    ];

    protected $casts = [
        'capacity' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'warehouse_id');
    }

    // Get total inventory value in this warehouse
    public function getTotalInventoryValueAttribute()
    {
        return $this->inventories->sum(function($inventory) {
            return $inventory->quantity_available * $inventory->average_purchase_price;
        });
    }

    // Get total items count
    public function getTotalItemsAttribute()
    {
        return $this->inventories->count();
    }

    // Get capacity usage percentage
    public function getCapacityUsageAttribute()
    {
        if (!$this->capacity || $this->capacity <= 0) {
            return 0;
        }

        $totalVolume = $this->inventories->sum('quantity_available');
        return ($totalVolume / $this->capacity) * 100;
    }
}
