<?php

namespace App\Models;

use App\Enums\PaymentItemType;
use App\Enums\ReviewStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * اقلام پرداخت (چک یا نقدی)
 * جدول: payment_items
 */
class PaymentItem extends Model
{
    protected $table = 'payment_items';

    protected $fillable = [
        'payment_request_id',
        'type',
        'amount',
        'check_number',
        'sayad_id',
        'bank_name',
        'due_date',
        'receipt_number',
        'paid_at',
        'status',
        'reject_reason',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
            'paid_at' => 'datetime',
            'type' => PaymentItemType::class,
            'status' => ReviewStatus::class,
        ];
    }

    public function request(): BelongsTo
    {
        return $this->belongsTo(PaymentRequest::class, 'payment_request_id');
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
