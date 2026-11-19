<?php

namespace App\Models;

use App\Enums\AlertSeverity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * هشدارهای مرکزی
 * جدول: central_alerts
 */
class CentralAlert extends Model
{
    protected $table = 'central_alerts';

    protected $fillable = [
        'type',
        'severity',
        'title',
        'body',
        'related_type',
        'related_id',
        'resolved_at',
        'resolved_by',
    ];

    protected function casts(): array
    {
        return [
            'resolved_at' => 'datetime',
            'severity' => AlertSeverity::class,
        ];
    }

    public function related(): MorphTo
    {
        return $this->morphTo();
    }

    public function resolver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }
}
