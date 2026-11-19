<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * لاگ ارجاعات پرداخت
 * جدول: payment_logs
 */
class PaymentLog extends Model
{
    protected $table = 'payment_logs';

    protected $fillable = [
        'payment_request_id',
        'actor_id',
        'actor_type',
        'action',
        'note',
    ];

    protected function casts(): array
    {
        return [
        ];
    }

    public function request(): BelongsTo
    {
        return $this->belongsTo(PaymentRequest::class, 'payment_request_id');
    }

    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id');
    }
}
