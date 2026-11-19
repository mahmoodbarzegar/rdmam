<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * سطح‌های باشگاه
 * جدول: club_levels
 */
class ClubLevel extends Model
{
    protected $table = 'club_levels';

    protected $fillable = [
        'name',
        'level_order',
        'min_amount',
        'max_amount',
        'benefits',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'benefits' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function memberships(): HasMany
    {
        return $this->hasMany(ClubMembership::class);
    }
}
