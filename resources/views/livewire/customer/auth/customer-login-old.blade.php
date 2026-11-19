<div dir="rtl" class="max-w-md mx-auto my-6">
    <h1 class="text-xl font-bold mb-6 text-center">ورود به حساب کاربری</h1>

    <div class="flex border rounded-lg overflow-hidden mb-6">
        <button class="flex-1 py-2', 'bg-blue-600 text-white">
            با شماره موبایل
        </button>
    </div>

    @if(session('status')) <div class="bg-green-50 text-green-700 p-3 rounded mb-4 text-sm">{{ session('status') }}</div> @endif
    @if(session('error')) <div class="bg-red-50 text-red-700 p-3 rounded mb-4 text-sm">{{ session('error') }}</div> @endif


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

    <div class="text-center mt-4 text-sm">
        {{--  حساب کاربری ندارید؟ <a href="{{ route('register') }}" class="text-blue-600" wire:navigate>ثبت‌نام</a>  --}}
    </div>
</div>
