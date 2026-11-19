<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * سبد خرید
 * جدول: carts
 */
class Cart extends Model
{
    protected $table = 'carts';

    protected $fillable = [
        'customer_id',
        'last_changed_at',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'last_changed_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

public function scopeNotExpired($q)
{
    return $q->where('expires_at', '>', now());
}
}
