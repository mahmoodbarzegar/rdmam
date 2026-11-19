<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Seeder;

/** انبارهای نمونه. در محیط واقعی از ERP همگام‌سازی می‌شود. */
class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['ERP-WH-01', 'WH01', 'انبار مرکزی تهران'],
            ['ERP-WH-02', 'WH02', 'انبار اصفهان'],
        ] as [$erpId, $code, $name]) {
            Warehouse::updateOrCreate(
                ['erp_id' => $erpId],
                ['code' => $code, 'name' => $name, 'is_active' => true, 'erp_synced_at' => now()],
            );
        }
    }
}
