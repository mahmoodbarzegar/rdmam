<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * امتیاز محاسبه‌شده هر سفارش
 * جدول: club_order_points
 */
class ClubOrderPoint extends Model
{
    protected $table = 'club_order_points';

    protected $fillable = [
        'order_id',
        'customer_id',
        'net_sales',
        'points',
    ];

    protected function casts(): array
    {
        return [
            'points' => 'decimal:2',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
