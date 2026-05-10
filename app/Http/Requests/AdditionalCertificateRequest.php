<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdditionalCertificateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can($this->route('additional_certificate') ? 'update_additional_certificate' : 'create_additional_certificate');
    }

    public function rules(): array
    {
        return [
            'property_id' => ['required', 'exists:properties,id'],
            'document_number' => ['nullable', 'string', 'max:100'],
            'document_type' => ['nullable', 'string', 'max:100'],
            'land_right_type_id' => ['nullable', 'exists:land_right_types,id'],
            'holder_name' => ['nullable', 'string', 'max:150'],
            'issued_date' => ['nullable', 'date'],
            'expired_date' => ['nullable', 'date', 'after_or_equal:issued_date'],
            'relationship_description' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
