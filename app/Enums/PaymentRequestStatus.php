<?php

namespace App\Enums;

enum PaymentRequestStatus: string
{
    case AwaitingCustomer = 'awaiting_customer';
    case Submitted = 'submitted';
    case UnderReview = 'under_review';
    case Approved = 'approved';
    case Rejected = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::AwaitingCustomer => 'منتظر مشتری',
            self::Submitted => 'ارسال‌شده',
            self::UnderReview => 'در حال بررسی',
            self::Approved => 'تأیید‌شده',
            self::Rejected => 'ردشده',
        };
    }
}
