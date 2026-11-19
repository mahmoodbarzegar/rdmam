<?php

namespace App\Enums;

enum PointTransactionType: string
{
    case Earn = 'earn';
    case Reverse = 'reverse';
    case Expire = 'expire';
    case Adjust = 'adjust';
    case Bonus = 'bonus';

    public function label(): string
    {
        return match ($this) {
            self::Earn => 'کسب',
            self::Reverse => 'برگشت',
            self::Expire => 'انقضا',
            self::Adjust => 'اصلاح دستی',
            self::Bonus => 'تشویقی',
        };
    }
}
