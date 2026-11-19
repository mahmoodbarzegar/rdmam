<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * گروه‌های فعالیت
 * جدول: activity_groups
 */
class ActivityGroup extends Model
{
    protected $table = 'activity_groups';

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
}
