<?php

namespace App\Models;

use App\Enums\BranchDecision;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * تصمیم‌های مدیر شعبه
 * جدول: order_decisions
 */
class OrderDecision extends Model
{
    protected $table = 'order_decisions';

    protected $fillable = [
        'order_id',
        'order_revision_id',
        'decided_by',
        'decision',
        'reason',
        'decided_at',
    ];

    protected function casts(): array
    {
        return [
            'decided_at' => 'datetime',
            'decision' => BranchDecision::class,
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function revision(): BelongsTo
    {
        return $this->belongsTo(OrderRevision::class, 'order_revision_id');
    }

    public function decider(): BelongsTo
    {
        return $this->belongsTo(User::class, 'decided_by');
    }
}
