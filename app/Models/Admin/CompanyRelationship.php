<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyRelationship extends Model
{
    protected $fillable = [
        'company_id',
        'related_id',
        'relationship_type',
        'settings'
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function relatedCompany(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'related_id');
    }
}
