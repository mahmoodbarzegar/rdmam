<?php

namespace App\Models;

use App\Enums\PaymentRequestStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * درخواست پرداخت سفارش
 * جدول: payment_requests
 */
class PaymentRequest extends Model
{
    protected $table = 'payment_requests';

    protected $fillable = [
        'order_id',
        'erp_payment_id',
        'terms',
        'total_due',
        'status',
        'submitted_at',
        'reviewed_at',
        'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'terms' => 'array',
            'submitted_at' => 'datetime',
            'reviewed_at' => 'datetime',
            'status' => PaymentRequestStatus::class,
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(PaymentItem::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(PaymentLog::class);
    }
}
