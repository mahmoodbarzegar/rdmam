<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

/**
 * شعبه‌های نمونه. هر شعبه به یک انبار وصل است و یک انبار می‌تواند چند شعبه را پوشش دهد
 * (اینجا دو شعبه‌ی تهران به انبار مرکزی وصل‌اند). استان و شهر شعبه خالی می‌ماند.
 */
class BranchSeeder extends Seeder
{
    public function run(): void
    {
        // پیش‌نیاز: انبارها (idempotent است و اجرای دوباره مشکلی ندارد)
        $this->call(WarehouseSeeder::class);

        $warehouses = Warehouse::pluck('id', 'erp_id');

        foreach ([
            ['BR-THR-1', 'شعبه تهران ۱', 'ERP-WH-01'],
            ['BR-THR-2', 'شعبه تهران ۲', 'ERP-WH-01'],
            ['BR-ISF-1', 'شعبه اصفهان', 'ERP-WH-02'],
        ] as [$code, $name, $warehouseErpId]) {
            Branch::updateOrCreate(
                ['code' => $code],
                ['name' => $name, 'warehouse_id' => $warehouses[$warehouseErpId], 'is_active' => true],
            );
        }
    }
}
