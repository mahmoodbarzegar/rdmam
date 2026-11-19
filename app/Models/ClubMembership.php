<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * عضویت و موجودی امتیاز
 * جدول: club_memberships
 */
class ClubMembership extends Model
{
    protected $table = 'club_memberships';

    protected $fillable = [
        'customer_id',
        'club_level_id',
        'points_balance',
        'rolling_net_sales',
        'level_calculated_at',
        'joined_at',
    ];

    protected function casts(): array
    {
        return [
            'points_balance' => 'decimal:2',
            'level_calculated_at' => 'datetime',
            'joined_at' => 'datetime',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(ClubLevel::class, 'club_level_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(ClubPointTransaction::class, 'customer_id', 'customer_id');
    }
}
