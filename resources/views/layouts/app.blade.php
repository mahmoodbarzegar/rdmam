<div dir="rtl" class="max-w-md mx-auto">
    <h1 class="text-xl font-bold mb-6 text-center">ورود به حساب کاربری</h1>

    <div class="flex border rounded-lg overflow-hidden mb-6">
        <button wire:click="switchMethod('mobile')" @class(['flex-1 py-2', 'bg-blue-600 text-white' => $method === 'mobile'])>
            با شماره موبایل
        </button>
        <button wire:click="switchMethod('email')" @class(['flex-1 py-2', 'bg-blue-600 text-white' => $method === 'email'])>
            با ایمیل
        </button>
    </div>

    @if(session('status')) <div class="bg-green-50 text-green-700 p-3 rounded mb-4 text-sm">{{ session('status') }}</div> @endif
    @if(session('login-error')) <div class="bg-red-50 text-red-700 p-3 rounded mb-4 text-sm">{{ session('login-error') }}</div> @endif

    @if($method === 'mobile')
        @if(!$otpSent)
            <div>
                <label class="text-sm">شماره موبایل</label>
                <input type="text" wire:model="mobile" placeholder="09xxxxxxxxx" class="w-full border rounded-lg p-3" dir="ltr">
                @error('mobile') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
            <button wire:click="sendOtp" wire:loading.attr="disabled" class="w-full bg-blue-600 text-white py-3 rounded-lg mt-6">
                دریافت کد ورود
            </button>
        @else
            <div wire:key="otp-login-step">
                <label class="text-sm">کد ۵ رقمی ارسال‌شده به {{ $mobile }}</label>
                <input type="text" wire:model="otpCode" maxlength="5" inputmode="numeric" class="w-full border rounded-lg p-3 text-center tracking-widest text-lg" dir="ltr">
                @error('otpCode') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
            <button wire:click="verifyOtpAndLogin" wire:loading.attr="disabled" class="w-full bg-blue-600 text-white py-3 rounded-lg mt-6">
                ورود
            </button>

            <div class="text-center mt-3 text-sm" x-data="{ seconds: {{ $this->secondsUntilResend }} }" x-init="
                let interval = setInterval(() => { if (seconds > 0) seconds--; else clearInterval(interval); }, 1000)
            ">
                <template x-if="seconds > 0">
                    <span class="text-gray-400">ارسال مجدد کد تا <span x-text="seconds"></span> ثانیه دیگر</span>
                </template>
                <template x-if="seconds === 0">
                    <button wire:click="resendOtp" class="text-blue-600">ارسال مجدد کد</button>
                </template>
            </div>
        @endif
    @else
        <div>
            <label class="text-sm">ایمیل</label>
            <input type="email" wire:model="email" class="w-full border rounded-lg p-3" dir="ltr">
            @error('email') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="mt-4">
            <label class="text-sm">رمز عبور</label>
            <input type="password" wire:model="password" class="w-full border rounded-lg p-3" dir="ltr">
        </div>
        <div class="flex justify-between items-center mt-3 text-sm">
            <label class="flex items-center gap-2"><input type="checkbox" wire:model="remember"> مرا به خاطر بسپار</label>
            <a href="{{ route('password.request') }}" class="text-blue-600" wire:navigate>فراموشی رمز عبور</a>
        </div>
        <button wire:click="loginWithEmail" wire:loading.attr="disabled" class="w-full bg-blue-600 text-white py-3 rounded-lg mt-6">
            ورود
        </button>
    @endif

    <div class="text-center mt-4 text-sm">
        حساب کاربری ندارید؟ <a href="{{ route('customer-register') }}" class="text-blue-600" wire:navigate>ثبت‌نام</a>
    </div>
</div>
