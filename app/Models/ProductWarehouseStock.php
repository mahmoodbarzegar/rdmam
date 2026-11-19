<?php

namespace App\Models;

use App\Enums\StockStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * موجودی کالا در انبار
 * جدول: product_warehouse_stock
 */
class ProductWarehouseStock extends Model
{
    protected $table = 'product_warehouse_stock';

    protected $fillable = [
        'product_id',
        'warehouse_id',
        'status',
        'quantity',
        'erp_synced_at',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:3',
            'erp_synced_at' => 'datetime',
            'status' => StockStatus::class,
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }
}
