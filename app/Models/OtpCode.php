<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * رمزهای یک‌بارمصرف پیامکی
 * جدول: otp_codes
 */
class OtpCode extends Model
{
    protected $table = 'otp_codes';

    protected $fillable = [
        'mobile',
        'purpose',
        'code_hash',
        'expires_at',
        'attempts',
        'consumed_at',
        'ip_address',
    ];

    protected $hidden = ['code_hash'];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'consumed_at' => 'datetime',
        ];
    }
}
