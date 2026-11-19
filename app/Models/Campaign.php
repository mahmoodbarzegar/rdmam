<?php

namespace App\Models;

use App\Enums\CampaignStatus;
use App\Enums\CampaignType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

/**
 * کمپین‌ها (هویت و شمارنده‌ها)
 * جدول: campaigns
 */
class Campaign extends Model
{
    protected $table = 'campaigns';

    protected $fillable = [
        'code',
        'type',
        'status',
        'current_version_id',
        'budget_used',
        'orders_used',
        'auto_paused_at',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'auto_paused_at' => 'datetime',
            'type' => CampaignType::class,
            'status' => CampaignStatus::class,
        ];
    }

    public function versions(): HasMany
    {
        return $this->hasMany(CampaignVersion::class);
    }

    public function currentVersion(): BelongsTo
    {
        return $this->belongsTo(CampaignVersion::class, 'current_version_id');
    }

    public function usages(): HasMany
    {
        return $this->hasMany(CampaignUsage::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

/** مصرف اتمیک بودجه و ظرفیت؛ در صورت عبور از سقف false برمی‌گرداند. */
public function consumeBudget(int $discount): bool
{
    $version = $this->currentVersion;
    $query = static::whereKey($this->id);

    if ($version?->budget_limit !== null) {
        $query->whereRaw('budget_used + ? <= ?', [$discount, $version->budget_limit]);
    }
    if ($version?->orders_limit !== null) {
        $query->where('orders_used', '<', $version->orders_limit);
    }

    return $query->update([
        'budget_used' => DB::raw('budget_used + ' . (int) $discount),
        'orders_used' => DB::raw('orders_used + 1'),
    ]) === 1;
}

public function releaseBudget(int $discount): void
{
    static::whereKey($this->id)->update([
        'budget_used' => DB::raw('GREATEST(budget_used - ' . (int) $discount . ', 0)'),
        'orders_used' => DB::raw('GREATEST(orders_used - 1, 0)'),
    ]);
}
}
