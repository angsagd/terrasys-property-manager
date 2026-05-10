<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Casts;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id', 'module_name', 'table_name', 'record_id', 'action',
    'old_values', 'new_values', 'ip_address', 'user_agent', 'created_at',
])]
#[Casts(['old_values' => 'array', 'new_values' => 'array', 'created_at' => 'datetime'])]
class AuditLog extends Model
{
    public $timestamps = false;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
