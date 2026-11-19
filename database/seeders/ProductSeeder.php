<?php

namespace Database\Seeders;

use App\Enums\StockStatus;
use App\Enums\SyncErrorType;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductSyncError;
use App\Models\ProductWarehouseStock;
use App\Models\Vehicle;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

/**
 * کالاهای نمونه همراه با قیمت پایه (ریال)، موجودی هر انبار و ارتباط با خودرو.
 * ترتیب اجرا: WarehouseSeeder، BrandSeeder، VehicleSeeder، ProductCategorySeeder.
 *
 * موارد تست:
 *  - کد 00101 با صفر ابتدایی (صفر نباید حذف شود)
 *  - کد 00302 در انبار اصفهان ناموجود است
 *  - کد 00501 وضعیت «نیازمند به‌روزرسانی» دارد
 *  - کد 00999 قیمت ندارد؛ سفارش‌پذیر نیست و در فهرست خطاها ثبت می‌شود
 */
class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // پیش‌نیازها (idempotent)
        $this->call([
            WarehouseSeeder::class,
            BrandSeeder::class,
            VehicleSeeder::class,
            ProductCategorySeeder::class,
        ]);

        $brands = Brand::pluck('id', 'erp_code');
        $categories = Category::pluck('id', 'erp_code');
        $vehicles = Vehicle::pluck('id', 'erp_code');
        $warehouses = Warehouse::all();

        // [کد، کد فنی، عنوان، برند، دسته، خودروها، قیمت (ریال)، تعداد در کارتن]
        $items = [
            ['00101', 'F026407006', 'فیلتر روغن بوش', 'BOSCH', 'FILTER', ['PRIDE', 'TIBA'], 1_850_000, 24],
            ['00102', 'C25114', 'فیلتر هوا مان', 'MANN', 'FILTER', ['P206', 'P405'], 2_400_000, 12],
            ['00103', 'KL145', 'فیلتر بنزین ماهله', 'MAHLE', 'FILTER', ['SAMAND', 'DENA'], 1_450_000, 20],
            ['00201', 'BKR6E', 'شمع ان‌جی‌کی', 'NGK', 'SPARK', ['P405', 'SAMAND', 'PRIDE'], 3_200_000, 40],
            ['00301', 'GDB1550', 'لنت ترمز جلو والئو', 'VALEO', 'PAD', ['P206', 'P405'], 9_800_000, 10],
            ['00302', 'DF4251', 'دیسک ترمز جلو برمبو', 'BREMBO', 'DISC', ['SAMAND', 'DENA'], 24_500_000, null],
            ['00401', 'SA-3320', 'کمک‌فنر عقب ساکس', 'SACHS', 'SHOCK', ['PRIDE', 'TIBA'], 31_000_000, 4],
            ['00402', 'SA-5541', 'کمک‌فنر جلو ساکس', 'SACHS', 'SHOCK', ['RANA', 'P206'], 36_500_000, 4],
            ['00501', 'S4-60AH', 'باتری ۶۰ آمپر بوش', 'BOSCH', 'BATT', ['P405', 'SAMAND', 'DENA'], 58_000_000, null],
            ['00999', null, 'قطعه نمونه بدون قیمت', null, 'FILTER', [], null, null],
        ];

        foreach ($items as $i => [$code, $tech, $title, $brand, $category, $vehicleCodes, $price, $carton]) {
            $valid = $price !== null;

            $product = Product::updateOrCreate(
                ['erp_id' => 'ERP-P-' . $code],
                [
                    'code' => $code,
                    'code_normalized' => Product::normalize($code),
                    'technical_code' => $tech,
                    'technical_code_normalized' => $tech ? Product::normalize($tech) : null,
                    'title' => $title,
                    'title_normalized' => Product::normalize($title),
                    'brand_id' => $brand ? $brands[$brand] : null,
                    'category_id' => $categories[$category],
                    'sales_factor' => 1,
                    'min_order_qty' => mt_rand(1,5),
                    'max_order_qty' => mt_rand(1,5),
                    'settlement_deadline_days' => mt_rand(10,45),
                    'base_price' => $price,
                    'tax_rate' => 10,
                    'erp_attributes' => ['origin' => 'نمونه'],
                    'is_active' => true,
                    'is_orderable' => $valid,
                    'validation_errors' => $valid ? null : ['قیمت معتبر ثبت نشده است.'],
                    'sort_order' => $i + 1,
                    'carton_qty' => $carton,
                    'erp_synced_at' => now(),
                ],
            );

            $product->vehicles()->syncWithoutDetaching(
                collect($vehicleCodes)->map(fn ($c) => $vehicles[$c])->all(),
            );

            foreach ($warehouses as $warehouse) {
                $status = StockStatus::Orderable;
                $quantity = (crc32($code . $warehouse->erp_id) % 200) + 20;

                if ($code === '00302' && $warehouse->erp_id === 'ERP-WH-02') {
                    $status = StockStatus::OutOfStock;
                    $quantity = 0;
                }
                if ($code === '00501') {
                    $status = StockStatus::NeedsUpdate;
                    $quantity = null;
                }

                ProductWarehouseStock::updateOrCreate(
                    ['product_id' => $product->id, 'warehouse_id' => $warehouse->id],
                    [
                        'status' => $status,
                        'quantity' => $quantity,
                        'erp_synced_at' => $status === StockStatus::NeedsUpdate ? now()->subDays(2) : now(),
                    ],
                );
            }

            if (! $valid) {
                ProductSyncError::firstOrCreate(
                    ['erp_id' => $product->erp_id, 'error_type' => SyncErrorType::InvalidPrice->value],
                    ['product_id' => $product->id, 'message' => 'قیمت معتبر برای کالا ثبت نشده است.'],
                );
            }
        }
    }
}
