<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Casts;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'document_category_id', 'property_id', 'certificate_id', 'additional_certificate_id',
    'lease_contract_id', 'document_name', 'document_number', 'document_date',
    'expired_date', 'file_name', 'file_path', 'file_extension', 'file_size',
    'mime_type', 'version_number', 'description', 'uploaded_by',
])]
#[Casts([
    'document_date' => 'date',
    'expired_date' => 'date',
    'file_size' => 'integer',
    'version_number' => 'integer',
])]
class Document extends Model
{
    use SoftDeletes;

    public function category(): BelongsTo
    {
        return $this->belongsTo(DocumentCategory::class, 'document_category_id');
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function certificate(): BelongsTo
    {
        return $this->belongsTo(Certificate::class);
    }

    public function additionalCertificate(): BelongsTo
    {
        return $this->belongsTo(AdditionalCertificate::class);
    }

    public function leaseContract(): BelongsTo
    {
        return $this->belongsTo(LeaseContract::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
