<?php

namespace App\Livewire\BranchAdmin\Auth;

use App\Models\User;
use App\Services\OtpService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BranchAdminLogin extends Component
{

    public string $mobile = '';
    public bool $otpSent = false;
    public string $otpCode = '';

    public function sendOtp(OtpService $otpService): void
    {
        $this->validate(['mobile' => 'required|regex:/^09[0-9]{9}$/'], ['mobile.regex' => 'شماره موبایل معتبر نیست.']);

        if (!User::where('mobile', $this->mobile)->exists()) {
            $this->addError('mobile', 'کاربری با این شماره یافت نشد. ابتدا ثبت‌نام کنید.');
            return;
        }

        if (!User::query()->where('mobile', $this->mobile)->whereRelation('branchAdminAccount','status','active')->exists()) {

            $this->addError('mobile', 'وضعیت کاربری شما فعال نیست یا شما اجازه ورود به این پنل ندارید.');
            return;
        }

        $result = $otpService->generateAndSend($this->mobile);

        $this->otpSent = $result['success'];

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

    public function verifyOtpAndLogin(OtpService $otpService): void
    {
        $this->validate(['otpCode' => 'required|digits:5']);

        $result = $otpService->verify($this->mobile, $this->otpCode);
        if (!$result['success']) {
            $this->addError('otpCode', $result['message']);
            return;
        }

        Auth::login($result['user'], true);

        $this->afterLogin();
    }

    protected function afterLogin(): void
    {

        $this->redirectRoute( 'branchAdmin.customers.list');
    }
    public function render()
    {
        return view('livewire.branch-admin.auth.branch-admin-login')->layout('layouts.branch-admin-layout');
    }
}
