<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'category_id',
        'product_code',
        'product_name',
        'description',
        'category',
        'unit',
        'cost_price',
        'selling_price',
        'stock_quantity',
        'reorder_level',
        'hs_code',
        'ait_rate',
        'status',
    ];

    protected $casts = [
        'cost_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'reorder_level' => 'integer',
        'ait_rate' => 'decimal:2',
    ];


    /**
     * Scope a query to only include low stock products.
     */

    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock_quantity', '<=', 'reorder_level')
            ->where('stock_quantity', '>', 0);
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('stock_quantity', '<=', 0);
    }
    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0)
            ->whereColumn('stock_quantity', '>', 'reorder_level');
    }
    /**
     * Check if product is low in stock.
     */
    public function isLowStock()
    {
        return $this->stock_quantity <= $this->reorder_level;
    }

    /**
     * Generate product code.
     */
    public static function generateProductCode()
    {
        $prefix = 'PROD-';
        $year = date('Y');
        $month = date('m');

        $lastProduct = self::where('product_code', 'like', $prefix . $year . $month . '%')
            ->orderBy('product_code', 'desc')
            ->first();

        if ($lastProduct) {
            $lastNumber = intval(substr($lastProduct->product_code, -4));
            $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '0001';
        }

        return $prefix . $year . $month . $nextNumber;
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
