<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * اعتبار و بدهی مشتری (فقط خواندنی)
 * جدول: customer_credit_snapshots
 */
class CustomerCreditSnapshot extends Model
{
    protected $table = 'customer_credit_snapshots';

    protected $fillable = [
        'customer_id',
        'credit_limit',
        'usable_credit',
        'total_debt',
        'payment_terms',
        'is_available',
        'erp_synced_at',
    ];

    protected function casts(): array
    {
        return [
            'payment_terms' => 'array',
            'is_available' => 'boolean',
            'erp_synced_at' => 'datetime',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
