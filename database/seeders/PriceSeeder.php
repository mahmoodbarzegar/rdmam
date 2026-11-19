<?php

namespace Database\Seeders;

use App\Enums\ProductDefaultUnit;
use App\Models\Price;
use App\Models\Product;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

/** خودروهای نمونه برای فیلتر «نام خودرو». */
class PriceSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Product::all() as $item) {
            $item->prices()->create([
                'unit'=>ProductDefaultUnit::Piece,
                'price'=>rand(1,10).'000000',
                'start_date'=>now(),
                'approved_at'=>now(),
                'is_approved'=>true,
                'erp_title'=>fake('fa_IR')->title(),
            ]);
       }
    }
}
