<?php

namespace App\Enums;

enum UserRole: string
{
    case Customer = 'customer';
    case BranchAdmin = 'branch_admin';
    case CentralAdmin = 'central_admin';

    public function label(): string
    {
        return match ($this) {
            self::Customer => 'مشتری',
            self::BranchAdmin => 'مدیر شعبه',
            self::CentralAdmin => 'مدیر مرکزی',
        };
    }
}
