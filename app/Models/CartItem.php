<?php

namespace App\Models;

use App\Enums\CartUnit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * ردیف‌های سبد
 * جدول: cart_items
 */
class CartItem extends Model
{
    protected $table = 'cart_items';

    protected $fillable = [
        'cart_id',
        'product_id',
        'unit',
        'quantity_input',
        'quantity_base',
    ];

    protected function casts(): array
    {
        return [
            'unit' => CartUnit::class,
        ];
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
