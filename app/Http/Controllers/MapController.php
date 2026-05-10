<?php

namespace App\Http\Controllers;

use App\Models\Property;

class MapController extends Controller
{
    public function index()
    {
        $this->authorize('view_map');

        return view('map.index');
    }

    public function data()
    {
        $this->authorize('view_map');

        $properties = Property::with(['certificate.landRightType', 'utilizationStatus', 'province', 'city'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return response()->json($properties->map(fn ($property) => [
            'id' => $property->id,
            'property_code' => $property->property_code,
            'property_name' => $property->property_name,
            'latitude' => $property->latitude,
            'longitude' => $property->longitude,
            'polygon_geojson' => $property->polygon_geojson ? json_decode($property->polygon_geojson, true) : null,
            'province' => $property->province?->name,
            'city' => $property->city?->name,
            'status' => $property->utilizationStatus?->name,
            'land_right' => $property->certificate?->landRightType?->name,
            'detail_url' => route('properties.show', $property),
        ]));
    }
}
