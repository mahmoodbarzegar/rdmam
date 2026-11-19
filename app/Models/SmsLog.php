<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * لاگ پیامک‌ها
 * جدول: sms_logs
 */
class SmsLog extends Model
{
    protected $table = 'sms_logs';

    protected $fillable = [
        'user_id',
        'mobile',
        'template',
        'message',
        'provider',
        'provider_message_id',
        'status',
        'error',
        'related_type',
        'related_id',
        'sent_at',
    ];

    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function related(): MorphTo
    {
        return $this->morphTo();
    }
}
