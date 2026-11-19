<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

/** فقط برای محیط local: یک انبار و دو شعبه‌ی نمونه تا بتوان مشتری و سفارش تست ساخت. */
class DevBranchSeeder extends Seeder
{
    public function run(): void
    {
        $warehouse = Warehouse::firstOrCreate(
            ['erp_id' => 'DEV-WH-1'],
            ['code' => 'WH1', 'name' => 'انبار مرکزی (نمونه)', 'is_active' => true],
        );

        foreach ([
            ['BR-001', 'شعبه یک (نمونه)'],
            ['BR-002', 'شعبه دو (نمونه)'],
        ] as [$code, $name]) {
            Branch::firstOrCreate(
                ['code' => $code],
                ['name' => $name, 'warehouse_id' => $warehouse->id, 'is_active' => true],
            );
        }
    }
}
