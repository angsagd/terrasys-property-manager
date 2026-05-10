<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Casts;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id', 'notification_type', 'title', 'message', 'related_table',
    'related_id', 'is_read', 'read_at', 'notification_date',
])]
#[Casts(['is_read' => 'boolean', 'read_at' => 'datetime', 'notification_date' => 'date'])]
class Notification extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
