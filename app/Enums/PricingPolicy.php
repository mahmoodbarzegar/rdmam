<?php

namespace App\Enums;

enum PricingPolicy: string
{
    case Campaign = 'campaign';
    case Contract = 'contract';
    case Base = 'base';

    public function label(): string
    {
        return match ($this) {
            self::Campaign => 'کمپین',
            self::Contract => 'قراردادی',
            self::Base => 'بدون تخفیف (قیمت پایه)',
        };
    }
}
