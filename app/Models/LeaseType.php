<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Casts;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'description', 'is_active'])]
#[Casts(['is_active' => 'boolean'])]
class LeaseType extends Model
{
    public function leaseContracts(): HasMany
    {
        return $this->hasMany(LeaseContract::class);
    }
}
