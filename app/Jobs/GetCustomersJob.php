<?php

namespace App\Jobs;

use App\Services\AuthenticationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GetCustomersJob implements ShouldQueue
{
    use  Queueable;

    public $timeout = 300;   // timeout خود job
    public $tries = 3;
    public $backoff = [30, 60, 120];

    public function __construct(public string $cookie)
    {

    }

    public function handle(): void
    {
        $path = storage_path('app/customers.json');

        $cookie = (new AuthenticationService())->login('m-barzegar', 'Mb3421');
        Http::withHeaders(['Cookie' => $cookie['authCookie'], 'Accept' => 'application/json'])
            ->connectTimeout(10)
            ->timeout(600)
            ->sink($path)          // مستقیم روی دیسک می‌نویسد، نه در RAM
            ->get('http://radmanpakhsh/Sales/PartyManagement/Services/PartyManagementService.svc/GetCustomers')
            ->throw();


//        Cache::rememberForever('customers', function () {
//            $response = Http::withHeaders([
//                'Cookie' => $this->cookie,
//                'Accept' => 'application/json',
//            ])->connectTimeout(10)
//                ->timeout(240)
//                ->get('http://radmanpakhsh/Sales/PartyManagement/Services/PartyManagementService.svc/GetCustomers')
//                ->throw();
//
//            return $response->json();
//        });
    }
}
