<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('upload_document');
    }

    public function rules(): array
    {
        return [
            'document_category_id' => ['required', 'exists:document_categories,id'],
            'property_id' => ['nullable', 'required_without_all:certificate_id,additional_certificate_id,lease_contract_id', 'exists:properties,id'],
            'certificate_id' => ['nullable', 'required_without_all:property_id,additional_certificate_id,lease_contract_id', 'exists:certificates,id'],
            'additional_certificate_id' => ['nullable', 'required_without_all:property_id,certificate_id,lease_contract_id', 'exists:additional_certificates,id'],
            'lease_contract_id' => ['nullable', 'required_without_all:property_id,certificate_id,additional_certificate_id', 'exists:lease_contracts,id'],
            'document_name' => ['required', 'string', 'max:150'],
            'document_number' => ['nullable', 'string', 'max:100'],
            'document_date' => ['nullable', 'date'],
            'expired_date' => ['nullable', 'date'],
            'description' => ['nullable', 'string'],
            'file' => ['required', 'file', 'max:10240', 'mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx'],
        ];
    }
}
