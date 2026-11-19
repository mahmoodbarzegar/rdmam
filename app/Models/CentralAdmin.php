<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * پروفایل مدیر مرکزی
 * جدول: central_admins
 */
class CentralAdmin extends Model
{
    protected $table = 'central_admins';

    protected $fillable = [
        'user_id',
        'national_id',
        'personnel_code',
        'title',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
