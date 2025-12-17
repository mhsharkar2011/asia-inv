<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'branch_code',
        'branch_name',
        'address',
        'contact_person',
        'phone',
        'email',
        'is_main_branch',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'branch_id');
    }
}
