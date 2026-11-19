<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * لاگ تلاش‌های ارسال
 * جدول: erp_outbox_attempts
 */
class ErpOutboxAttempt extends Model
{
    protected $table = 'erp_outbox_attempts';

    protected $fillable = [
        'outbox_id',
        'attempt_no',
        'http_status',
        'outcome',
        'response_body',
        'duration_ms',
        'started_at',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
        ];
    }

    public function outbox(): BelongsTo
    {
        return $this->belongsTo(ErpOutbox::class, 'outbox_id');
    }
}
