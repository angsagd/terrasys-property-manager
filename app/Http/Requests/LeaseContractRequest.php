<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LeaseContractRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can($this->route('lease_contract') ? 'update_lease' : 'create_lease');
    }

    public function rules(): array
    {
        return [
            'property_id' => ['required', 'exists:properties,id'],
            'lease_type_id' => ['required', 'exists:lease_types,id'],
            'lease_status_id' => ['required', 'exists:lease_statuses,id'],
            'counterparty_name' => ['required', 'string', 'max:150'],
            'counterparty_address' => ['nullable', 'string'],
            'agreement_number' => ['nullable', 'string', 'max:100'],
            'agreement_date' => ['nullable', 'date'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'rental_value' => ['nullable', 'numeric', 'min:0'],
            'payment_period' => ['required', Rule::in(['monthly', 'quarterly', 'semesterly', 'yearly', 'one_time'])],
            'payment_status' => ['nullable', 'string', 'max:100'],
            'reminder_date' => ['nullable', 'date', 'before_or_equal:end_date'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
