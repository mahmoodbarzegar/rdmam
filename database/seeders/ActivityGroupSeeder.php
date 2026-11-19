<?php

namespace Database\Seeders;

use App\Models\ActivityGroup;
use Illuminate\Database\Seeder;

/** گروه‌های فعالیت نمونه؛ در صورت وجود فهرست مرجع در ERP، از همان همگام‌سازی شود. */
class ActivityGroupSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            'تعمیرکار',
            'فروشگاه لوازم یدکی',
            'نمایندگی خودرو',
            'ناوگان و شرکت حمل‌ونقل',
            'سایر',
        ] as $name) {
            ActivityGroup::firstOrCreate(['name' => $name], ['is_active' => true]);
        }
    }
}
