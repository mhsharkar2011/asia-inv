<?php

namespace App\Models\Admin;

use App\Models\Inventory\Warehouse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_code',
        'branch_name',
        'branch_type',
        'contact_person',
        'email',
        'phone',
        'alternate_phone',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'country',
        'postal_code',
        'latitude',
        'longitude',
        'opening_time',
        'closing_time',
        'working_days',
        'staff_count',
        'area_sqft',
        'is_head_office',
        'is_active',
        'has_warehouse',
        'has_showroom',
        'description',
        'additional_info'
    ];

    protected $casts = [
        'is_head_office' => 'boolean',
        'is_active' => 'boolean',
        'has_warehouse' => 'boolean',
        'has_showroom' => 'boolean',
        'staff_count' => 'integer',
        'area_sqft' => 'decimal:2',
        'latitude' => 'decimal:10,8',
        'longitude' => 'decimal:11,8',
        'opening_time' => 'datetime:H:i',
        'closing_time' => 'datetime:H:i',
        'additional_info' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = ['full_address', 'operating_hours', 'contact_info'];

    // Relationships
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class,'company_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function warehouses(): HasMany
    {
        return $this->hasMany(Warehouse::class);
    }

    // Accessors
    public function getFullAddressAttribute(): string
    {
        $address = $this->address_line_1;

        if ($this->address_line_2) {
            $address .= ', ' . $this->address_line_2;
        }

        $address .= ', ' . $this->city;

        if ($this->state) {
            $address .= ', ' . $this->state;
        }

        $address .= ', ' . $this->country;

        if ($this->postal_code) {
            $address .= ' - ' . $this->postal_code;
        }

        return $address;
    }

    public function getOperatingHoursAttribute(): string
    {
        return $this->opening_time->format('h:i A') . ' - ' . $this->closing_time->format('h:i A');
    }

    public function getContactInfoAttribute(): array
    {
        return [
            'contact_person' => $this->contact_person,
            'email' => $this->email,
            'phone' => $this->phone,
            'alternate_phone' => $this->alternate_phone,
        ];
    }

    public function getMapUrlAttribute(): ?string
    {
        if ($this->latitude && $this->longitude) {
            return "https://www.google.com/maps?q={$this->latitude},{$this->longitude}";
        }
        return null;
    }

    public function getStatusBadgeAttribute(): string
    {
        if ($this->is_head_office) {
            return '<span class="badge bg-purple">Head Office</span>';
        }

        return $this->is_active
            ? '<span class="badge bg-success">Active</span>'
            : '<span class="badge bg-danger">Inactive</span>';
    }

    public function getTypeBadgeAttribute(): string
    {
        $badges = [
            'retail' => 'bg-primary',
            'warehouse' => 'bg-warning',
            'office' => 'bg-info',
            'factory' => 'bg-secondary',
            'distribution' => 'bg-success',
            'service' => 'bg-danger',
        ];

        $color = $badges[$this->branch_type] ?? 'bg-dark';
        $label = ucfirst($this->branch_type);

        return "<span class='badge {$color}'>{$label}</span>";
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function scopeHeadOffice($query)
    {
        return $query->where('is_head_office', true);
    }

    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('branch_type', $type);
    }

    public function scopeByCity($query, $city)
    {
        return $query->where('city', 'like', "%{$city}%");
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('branch_name', 'like', "%{$search}%")
                    ->orWhere('branch_code', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('contact_person', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
    }

    public function scopeWithWarehouse($query)
    {
        return $query->where('has_warehouse', true);
    }

    // Methods
    public function canBeDeleted(): bool
    {
        return $this->users()->count() === 0 && $this->warehouses()->count() === 0;
    }

    public function updateStaffCount(): void
    {
        $this->update(['staff_count' => $this->users()->count()]);
    }

    // Auto-generate branch code
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($branch) {
            if (empty($branch->branch_code)) {
                $prefix = strtoupper(substr($branch->branch_name, 0, 3));
                $count = self::where('company_id', $branch->company_id)->count() + 1;
                $branch->branch_code = $prefix . str_pad($count, 3, '0', STR_PAD_LEFT);
            }
        });

        static::created(function ($branch) {
            // If this is the first branch for the company, make it head office
            if (self::where('company_id', $branch->company_id)->count() === 1) {
                $branch->update(['is_head_office' => true]);
            }
        });
    }
}
