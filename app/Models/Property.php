<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Casts;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'property_code', 'property_name', 'property_type_id', 'utilization_status_id',
    'address', 'province_id', 'city_id', 'district_id', 'village_id', 'postal_code',
    'land_area', 'building_area', 'area_unit', 'latitude', 'longitude', 'polygon_geojson',
    'physical_condition', 'description', 'notes', 'is_active', 'created_by', 'updated_by', 'deleted_by',
])]
#[Casts([
    'is_active' => 'boolean',
    'land_area' => 'decimal:2',
    'building_area' => 'decimal:2',
    'latitude' => 'decimal:7',
    'longitude' => 'decimal:7',
])]
class Property extends Model
{
    use SoftDeletes;

    public function certificate(): HasOne
    {
        return $this->hasOne(Certificate::class);
    }

    public function additionalCertificates(): HasMany
    {
        return $this->hasMany(AdditionalCertificate::class);
    }

    public function leaseContracts(): HasMany
    {
        return $this->hasMany(LeaseContract::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function propertyType(): BelongsTo
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function utilizationStatus(): BelongsTo
    {
        return $this->belongsTo(PropertyUtilizationStatus::class, 'utilization_status_id');
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }
}
