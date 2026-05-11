<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravolt\Indonesia\Models\Province as LaravoltProvince;

class Province extends LaravoltProvince
{
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }
}
