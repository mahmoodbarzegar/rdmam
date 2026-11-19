<?php

namespace App\Models;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * کاربران (هر سه نقش)
 * جدول: users
 */
class User extends Authenticatable
{
    protected $table = 'users';

    protected $fillable = [
        'name',
        'mobile',
        'email',
        'status',
        'last_login_at',
        'otp_code',
        'otp_expires_at',
    ];

    protected $hidden = ['password', 'remember_token','otp_code'];

    protected function casts(): array
    {
        return [
            'last_login_at' => 'datetime',
            'role' => UserRole::class,
            'status' => UserStatus::class,
            'password' => 'hashed',
            'otp_expires_at' => 'datetime',
        ];
    }

    public function customerAccount(): HasOne
    {
        return $this->hasOne(Customer::class);
    }

    public function branchAdminAccount(): HasOne
    {
        return $this->hasOne(BranchAdmin::class);
    }

    public function centralAdmin(): HasOne
    {
        return $this->hasOne(CentralAdmin::class);
    }

public function isCustomer(): bool
{
    return $this->role === UserRole::Customer;
}

public function isBranchAdmin(): bool
{
    return $this->role === UserRole::BranchAdmin;
}

public function isCentralAdmin(): bool
{
    return $this->role === UserRole::CentralAdmin;
}
}
