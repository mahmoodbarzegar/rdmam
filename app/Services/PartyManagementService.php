<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class PartyManagementService
{
    protected function client(): PendingRequest
    {
        return Http::baseUrl(config('services.radman.base_url'))
            ->timeout(config('services.radman.timeout'))
            ->acceptJson()
            ->asJson()
            ->retry(2, 200, throw: false);
    }

    // ---------- GET ----------

    public function getCustomers(array $query = []): array
    {
        return $this->client()->get('/GetCustomers', $query)->throw()->json();
    }

    public function getCustomerAccounts(array $query = []): array
    {
        return $this->client()->get('/GetCustomerAccounts', $query)->throw()->json();
    }

    public function getBrokers(array $query = []): array
    {
        return $this->client()->get('/GetBrokers', $query)->throw()->json();
    }

    // ---------- POST ----------

    public function insertCustomer(array $data): array
    {
        return $this->client()->post('/InsertCustomer', $data)->throw()->json();
    }

    public function updateCustomer(array $data): array
    {
        return $this->client()->post('/UpdateCustomer', $data)->throw()->json();
    }

    public function placeCustomer(array $data): array
    {
        return $this->client()->post('/PlaceCustomer', $data)->throw()->json();
    }
}
