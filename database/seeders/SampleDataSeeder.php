<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * اجرای همه‌ی داده‌های نمونه به ترتیب درست:
 *   php artisan db:seed --class=SampleDataSeeder
 */
class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            WarehouseSeeder::class,
            BranchSeeder::class,
            BrandSeeder::class,
            VehicleSeeder::class,
            ProductCategorySeeder::class,
            ProductSeeder::class,
            CustomerCreditSeeder::class,
        ]);
    }
}
