<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * انبارهای ERP
 * جدول: warehouses
 */
class Warehouse extends Model
{
    protected $table = 'warehouses';

    protected $fillable = [
        'erp_id',
        'erp_code',
        'name',
        'is_active',
        'erp_synced_at',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'erp_synced_at' => 'datetime',
        ];
    }

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }
}
