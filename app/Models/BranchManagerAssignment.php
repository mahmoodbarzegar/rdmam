<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * سوابق مدیر شعبه
 * جدول: branch_manager_assignments
 */
class BranchManagerAssignment extends Model
{
    protected $table = 'branch_manager_assignments';

    protected $fillable = [
        'branch_id',
        'branch_manager_id',
        'started_at',
        'ended_at',
        'ended_reason',
        'active_branch_id',
        'assigned_by',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
        ];
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function branchManager(): BelongsTo
    {
        return $this->belongsTo(BranchAdmin::class);
    }

    public function assigner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

protected static function booted(): void
{
    static::saving(function (self $m) {
        $m->active_branch_id = $m->ended_at ? null : $m->branch_id;
    });
}
}
