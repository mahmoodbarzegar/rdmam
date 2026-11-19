<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * قیمت یا تخفیف قراردادی ERP
 * جدول: contract_prices
 */
class ContractPrice extends Model
{
    protected $table = 'contract_prices';

    protected $fillable = [
        'customer_id',
        'product_id',
        'category_id',
        'erp_id',
        'price',
        'discount_percent',
        'valid_from',
        'valid_to',
        'erp_synced_at',
    ];

    protected function casts(): array
    {
        return [
            'discount_percent' => 'decimal:2',
            'valid_from' => 'date',
            'valid_to' => 'date',
            'erp_synced_at' => 'datetime',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
