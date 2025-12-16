<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $primaryKey = 'company_id';
    protected $fillable = [
        'company_name',
        'registration_no',
        'tax_id',
        'address',
        'country',
        'currency_base',
        'fiscal_year_start',
        'gst_registered',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'company_id');
    }

    public function branches()
    {
        return $this->hasMany(Branch::class, 'company_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'company_id');
    }
}
