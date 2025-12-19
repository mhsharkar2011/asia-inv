<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationRelationship extends Model
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
        return $this->belongsTo(Organization::class, 'company_id');
    }

    public function relatedOrganization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'related_id');
    }
}
