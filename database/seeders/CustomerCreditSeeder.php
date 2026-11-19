<?php

namespace Database\Seeders;

use App\Enums\CustomerStatus;
use App\Enums\PersonType;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\ActivityGroup;
use App\Models\Branch;
use App\Models\City;
use App\Models\ContractPrice;
use App\Models\Customer;
use App\Models\CustomerCreditSnapshot;
use App\Models\Product;
use App\Models\Province;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * سه مشتری نمونه همراه با اعتبار/بدهی (مبالغ به ریال) و چند قیمت قراردادی.
 * اعتبار به مشتری وابسته است، پس مشتری‌ها هم اینجا ساخته می‌شوند.
 * ترتیب اجرا: BranchSeeder، ProductSeeder (و در صورت وجود ActivityGroupSeeder).
 *
 * اگر هنوز استان و شهری در دیتابیس نیست، یک استان و شهر «تهران» ساخته می‌شود
 * (nameهای تکراری با سیدر اصلی استان/شهر شما تداخلی ندارد چون name یکتا است).
 *
 * مشتری ۳ برای تست «اطلاعات در دسترس نیست» است: مقدارها NULL و is_available=false.
 */
class CustomerCreditSeeder extends Seeder
{
    public function run(): void
    {
        // پیش‌نیازها (idempotent)
        $this->call([
            BranchSeeder::class,
            ProductSeeder::class,
        ]);

        $province = Province::first() ?? Province::create(['name' => 'تهران', 'is_active' => true]);
        $city = City::where('province_id', $province->id)->first()
            ?? City::create(['province_id' => $province->id, 'name' => 'تهران', 'is_active' => true]);

        $branches = Branch::pluck('id', 'code');
        $activityGroupId = ActivityGroup::value('id');

        $customers = [
            [
                'user' => ['name' => 'علی رضایی', 'mobile' => '09120000011'],
                'erp_id' => 'CUST-001',
                'person_type' => PersonType::Real,
                'business_name' => null,
                'national_id' => '0012345678',
                'company_info' => null,
                'branch' => 'BR-THR-1',
                'restricted' => false,
                'credit' => [
                    'credit_limit' => 2_000_000_000,
                    'usable_credit' => 1_200_000_000,
                    'total_debt' => 800_000_000,
                    'payment_terms' => ['type' => 'credit', 'days' => 30],
                    'is_available' => true,
                ],
            ],
            [
                'user' => ['name' => 'حمید احمدی', 'mobile' => '09120000012'],
                'erp_id' => 'CUST-002',
                'person_type' => PersonType::Legal,
                'business_name' => 'شرکت پارس قطعه',
                'national_id' => '10101234567',
                'company_info' => ['registration_no' => '123456', 'economic_code' => '411123456789'],
                'branch' => 'BR-ISF-1',
                'restricted' => false,
                'credit' => [
                    'credit_limit' => 5_000_000_000,
                    'usable_credit' => 3_500_000_000,
                    'total_debt' => 1_500_000_000,
                    'payment_terms' => ['type' => 'check', 'days' => 60],
                    'is_available' => true,
                ],
            ],
            [
                'user' => ['name' => 'محمد کریمی', 'mobile' => '09120000013'],
                'erp_id' => 'CUST-003',
                'person_type' => PersonType::Real,
                'business_name' => null,
                'national_id' => '0098765432',
                'company_info' => null,
                'branch' => 'BR-THR-2',
                'restricted' => true,   // محدودیت اعتباری: تاریخچه را می‌بیند ولی سفارش اعتباری ثبت نمی‌کند
                'credit' => [
                    'credit_limit' => null,
                    'usable_credit' => null,
                    'total_debt' => null,
                    'payment_terms' => null,
                    'is_available' => false,
                ],
            ],
        ];

        $created = [];

        foreach ($customers as $row) {
            $user = User::firstOrCreate(
                ['mobile' => $row['user']['mobile']],
                ['name' => $row['user']['name'], 'role' => UserRole::Customer, 'status' => UserStatus::Active],
            );

            $customer = Customer::updateOrCreate(
                ['erp_id' => $row['erp_id']],
                [
                    'user_id' => $user->id,
                    'person_type' => $row['person_type'],
                    'activity_group_id' => $activityGroupId,
                    'business_name' => $row['business_name'],
                    'national_id' => $row['national_id'],
                    'company_info' => $row['company_info'],
                    'province_id' => $province->id,
                    'city_id' => $city->id,
                    'address' => 'نشانی نمونه، خیابان نمونه، پلاک ۱',
                    'postal_code' => '1234567890',
                    'branch_id' => $branches[$row['branch']],
                    'status' => CustomerStatus::Active,
                    'credit_restricted' => $row['restricted'],
                    'approved_at' => now(),
                    'erp_synced_at' => now(),
                ],
            );

            CustomerCreditSnapshot::updateOrCreate(
                ['customer_id' => $customer->id],
                $row['credit'] + ['erp_synced_at' => $row['credit']['is_available'] ? now() : null],
            );

            $created[$row['erp_id']] = $customer;
        }

        // قیمت قراردادی نمونه (مسیر دوم قیمت‌گذاری؛ کمپین بر آن مقدم است)
        $p101 = Product::where('code', '00101')->first();
        $p301 = Product::where('code', '00301')->first();

        if ($p101) {
            ContractPrice::firstOrCreate(
                ['customer_id' => $created['CUST-001']->id, 'product_id' => $p101->id],
                ['price' => 1_700_000, 'erp_synced_at' => now()],
            );
        }
        if ($p301) {
            ContractPrice::firstOrCreate(
                ['customer_id' => $created['CUST-002']->id, 'product_id' => $p301->id],
                ['discount_percent' => 8, 'erp_synced_at' => now()],
            );
        }
    }
}
