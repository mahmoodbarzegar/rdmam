<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * پروفایل مدیر شعبه
 * جدول: branch_managers
 */
class BranchManager extends Model
{
    protected $table = 'branch_managers';

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

    public function assignments(): HasMany
    {
        return $this->hasMany(BranchManagerAssignment::class);
    }

    public function activeAssignment(): HasOne
    {
        return $this->hasOne(BranchManagerAssignment::class)->whereNull('ended_at');
    }

public function currentBranch(): ?Branch
{
    return $this->activeAssignment?->branch;
}
}
