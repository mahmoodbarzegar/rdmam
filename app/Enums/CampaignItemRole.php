<?php

namespace App\Enums;

enum CampaignItemRole: string
{
    case Eligible = 'eligible';
    case Excluded = 'excluded';

    public function label(): string
    {
        return match ($this) {
            self::Eligible => 'مشمول',
            self::Excluded => 'مستثنا',
        };
    }
}
