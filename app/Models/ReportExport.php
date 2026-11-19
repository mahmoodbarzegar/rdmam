<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * لاگ خروجی گزارش‌ها
 * جدول: report_exports
 */
class ReportExport extends Model
{
    protected $table = 'report_exports';

    protected $fillable = [
        'user_id',
        'report_key',
        'filters',
        'format',
        'status',
        'file_path',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'filters' => 'array',
            'expires_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
