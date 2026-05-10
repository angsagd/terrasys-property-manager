<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Casts;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'description', 'color', 'is_active'])]
#[Casts(['is_active' => 'boolean'])]
class LeaseStatus extends Model
{
    public function leaseContracts(): HasMany
    {
        return $this->hasMany(LeaseContract::class);
    }
}
