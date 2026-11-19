<?php

namespace App\Http\Controllers;

use App\Enums\ProductDefaultUnit;
use App\Jobs\GetCustomersJob;
use App\Models\City;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Province;
use App\Models\User;
use App\Services\AuthenticationService;
use App\Services\PartyManagementService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;
use function PHPUnit\Framework\stringContains;

class CustomerController extends Controller
{
    public function __construct(protected PartyManagementService $party)
    {
    }

    public function products(AuthenticationService $authenticationService)
    {
//        $res = $authenticationService->getProducts('m-barzegar', 'Mb3421');
//
//        return $res;

//               dd( Http::withHeaders(['Cookie' => $cookie['authCookie']])->withBody(['customerID'=>1201])->get(
//           "http://radmanpakhsh/Sales/PartyManagement/Services/PartyManagementService.svc/GetCustomerAccounts"
//              )->body());

    }

    public function importProducts(AuthenticationService $authenticationService)
    {
        $cookie = $authenticationService->login('m-barzegar',
            'Mb3421');

        $response = Http::withHeaders(['Cookie' => $cookie['authCookie'], 'accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->post(
                "http://radmanpakhsh/Sales/ProductManagement/Services/ProductManagementService.svc/GetProducts",

            );

        if ($response->successful()) {
            $res = $response->json();
//dd(collect($res)->where('number',"Rkaz320022"));
            $u = ProductDefaultUnit::Piece;
//dd($res , $u);


            foreach ($res as $r) {

                switch ($r['defaultUnitRef']) {
                    case 1;
                        $u = ProductDefaultUnit::Piece;
                        break;
                    case 4;
                        $u = ProductDefaultUnit::Pair;
                        break;
                    case 7;
                        $u = ProductDefaultUnit::Pack;
                        break;
                    case 12;
                        $u = ProductDefaultUnit::Kg;
                        break;
                }

                Product::query()->create([
                    'erp_code' => $r['number'],
                    'erp_id' => $r['id'],
                    'name' => $r['name'],
                    'default_unit' => $u,
                    'main_unit' => $u,
                ]);
            }

        } else {
            dd(123);
        }

    }

    public function webCustomers(AuthenticationService $authenticationService)
    {
        $cookie = $authenticationService->login('m-barzegar', 'Mb3421');
        GetCustomersJob::dispatchSync($cookie['authCookie']);


//        $cookie = $authenticationService->login('m-barzegar', 'Mb3421');
//
//
//        try {
//            $response = Http::withHeaders([
//                'Cookie'       => $cookie['authCookie'],
//                'Accept'       => 'application/json',
//                'Content-Type' => 'application/json',
//            ])
//                ->connectTimeout(10)   // حداکثر زمان برقراری اتصال
//                ->timeout(120)         // حداکثر زمان کل درخواست
//                ->retry(3, 2000, function ($exception, $request) {
//                    // فقط روی خطای اتصال/timeout دوباره تلاش کن
//                    return $exception instanceof ConnectionException;
//                }, throw: false)
//                ->get('http://radmanpakhsh/Sales/PartyManagement/Services/PartyManagementService.svc/GetCustomers');
//
//            if ($response->failed()) {
//                logger()->error('GetCustomers failed', [
//                    'status' => $response->status(),
//                    'body'   => $response->body(),
//                ]);
//                return null;
//            }
//
//            return $response->json();
//
//        } catch (ConnectionException $e) {
//            logger()->error('GetCustomers timeout/connection error: ' . $e->getMessage());
//            return null; // یا پیام مناسب به کاربر
//        }
    }

    public function importCustomers(AuthenticationService $authenticationService)
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        \App\Models\Customer::truncate();
        \App\Models\CustomerAddress::truncate();
        \App\Models\User::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $json = file_get_contents(storage_path('app/customers.json'));

        $customers = json_decode($json, true);

        foreach ($customers as $customer) {

            DB::transaction(function () use ($customer) {

                $addresses = $customer['addresses'];

                if (!empty($addresses)) {
                    $cityName = $addresses[0]['regionalDivisionName'];
                    $cityId = 67;
                    $province_id = 8;
                    $city = City::query()->where('name', $cityName)->first();

                    if ($city) {
                        $cityId = $city->id;

                        $province_id = $city->province_id;
                    }
                    preg_match('/09\d{9}/', $addresses[0]['phone'], $matches);

                    $mobile = $matches[0] ?? $addresses[0]['phone'];
                }


                if (isset($mobile) && intval($mobile) && !User::query()->where('mobile', $mobile)->exists()) {

                    $user = User::query()->create([
                        'name' => $customer['partyName'],
                        'mobile' => $mobile,

                    ]);

                    $customerRow = Customer::query()->create(
                        [
                            'user_id' => $user->id,
                            'erp_id' => $customer['id'],
                            'erp_code' => $customer['number'],
                            'province_id' => $province_id,
                            'city_id' => $cityId,
                            'branch_id' => 1,
                            'phone' => $mobile
                        ]
                    );
                    foreach ($customerRow->addresses as $address) {
                        $customerRow->addresses()->create([
                            'addressDetail' => $address['addressDetail'],
                            'erp_addressId' => $address['id'],
                            'name' => $address['name'],
                            'phone' => $matches[1],

                        ]);
                    }
                } else {
                    Log::info("خطا در ایمپورت مشتری ها", ['erp_id' => $customer['id'],
                        'erp_code' => $customer['number']]);
                }


            });
        }

        return "import Successfully";
    }

    public function getProductByCode(AuthenticationService $authenticationService, $code)
    {
        return $authenticationService->getProductByCode('m-barzegar', 'Mb3421', $code);
    }

    public function getCustomerByCode(AuthenticationService $authenticationService)
    {
        return $authenticationService->getCustomerByCode('m-barzegar', 'Mb3421');
    }

    public function getParty(AuthenticationService $authenticationService)
    {
        return $authenticationService->getParty('m-barzegar', 'Mb3421');
    }


    public function getBranches(AuthenticationService $authenticationService)
    {
        $res= $authenticationService->getBranches('m-barzegar', 'Mb3421');
        dd($res->json());
    }


    public function GetProductsByInventoryID(AuthenticationService $authenticationService)
    {
        $cookie = $authenticationService->login('m-barzegar',
            'Mb3421');

        $url = 'http://radmanpakhsh/Sales/ProductManagement/Services/ProductManagementService.svc/GetProductsByInventoryID';

        $response = Http::withHeaders([
            'Cookie' => $cookie['authCookie'],
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($url, [

            'InventoryID' => 85, // شناسه انبار
            'PlantID' => 48,  // شناسه مرکز نگهداری
            'ProductID' => 68662, // شناسه محصول

        ]);

// دریافت خروجی

// بررسی وضعیت درخواست
        if ($response->successful()) {
            dd($response->json());
        } else {
            dd([
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        }

    }

}
