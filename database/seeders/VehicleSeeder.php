<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Seeder;

/** خودروهای نمونه برای فیلتر «نام خودرو». */
class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            'PRIDE' => 'پراید',
            'TIBA' => 'تیبا',
            'P206' => 'پژو ۲۰۶',
            'P405' => 'پژو ۴۰۵',
            'SAMAND' => 'سمند',
            'DENA' => 'دنا',
            'RANA' => 'رانا',
        ] as $erpCode => $name) {
            Vehicle::updateOrCreate(['erp_code' => $erpCode], ['name' => $name]);
        }
    }
}
