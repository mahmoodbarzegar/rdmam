<?php

namespace App\Models;

use App\Enums\OrderSyncStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * صف پایدار ارسال به ERP (Outbox)
 * جدول: erp_outbox
 */
class ErpOutbox extends Model
{
    protected $table = 'erp_outbox';

    protected $fillable = [
        'order_id',
        'order_revision_id',
        'idempotency_key',
        'payload',
        'status',
        'attempts',
        'next_attempt_at',
        'last_attempt_at',
        'last_error',
        'erp_order_id',
        'erp_response',
        'succeeded_at',
    ];

    protected function casts(): array
    {
        return [
            'payload' => 'array',
            'next_attempt_at' => 'datetime',
            'last_attempt_at' => 'datetime',
            'erp_response' => 'array',
            'succeeded_at' => 'datetime',
            'status' => OrderSyncStatus::class,
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function revision(): BelongsTo
    {
        return $this->belongsTo(OrderRevision::class, 'order_revision_id');
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(ErpOutboxAttempt::class, 'outbox_id');
    }

public const RETRY_DELAYS_MINUTES = [1, 5, 15, 30, 60];

public static function keyFor(int $orderId, int $revisionNo): string
{
    return "RDM-{$orderId}-{$revisionNo}";
}
}
