<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['code', 'name'])]
class Province extends Model
{
    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }
}
