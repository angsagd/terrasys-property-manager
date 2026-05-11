<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaseContract extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'property_id', 'lease_type_id', 'lease_status_id', 'counterparty_name',
        'counterparty_address', 'agreement_number', 'agreement_date', 'start_date',
        'end_date', 'rental_value', 'payment_period', 'payment_status', 'reminder_date',
        'notes', 'created_by', 'updated_by', 'deleted_by',
    ];

    protected function casts(): array
    {
        return [
            'agreement_date' => 'date',
            'start_date' => 'date',
            'end_date' => 'date',
            'reminder_date' => 'date',
            'rental_value' => 'decimal:2',
        ];
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function leaseType(): BelongsTo
    {
        return $this->belongsTo(LeaseType::class);
    }

    public function leaseStatus(): BelongsTo
    {
        return $this->belongsTo(LeaseStatus::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
