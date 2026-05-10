<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PropertyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can($this->route('property') ? 'update_property' : 'create_property');
    }

    public function rules(): array
    {
        $propertyId = $this->route('property')?->id;

        return [
            'property.property_code' => ['required', 'string', 'max:50', Rule::unique('properties', 'property_code')->ignore($propertyId)],
            'property.property_name' => ['required', 'string', 'max:150'],
            'property.property_type_id' => ['required', 'exists:property_types,id'],
            'property.utilization_status_id' => ['required', 'exists:property_utilization_statuses,id'],
            'property.address' => ['nullable', 'string'],
            'property.province_id' => ['required', 'exists:provinces,id'],
            'property.city_id' => ['required', 'exists:cities,id'],
            'property.district_id' => ['nullable', 'exists:districts,id'],
            'property.village_id' => ['nullable', 'exists:villages,id'],
            'property.postal_code' => ['nullable', 'string', 'max:20'],
            'property.land_area' => ['nullable', 'numeric', 'min:0'],
            'property.building_area' => ['nullable', 'numeric', 'min:0'],
            'property.area_unit' => ['nullable', 'string', 'max:20'],
            'property.latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'property.longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'property.polygon_geojson' => ['nullable', 'json'],
            'property.physical_condition' => ['nullable', 'string', 'max:100'],
            'property.description' => ['nullable', 'string'],
            'property.notes' => ['nullable', 'string'],

            'certificate.certificate_number' => ['required', 'string', 'max:100'],
            'certificate.land_right_type_id' => ['required', 'exists:land_right_types,id'],
            'certificate.certificate_status_id' => ['required', 'exists:certificate_statuses,id'],
            'certificate.holder_name' => ['nullable', 'string', 'max:150'],
            'certificate.measurement_letter_number' => ['nullable', 'string', 'max:100'],
            'certificate.measurement_letter_date' => ['nullable', 'date'],
            'certificate.certificate_area' => ['nullable', 'numeric', 'min:0'],
            'certificate.area_unit' => ['nullable', 'string', 'max:20'],
            'certificate.issued_date' => ['nullable', 'date'],
            'certificate.expired_date' => ['nullable', 'date', 'after_or_equal:certificate.issued_date'],
            'certificate.land_office' => ['nullable', 'string', 'max:150'],
            'certificate.legal_notes' => ['nullable', 'string'],
        ];
    }
}
