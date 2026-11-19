<?php

namespace App\Enums;

enum CampaignType: string
{
    case SpecificProduct = 'C01';
    case Volume = 'C02';
    case OrderAmount = 'C03';
    case CartCombo = 'C04';

    public function label(): string
    {
        return match ($this) {
            self::SpecificProduct => 'کمپین کالای خاص',
            self::Volume => 'کمپین خرید حجمی',
            self::OrderAmount => 'کمپین مبلغ سفارش',
            self::CartCombo => 'کمپین ترکیبی سبد خرید',
        };
    }
}
