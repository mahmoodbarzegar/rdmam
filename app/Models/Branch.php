<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * شعبه‌ها
 * جدول: branches
 */
class Branch extends Model
{
    protected $table = 'branches';

    protected $fillable = [
        'code',
        'name',
        'warehouse_id',
        'province_id',
        'city_id',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    public function managerAssignments(): HasMany
    {
        return $this->hasMany(BranchManagerAssignment::class);
    }

    public function activeManagerAssignment(): HasOne
    {
        return $this->hasOne(BranchManagerAssignment::class)->whereNull('ended_at');
    }
}
