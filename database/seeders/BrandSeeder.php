<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

/** برندهای نمونه. */
class BrandSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            'BOSCH' => 'بوش',
            'MANN' => 'مان فیلتر',
            'MAHLE' => 'ماهله',
            'NGK' => 'ان‌جی‌کی',
            'VALEO' => 'والئو',
            'BREMBO' => 'برمبو',
            'SACHS' => 'ساکس',
        ] as $erpCode => $name) {
            Brand::updateOrCreate(['erp_code' => $erpCode], ['name' => $name, 'is_active' => true]);
        }
    }
}
