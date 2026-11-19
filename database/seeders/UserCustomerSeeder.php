<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Customer;
use App\Models\Province;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $user = User::create([
            'name' => 'علی رضایی',
            'mobile' => '09123456789',
            'email' => 'ali@example.com',
        ]);

        Customer::create([
            'user_id' => $user->id,
            'business_name' => 'شرکت نمونه',
            'national_code' => '1234567890',
            'company_info' => 'اطلاعات شرکت نمونه',
            'province_id' => 1,
            'city_id' => 1,
        ]);
    }
}
