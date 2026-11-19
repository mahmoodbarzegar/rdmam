<?php

namespace App\Enums;

enum CampaignUsageState: string
{
    case Committed = 'committed';
    case Accepted = 'accepted';
    case Invoiced = 'invoiced';
    case Released = 'released';

    public function label(): string
    {
        return match ($this) {
            self::Committed => 'تعهد باز',
            self::Accepted => 'پذیرفته‌شده',
            self::Invoiced => 'فاکتورشده',
            self::Released => 'آزادشده',
        };
    }
}
