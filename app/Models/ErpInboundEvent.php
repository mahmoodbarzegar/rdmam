<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * رویدادهای دریافتی از ERP (Inbox)
 * جدول: erp_inbound_events
 */
class ErpInboundEvent extends Model
{
    protected $table = 'erp_inbound_events';

    protected $fillable = [
        'event_id',
        'order_id',
        'event_type',
        'payload',
        'occurred_at',
        'processed_at',
        'outcome',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'payload' => 'array',
            'occurred_at' => 'datetime',
            'processed_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
