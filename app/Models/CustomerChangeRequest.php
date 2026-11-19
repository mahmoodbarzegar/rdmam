<?php

namespace App\Models;

use App\Enums\ChangeRequestType;
use App\Enums\ReviewStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * درخواست‌های تغییر اطلاعات
 * جدول: customer_change_requests
 */
class CustomerChangeRequest extends Model
{
    protected $table = 'customer_change_requests';

    protected $fillable = [
        'customer_id',
        'type',
        'old_values',
        'new_values',
        'status',
        'erp_matched',
        'reviewed_by',
        'reviewed_at',
        'review_note',
    ];

    protected function casts(): array
    {
        return [
            'old_values' => 'array',
            'new_values' => 'array',
            'erp_matched' => 'boolean',
            'reviewed_at' => 'datetime',
            'type' => ChangeRequestType::class,
            'status' => ReviewStatus::class,
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
