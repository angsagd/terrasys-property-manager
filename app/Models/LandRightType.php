<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Casts;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'code', 'description', 'has_expiry', 'is_active'])]
#[Casts(['has_expiry' => 'boolean', 'is_active' => 'boolean'])]
class LandRightType extends Model
{
    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function additionalCertificates(): HasMany
    {
        return $this->hasMany(AdditionalCertificate::class);
    }
}
