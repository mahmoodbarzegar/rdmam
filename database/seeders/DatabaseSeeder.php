<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // اطلاعات پایه‌ی مستقل از ERP. همه‌ی seederها idempotent هستند:
        // اجرای دوباره، مقداری را که مدیر مرکزی تغییر داده بازنویسی نمی‌کند.
        $this->call([
            PriceSeeder::class,
//            ProvinceSeeder::class,
//            SystemSettingSeeder::class,
//            SystemSettingSeeder::class,
//            ClubSeeder::class,
//            ActivityGroupSeeder::class,
//            CentralAdminSeeder::class,
//            BranchSeeder::class,
//            BrandSeeder::class,
//            CustomerCreditSeeder::class,
//            ProductCategorySeeder::class,
//            VehicleSeeder::class,
//            WarehouseSeeder::class,
//            SampleDataSeeder::class,
        ]);

        // فقط برای توسعه؛ در محیط واقعی شعبه و انبار از ERP می‌آید.
//        if (app()->environment('local')) {
//            $this->call(DevBranchSeeder::class);
//        }
    }
}
