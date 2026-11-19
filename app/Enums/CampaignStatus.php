<?php

namespace App\Enums;

enum CampaignStatus: string
{
    case Draft = 'draft';
    case Active = 'active';
    case Paused = 'paused';
    case Ended = 'ended';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'پیش‌نویس',
            self::Active => 'فعال',
            self::Paused => 'متوقف',
            self::Ended => 'پایان‌یافته',
        };
    }
}
