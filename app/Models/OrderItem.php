<?php

namespace App\Models;

use App\Enums\CartUnit;
use App\Enums\PricingPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * ردیف‌های سفارش
 * جدول: order_items
 */
class OrderItem extends Model
{
    protected $table = 'order_items';

    protected $fillable = [
        'order_revision_id',
        'product_id',
        'product_code',
        'product_title',
        'unit',
        'quantity_input',
        'quantity_base',
        'sales_factor',
        'base_price',
        'contract_price',
        'gross_amount',
        'discount_amount',
        'net_amount',
        'tax_rate',
        'tax_amount',
        'total_amount',
        'discount_source',
        'campaign_eligible',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sales_factor' => 'decimal:4',
            'tax_rate' => 'decimal:2',
            'campaign_eligible' => 'boolean',
            'discount_source' => PricingPolicy::class,
            'unit' => CartUnit::class,
        ];
    }

    public function revision(): BelongsTo
    {
        return $this->belongsTo(OrderRevision::class, 'order_revision_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
