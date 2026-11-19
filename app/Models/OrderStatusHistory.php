<?php

namespace App\Models;

use App\Enums\HistoryChannel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * تاریخچه وضعیت‌ها
 * جدول: order_status_histories
 */
class OrderStatusHistory extends Model
{
    protected $table = 'order_status_histories';

    protected $fillable = [
        'order_id',
        'channel',
        'from_status',
        'to_status',
        'source',
        'actor_id',
        'erp_event_id',
        'note',
        'occurred_at',
    ];

    protected function casts(): array
    {
        return [
            'occurred_at' => 'datetime',
            'channel' => HistoryChannel::class,
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id');
    }
}
