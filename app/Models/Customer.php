<?php

namespace App\Models;

use App\Enums\CustomerStatus;
use App\Enums\PersonType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * مشتریان
 * جدول: customers
 */
class Customer extends Model
{

    protected $fillable = [
        'user_id',
        'erp_id',
        'erp_code',
        'business_name',
        'national_code',
        'company_info',
        'province_id',
        'city_id',
        'path_id',
        'postal_code',
        'branch_id',
        'phone',
        'status',
        'credit',
        'status_reason',
        'approved_by',
        'approved_at',
        'erp_synced_at',
    ];

    protected function casts(): array
    {
        return [
            'company_info' => 'array',
            'credit_restricted' => 'boolean',
            'approved_at' => 'datetime',
            'erp_synced_at' => 'datetime',
            'person_type' => PersonType::class,
            'status' => CustomerStatus::class,
        ];
    }

    public function addresses()
    {
        return $this->hasMany(CustomerAddress::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

//    public function activityGroup(): BelongsTo
//    {
//        return $this->belongsTo(ActivityGroup::class);
//    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function changeRequests(): HasMany
    {
        return $this->hasMany(CustomerChangeRequest::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function creditSnapshot(): HasOne
    {
        return $this->hasOne(CustomerCreditSnapshot::class);
    }

    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }

    public function clubMembership(): HasOne
    {
        return $this->hasOne(ClubMembership::class);
    }

    public function branchHistory(): HasMany
    {
        return $this->hasMany(CustomerBranchHistory::class);
    }

    public function scopeActive($q)
    {
        return $q->where('status', CustomerStatus::Active)->whereNotNull('erp_id');
    }

    public function canBuy(): bool
    {
        return $this->status === CustomerStatus::Active && $this->erp_id !== null;
    }

    public function canOrderOnCredit(): bool
    {
        return $this->canBuy() && !$this->credit_restricted;
    }

    public function displayName(): string
    {
        return $this->business_name ?: $this->user->name;
    }
}
