<?php

namespace App\Enums;

enum BranchDecision: string
{
    case Approved = 'approved';
    case Returned = 'returned';
    case Rejected = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::Approved => 'تأیید',
            self::Returned => 'بازگشت برای اصلاح',
            self::Rejected => 'رد',
        };
    }
}
