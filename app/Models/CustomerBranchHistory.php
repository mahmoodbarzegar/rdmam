<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * سابقه انتقال بین شعبه‌ها
 * جدول: customer_branch_histories
 */
class CustomerBranchHistory extends Model
{
    protected $table = 'customer_branch_histories';

    protected $fillable = [
        'customer_id',
        'from_branch_id',
        'to_branch_id',
        'changed_by',
        'reason',
        'effective_at',
    ];

    protected function casts(): array
    {
        return [
            'effective_at' => 'datetime',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function fromBranch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'from_branch_id');
    }

    public function toBranch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'to_branch_id');
    }
}
