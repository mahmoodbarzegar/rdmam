<?php

namespace App\Livewire\Customer\Auth;

use App\Models\Branch;
use App\Models\City;
use App\Models\Customer;
use App\Models\Province;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CustomerRegister extends Component
{
    public string $name = '';
    public string $mobile = '';
    public string $email = '';
    public string $password = '';
    public string $business_name = '';

    public string $national_code = '';
    public string $password_confirmation = ''; // نام باید دقیقاً همین باشد تا قانون Validation "confirmed" آن را تشخیص دهد

    public bool $otpSent = false;
    public string $otpCode = '';

    public ?int $province_id = null;
    public ?int $branch_id = null;


    public ?int $city_id = null;
    public ?bool $registered = false;


    #[Computed]
    public function branches()
    {
        if (!$this->city_id) {
            return collect();
        }
        return Branch::query()
            ->where('province_id', $this->province_id)
            ->where('city_id', $this->city_id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    #[Computed]
    public function provinces()
    {
        return Province::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    #[Computed]
    public function cities()
    {
        if (!$this->province_id) {
            return collect();
        }

        return City::query()
            ->where('province_id', $this->province_id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    // وقتی استان عوض شد، شهر قبلی ریست شود
    public function updatedProvinceId(): void
    {
        $this->city_id = null;
        $this->resetValidation('city_id');
    }


    protected function baseRules(): array
    {
        return [
            'name' => 'required|min:3',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'business_name' => 'required|min:3',
            'national_code' => 'required|min:10',
            'mobile' => ['required', 'regex:/^09[0-9]{9}$/', Rule::unique('users', 'mobile')]
        ];
    }

    // مرحله ۱ (ثبت‌نام با موبایل): اعتبارسنجی و ارسال OTP
    public function sendOtp(OtpService $otpService): void
    {
        $this->validate(
            $this->baseRules(), [
                'name.required' => 'نام وارد نشده است.',
                'name.min' => 'نام باید حداقل سه کلمه باشد.',
                'business_name.required' => 'نام شرکت / فروشگاه  وارد نشده است.',
                'business_name.min' => 'نام شرکت / فروشگاه  باید حداقل سه کلمه باشد.',
                'national_code.required' => 'کد / شناسه ملی  وارد نشده است.',
                'national_code.min' => 'کد / شناسه ملی  باید حداقل 10 عدد باشد.',
                'mobile.regex' => 'شماره موبایل معتبر نیست.',
                'mobile.unique' => 'این شماره قبلاً ثبت‌نام کرده است.',
                'province_id.required' => 'انتخاب شهر الزامی است.',
                'province_id.exists' => 'شهر انتخاب‌شده معتبر نیست.',
                'city_id.required' => 'انتخاب شهر الزامی است.',
                'city_id.exists' => 'شهر انتخاب‌شده معتبر نیست.',
            ]
        );

        $result = $otpService->generateAndSend($this->mobile);

        if ($result['success']) {
            $this->otpSent = true;
        }
        session()->flash($result['success'] ? 'status' : 'error', $result['message']);
    }

    public function resendOtp(OtpService $otpService): void
    {
        $this->sendOtp($otpService);
    }

    public function getSecondsUntilResendProperty(): int
    {
        return app(OtpService::class)->secondsUntilResend($this->mobile);
    }

    // مرحله ۲: تایید کد و ساخت حساب
    public function verifyAndRegister(OtpService $otpService): void
    {
        $this->validate(['otpCode' => 'required|digits:5']);

        $result = $otpService->verify($this->mobile, $this->otpCode);

        if (!$result['success']) {
            $this->addError('otpCode', $result['message']);
            return;
        }

        DB::transaction(function () {
            $user = User::create([
                'name' => $this->name,
                'mobile' => $this->mobile,
            ]);

            Customer::query()->create(
                [
                    'user_id' => $user->id,
                    'business_name' => $this->business_name,
                    'national_code' => $this->national_code,
                    'province_id' => $this->province_id,
                    'city_id' => $this->city_id,
                    'branch_id' => $this->branch_id,
                ]
            );
        });


        $this->registered = true;

        session()->flash('status', 'ثبت نام شما انجام شد و پس از تایید مدیر شعبه فعال میشود');

    }


    public function render()
    {
        return view('livewire.customer.auth.customer-register')->layout('layouts.customer-layout');
    }
}
