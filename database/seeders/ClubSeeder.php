<?php

namespace Database\Seeders;

use App\Models\ClubLevel;
use App\Models\ClubSetting;
use Illuminate\Database\Seeder;

/**
 * مقادیر اولیه‌ی باشگاه مشتریان. همه‌ی آستانه‌ها «نمونه» هستند و مدیر مرکزی باید آن‌ها را نهایی کند.
 * مبالغ به ریال و بر پایه خرید خالص دوره‌ی محاسبه (پیش‌فرض ۹۰ روز متحرک) هستند.
 */
class ClubSeeder extends Seeder
{
    public function run(): void
    {
        ClubSetting::firstOrCreate([], [
            'level_period_days' => 90,
            'amount_per_point' => 10_000_000,   // هر ۱ میلیون تومان فروش خالص = ۱ امتیاز (مثال سند)
            'points_per_step' => 1,
            'rial_value_per_point' => null,
            'points_expiry_days' => 365,
            'award_timing' => 'on_final_invoice',
            'redemption_enabled' => false,      // فاز اول: امتیاز ابزار پرداخت نیست
        ]);

        $levels = [
            [1, 'برنزی', 0, 499_999_999],
            [2, 'نقره‌ای', 500_000_000, 1_999_999_999],
            [3, 'طلایی', 2_000_000_000, 4_999_999_999],
            [4, 'پلاتینیوم', 5_000_000_000, null],
        ];

        foreach ($levels as [$order, $name, $min, $max]) {
            ClubLevel::firstOrCreate(
                ['level_order' => $order],
                ['name' => $name, 'min_amount' => $min, 'max_amount' => $max, 'is_active' => true],
            );
        }
    }
}
