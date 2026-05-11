<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravolt\Indonesia\Models\City as LaravoltCity;

class City extends LaravoltCity
{
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }
}
