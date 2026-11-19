<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

/**
 * پارامترهای سراسری که طبق سند فاز اول مدیر مرکزی تعیین می‌کند یا عدد مشخصی دارند.
 * کلیدها را با SystemSetting::getValue('key') بخوانید.
 */
class SystemSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'min_order_amount' => [0, 'حداقل مبلغ سفارش (ریال) برای کل سامانه. صفر یعنی بدون حداقل؛ مدیر مرکزی باید مقدار واقعی را تعیین کند.'],
            'approval_deadline_hours' => [48, 'مهلت تأیید مدیر شعبه، به ساعت تقویمی از لحظه ثبت سفارش.'],
            'approval_reminder_hours' => [[24, 44], 'ساعت‌های یادآوری به مدیر شعبه (از ثبت سفارش).'],
            'correction_response_hours' => [24, 'حداکثر مهلت پاسخ مشتری به درخواست اصلاح؛ در هر حال تا پایان مهلت ۴۸ ساعته.'],
            'cart_ttl_days' => [7, 'مدت نگه‌داری سبد از آخرین تغییر، به روز.'],
            'cart_max_rows' => [100, 'حداکثر تعداد ردیف سبد.'],
            'erp_request_timeout_seconds' => [15, 'مهلت هر درخواست به ERP، به ثانیه.'],
            'erp_retry_delays_minutes' => [[1, 5, 15, 30, 60], 'فاصله تلاش‌های مجدد ارسال به ERP، به دقیقه (پیشنهادی).'],
            'erp_max_attempts' => [5, 'پس از این تعداد تلاش ناموفق، ارسال خودکار متوقف و هشدار مرکزی ساخته می‌شود.'],
        ];

        foreach ($settings as $key => [$value, $description]) {
            SystemSetting::firstOrCreate(
                ['key' => $key],
                ['value' => $value, 'description' => $description],
            );
        }
    }
}
