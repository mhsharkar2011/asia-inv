<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'company_id',
        'image_path',
        'image_name',
        'is_primary',
        'display_order'
    ];

    protected $casts = [
        'is_primary' => 'boolean'
    ];

    // Relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }
}
