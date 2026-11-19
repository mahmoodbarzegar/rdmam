<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * اجرای همگام‌سازی‌ها
 * جدول: erp_sync_runs
 */
class ErpSyncRun extends Model
{
    protected $table = 'erp_sync_runs';

    protected $fillable = [
        'entity',
        'started_at',
        'finished_at',
        'status',
        'records_processed',
        'records_failed',
        'cursor',
        'error_message',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'finished_at' => 'datetime',
        ];
    }
}
