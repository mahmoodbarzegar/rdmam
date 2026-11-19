<?php

namespace App\Enums;

enum OrderBusinessStatus: string
{
    case Draft = 'draft';
    case PendingBranch = 'pending_branch';
    case NeedsCorrection = 'needs_correction';
    case BranchApproved = 'branch_approved';
    case AcceptedByErp = 'accepted_by_erp';
    case RejectedByBranch = 'rejected_by_branch';
    case RejectedByErp = 'rejected_by_erp';
    case Cancelled = 'cancelled';
    case Expired = 'expired';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'پیش‌نویس',
            self::PendingBranch => 'منتظر مدیر شعبه',
            self::NeedsCorrection => 'نیازمند اصلاح مشتری',
            self::BranchApproved => 'تأیید شعبه',
            self::AcceptedByErp => 'پذیرفته در ERP',
            self::RejectedByBranch => 'ردشده در شعبه',
            self::RejectedByErp => 'ردشده در ERP',
            self::Cancelled => 'لغوشده',
            self::Expired => 'منقضی',
        };
    }
}
