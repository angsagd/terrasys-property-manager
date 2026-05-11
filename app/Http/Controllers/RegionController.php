<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\District;
use App\Models\Province;
use App\Models\Village;

class RegionController extends Controller
{
    public function cities(Province $province)
    {
        return City::where('province_code', $province->code)
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    public function districts(City $city)
    {
        return District::where('city_code', $city->code)
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    public function villages(District $district)
    {
        return Village::where('district_code', $district->code)
            ->orderBy('name')
            ->get(['id', 'name']);
    }
}
