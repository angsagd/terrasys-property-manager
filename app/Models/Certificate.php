<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Casts;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'property_id', 'certificate_number', 'land_right_type_id', 'certificate_status_id',
    'holder_name', 'measurement_letter_number', 'measurement_letter_date',
    'certificate_area', 'area_unit', 'issued_date', 'expired_date', 'land_office',
    'legal_notes', 'created_by', 'updated_by', 'deleted_by',
])]
#[Casts([
    'measurement_letter_date' => 'date',
    'issued_date' => 'date',
    'expired_date' => 'date',
    'certificate_area' => 'decimal:2',
])]
class Certificate extends Model
{
    use SoftDeletes;

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function landRightType(): BelongsTo
    {
        return $this->belongsTo(LandRightType::class);
    }

    public function certificateStatus(): BelongsTo
    {
        return $this->belongsTo(CertificateStatus::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
