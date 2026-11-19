<?php

namespace App\Enums;

enum ChangeRequestType: string
{
    case Mobile = 'mobile';
    case OfficialInfo = 'official_info';
    case Address = 'address';
    case Branch = 'branch';

    public function label(): string
    {
        return match ($this) {
            self::Mobile => 'تغییر موبایل',
            self::OfficialInfo => 'تغییر اطلاعات رسمی',
            self::Address => 'تغییر نشانی',
            self::Branch => 'تغییر شعبه',
        };
    }
}
