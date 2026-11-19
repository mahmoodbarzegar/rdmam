<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use GuzzleHttp\Cookie\CookieJar;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Crypt\RSA;
use phpseclib3\Math\BigInteger;
use RuntimeException;

class AuthenticationService
{
    private string $baseUrl =
        'http://radmanpakhsh/Framework/Services/AuthenticationService.svc';


    /**
     * @return array{sessionId: string, authCookie: string|null}
     */
    public function login(string $userName, string $password): array
    {
        // معادل WebClient: نگه داشتن کوکی‌ها بین دو درخواست
        $jar = new CookieJar();

        $http = Http::withOptions(['cookies' => $jar])
            ->acceptJson()
            ->timeout(30);

        // 1) دریافت session و کلید عمومی RSA
        $sessionResponse = $http->get($this->baseUrl . '/session');

        if ($sessionResponse->failed()) {
            throw new RuntimeException(
                'Session request failed: ' . $sessionResponse->body()
            );
        }

        $session = $sessionResponse->json();
        $sessionId = $session['id'];
        $modulus = $session['rsa']['M'];   // hex
        $exponent = $session['rsa']['E'];   // hex
        // 2) ساخت کلید عمومی RSA با padding از نوع PKCS#1 v1.5
        //    (در C# پارامتر false در Encrypt یعنی PKCS#1 v1.5)
        $publicKey = PublicKeyLoader::load([
            'n' => new BigInteger($modulus, 16),
            'e' => new BigInteger($exponent, 16),
        ])->withPadding(RSA::ENCRYPTION_PKCS1);

        // 3) رمزنگاری "sessionId**password" و تبدیل به hex
        $plain = $sessionId . '**' . $password;
        $encrypted = $publicKey->encrypt($plain);
        $encPass = strtoupper(bin2hex($encrypted));
        // اگر سرور hex حروف کوچک می‌خواهد strtoupper را حذف کنید

        // 4) ارسال درخواست لاگین
        $loginResponse = $http
            ->asJson()
            ->post($this->baseUrl . '/login', [
                'sessionId' => $sessionId,
                'username' => $userName,
                'password' => $encPass,
            ]);

        if ($loginResponse->failed()) {
            throw new RuntimeException(
                'Login failed: ' . $loginResponse->body()
            );
        }

        // 5) گرفتن کوکی احراز هویت (معادل Split(',')[1] در C#)
        $setCookies = $loginResponse->toPsrResponse()->getHeader('Set-Cookie');
        $authCookie = $setCookies[1] ?? ($setCookies[0] ?? null);

        return [
            'sessionId' => $sessionId,
            'authCookie' => $authCookie,
        ];
    }

    public function getProducts(string $userName, string $password)
    {
        $cookie = $this->login($userName, $password);

        $response = Http::withHeaders(['Cookie' => $cookie['authCookie']])->post(
            "http://radmanpakhsh/Sales/ProductManagement/Services/ProductManagementService.svc/GetProducts"
        )->body();

        return response()->json($response);

    }


    public function getProductByCode(string $userName, string $password, $code)
    {
        $cookie = $this->login($userName, $password);

        $response = Http::withHeaders(['Cookie' => $cookie['authCookie'], 'Accept' => 'application/json',
        ])->get(
            "http://radmanpakhsh/Logistics/MaterialManagement/WebServices/MaterialManagementService.svc/GetPartByCode",
            ['code' => $code]
        );

        dd($response->json());

    }

    public function getCustomerByCode(string $userName, string $password)
    {
        $cookie = $this->login($userName, $password);
        $response = Http::withHeaders(['Cookie' => $cookie['authCookie'], 'Accept' => 'application/json',
        ])->get(
            "http://radmanpakhsh/Sales/PartyManagement/Services/PartyManagementService.svc/GetCustomerAccounts",
            ['customerID' => "0223037"]
        );

        return $response;

    }

    public function getParty(string $userName, string $password)
    {
        $cookie = $this->login($userName, $password);

        $response = Http::withHeaders(['Cookie' => $cookie['authCookie'], 'Accept' => 'application/json',
        ])->post(
            "http://radmanpakhsh/General/PartyManagement/Services/PartyService.svc/GetParty",
            ["partRef" => "1744"]
        );

        return $response;

    }

    public function getBranches(string $userName, string $password)
    {
        $cookie = $this->login($userName, $password);

        $response = Http::withHeaders(['Cookie' => $cookie['authCookie'], 'Accept' => 'application/json',
        ])->get(
            "http://radmanpakhsh/General/BranchManagement/Services/BranchService.svc/GetBranches",
        );

        return $response;

    }

}
