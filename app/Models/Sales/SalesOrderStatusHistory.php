<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;

class SalesOrderStatusHistory extends Model
{
    protected $fillable = [
        'sales_order_id',
        'previous_status',
        'new_status',
        'changed_by',
        'changed_at',
        'remarks',
    ];

    protected $casts = [
        'changed_at' => 'datetime',
    ];

    /**
     * Get the sales order that owns the status history.
     */
    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    
}
