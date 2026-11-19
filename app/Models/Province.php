<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * استان‌ها
 * جدول: provinces
 */
class Province extends Model
{

    protected $fillable = [
        'name',
        'erp_code',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }
}
