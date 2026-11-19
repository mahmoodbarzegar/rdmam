<div dir="rtl" class="min-h-screen bg-slate-100 flex items-center justify-center p-4">

    <div class="w-full max-w-6xl bg-white rounded-3xl shadow-xl overflow-hidden grid grid-cols-1 lg:grid-cols-2">

        {{-- بخش معرفی --}}
        <div class="hidden lg:flex flex-col justify-between bg-slate-900 text-white p-12 relative overflow-hidden">

            <div class="absolute -top-24 -left-24 w-80 h-80 bg-orange-600/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -right-24 w-80 h-80 bg-orange-600/10 rounded-full blur-3xl"></div>

            <div class="relative z-10">
                <img
                    src="{{ asset('assets/images/radman-logo.png') }}"
                    alt="رادمان"
                    class="max-w-[190px] max-h-20 object-contain mb-16"
                >

                <h1 class="text-4xl font-extrabold leading-relaxed mb-6">
                    به سامانه رادمان خوش آمدید
                </h1>

                <p class="text-slate-300 leading-9 text-lg">
                    با ورود به حساب کاربری خود می‌توانید به خدمات و امکانات سامانه رادمان دسترسی داشته باشید.
                </p>
            </div>

            <div class="relative z-10">
                <div class="w-16 h-1 bg-orange-600 rounded-full mb-5"></div>
                <p class="text-sm text-slate-400">
                    سامانه هوشمند رادمان
                </p>
            </div>
        </div>

        {{-- فرم ورود --}}
        <div class="flex flex-col justify-center p-6 sm:p-10 lg:p-14">

            <div class="text-center mb-8">

                <img
                    src="{{ asset('assets/images/radman-logo.png') }}"
                    alt="رادمان"
                    class="max-w-[150px] max-h-16 object-contain mx-auto mb-8 lg:hidden"
                >

                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-800">
                    ورود به حساب کاربری
                </h2>

                <p class="text-slate-500 mt-3 text-sm leading-7">
                    برای ورود، شماره موبایل خود را وارد کنید.
                </p>
            </div>

            @if (session()->has('status'))
                <div class="mb-5 rounded-xl bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            @if (session()->has('login-error'))
                <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
                    {{ session('login-error') }}
                </div>
            @endif

            @if (!$otpSent)

                <form wire:submit="sendOtp" class="space-y-6">

                    <div>
                        <label for="mobile" class="block text-sm font-bold text-slate-700 mb-2">
                            شماره موبایل
                        </label>

                        <div class="relative">
                            <input
                                id="mobile"
                                type="tel"
                                wire:model="mobile"
                                placeholder="مثلاً 09123456789"
                                dir="ltr"
                                autocomplete="tel"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-4 text-left text-slate-800 placeholder:text-slate-400 focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-500/10 outline-none transition"
                            >
                        </div>

                        @error('mobile')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:target="sendOtp"
                        class="w-full rounded-xl bg-orange-600 hover:bg-orange-700 text-white font-bold py-4 transition flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed"
                    >
                        <span wire:loading.remove wire:target="sendOtp">
                            دریافت کد ورود
                        </span>

                        <span wire:loading.flex wire:target="sendOtp" class="items-center justify-center gap-2">
                            <svg class="animate-spin w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor"
                                      d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"/>
                            </svg>
                            <span>در حال ارسال...</span>
                        </span>
                    </button>

                </form>

            @else

                <form wire:submit="verifyOtpAndLogin" class="space-y-6">


                    <div>
                        <label for="otpCode" class="block text-sm font-bold text-slate-700 mb-2">
                            کد تأیید
                        </label>

                        <input
                            id="otpCode"
                            type="text"
                            wire:model="otpCode"
                            inputmode="numeric"
                            autocomplete="one-time-code"
                            maxlength="6"
                            placeholder="کد ارسال‌شده را وارد کنید"
                            dir="ltr"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-4 text-center text-xl tracking-[0.5em] font-bold text-slate-800 placeholder:text-slate-400 placeholder:tracking-normal focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-500/10 outline-none transition"
                        >

                        @error('otpCode')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:target="verifyOtpAndLogin"
                        class="w-full rounded-xl bg-orange-600 hover:bg-orange-700 text-white font-bold py-4 transition flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed"
                    >
                        <span wire:loading.remove wire:target="verifyOtpAndLogin">
                            ورود به سامانه
                        </span>

                        <span wire:loading.flex wire:target="verifyOtpAndLogin" class="items-center justify-center gap-2">
                            <svg class="animate-spin w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor"
                                      d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"/>
                            </svg>
                            <span>در حال بررسی...</span>
                        </span>
                    </button>

                    {{-- شمارنده ارسال مجدد؛ منطق اصلی Alpine حفظ شده --}}
                    <div
                        class="text-center mt-4 text-sm"
                        x-data="{ seconds: {{ $this->secondsUntilResend }} }"
                        x-init="
                            let interval = setInterval(() => {
                                if (seconds > 0) {
                                    seconds--;
                                } else {
                                    clearInterval(interval);
                                }
                            }, 1000)
                        "
                    >
                        <template x-if="seconds > 0">
                            <span class="text-slate-400">
                                ارسال مجدد کد تا
                                <span class="font-bold text-slate-600 tabular-nums" x-text="seconds"></span>
                                ثانیه دیگر
                            </span>
                        </template>

                        <template x-if="seconds === 0">
                            <button
                                type="button"
                                wire:click="resendOtp"
                                wire:loading.attr="disabled"
                                wire:target="resendOtp"
                                class="inline-flex items-center justify-center gap-2 font-bold text-orange-600 hover:text-orange-700 disabled:opacity-60 transition"
                            >
                                <span wire:loading.remove wire:target="resendOtp">
                                    ارسال مجدد کد
                                </span>

                                <span wire:loading.flex wire:target="resendOtp" class="items-center justify-center gap-2">
                                    <svg class="animate-spin w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"/>
                                        <path class="opacity-75" fill="currentColor"
                                              d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"/>
                                    </svg>
                                    <span>در حال ارسال...</span>
                                </span>
                            </button>
                        </template>
                    </div>

                </form>

            @endif

            <div class="mt-8 pt-6 border-t border-slate-100 text-center text-sm text-slate-500">
                حساب کاربری ندارید؟
                <a
                    href="{{ route('customer.register') }}"
                    class="font-bold text-orange-600 hover:text-orange-700 transition"
                >
                    ثبت‌نام کنید
                </a>
            </div>

        </div>
    </div>
</div>
