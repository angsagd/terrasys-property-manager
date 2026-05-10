<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Casts;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'description', 'color', 'is_active'])]
#[Casts(['is_active' => 'boolean'])]
class PropertyUtilizationStatus extends Model
{
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class, 'utilization_status_id');
    }
}
