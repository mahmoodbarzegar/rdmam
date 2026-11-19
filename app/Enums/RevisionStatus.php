<?php

namespace App\Enums;

enum RevisionStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Returned = 'returned';
    case Rejected = 'rejected';
    case Superseded = 'superseded';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'در انتظار تصمیم',
            self::Approved => 'تأییدشده',
            self::Returned => 'بازگشت برای اصلاح',
            self::Rejected => 'ردشده',
            self::Superseded => 'جایگزین‌شده',
        };
    }
}
