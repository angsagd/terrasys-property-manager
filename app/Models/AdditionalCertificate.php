<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Casts;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'property_id', 'document_number', 'document_type', 'land_right_type_id',
    'holder_name', 'issued_date', 'expired_date', 'relationship_description',
    'notes', 'created_by', 'updated_by', 'deleted_by',
])]
#[Casts(['issued_date' => 'date', 'expired_date' => 'date'])]
class AdditionalCertificate extends Model
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

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
