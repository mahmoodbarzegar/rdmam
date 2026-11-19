<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

/** دسته‌بندی‌های درختی نمونه (دسته اصلی ← زیردسته). */
class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $tree = [
            'ENGINE' => ['موتور', ['FILTER' => 'فیلتر', 'SPARK' => 'شمع و وایر']],
            'BRAKE' => ['ترمز', ['PAD' => 'لنت', 'DISC' => 'دیسک']],
            'SUSP' => ['تعلیق و جلوبندی', ['SHOCK' => 'کمک‌فنر']],
            'ELEC' => ['برق و باتری', ['BATT' => 'باتری']],
        ];

        $order = 0;
        foreach ($tree as $code => [$name, $children]) {
            $parent = Category::updateOrCreate(
                ['erp_code' => $code],
                ['name' => $name, 'parent_id' => null, 'sort_order' => ++$order],
            );

            $childOrder = 0;
            foreach ($children as $childCode => $childName) {
                Category::updateOrCreate(
                    ['erp_code' => $childCode],
                    ['name' => $childName, 'parent_id' => $parent->id, 'sort_order' => ++$childOrder],
                );
            }
        }
    }
}
