<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * تاریخچه تغییر سطح
 * جدول: club_level_histories
 */
class ClubLevelHistory extends Model
{
    protected $table = 'club_level_histories';

    protected $fillable = [
        'customer_id',
        'from_level_id',
        'to_level_id',
        'reason',
        'rolling_net_sales',
        'changed_by',
        'changed_at',
    ];

    protected function casts(): array
    {
        return [
            'changed_at' => 'datetime',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function fromLevel(): BelongsTo
    {
        return $this->belongsTo(ClubLevel::class, 'from_level_id');
    }

    public function toLevel(): BelongsTo
    {
        return $this->belongsTo(ClubLevel::class, 'to_level_id');
    }
}
