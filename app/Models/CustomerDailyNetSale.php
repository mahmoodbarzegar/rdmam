<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * خرید خالص روزانه مشتری
 * جدول: customer_daily_net_sales
 */
class CustomerDailyNetSale extends Model
{
    protected $table = 'customer_daily_net_sales';

    protected $fillable = [
        'customer_id',
        'sales_date',
        'net_amount',
    ];

    protected function casts(): array
    {
        return [
            'sales_date' => 'date',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
