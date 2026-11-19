<?php

namespace App\Enums;

enum CustomerStatus: string
{
    case PendingReview = 'pending_review';
    case NeedsCompletion = 'needs_completion';
    case Active = 'active';
    case Rejected = 'rejected';
    case Blocked = 'blocked';

    public function label(): string
    {
        return match ($this) {
            self::PendingReview => 'در انتظار بررسی',
            self::NeedsCompletion => 'نیازمند تکمیل',
            self::Active => 'فعال',
            self::Rejected => 'ردشده',
            self::Blocked => 'مسدود',
        };
    }
}
