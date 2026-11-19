<?php

namespace App\Enums;

enum IncentiveType: string
{
    case Percent = 'percent';
    case Fixed = 'fixed';
    case Tiered = 'tiered';

    public function label(): string
    {
        return match ($this) {
            self::Percent => 'درصد تخفیف',
            self::Fixed => 'مبلغ ثابت',
            self::Tiered => 'تخفیف پلکانی',
        };
    }
}
