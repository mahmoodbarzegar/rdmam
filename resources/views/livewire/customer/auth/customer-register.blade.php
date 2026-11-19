
<div class="min-h-screen bg-slate-100 flex items-center justify-center p-4" dir="rtl">
    <div class="w-full max-w-6xl bg-white rounded-3xl shadow-xl overflow-hidden grid grid-cols-1 md:grid-cols-2">

        {{-- معرفی شرکت --}}
        <div class="hidden md:flex flex-col justify-between bg-slate-900 text-white p-10">
            <div>
                <img src="{{ asset('assets/images/radman-logo.png') }}"
                     alt="رادمان"
                     class="max-w-[190px] max-h-20 object-contain mb-12">

                <h2 class="text-3xl font-black leading-relaxed mb-5">
                    همکاری با رادمان را شروع کنید
                </h2>

                <p class="text-slate-300 leading-8">
                    با ثبت‌نام در سامانه، به خدمات و امکانات اختصاصی شرکت دسترسی خواهید داشت.
                </p>
            </div>

            <div class="text-sm text-slate-400">
                تمامی حقوق این سامانه محفوظ است.
            </div>
        </div>

        {{-- فرم ثبت‌نام --}}
        <div class="p-6 sm:p-10 md:p-12">

            <div class="md:hidden mb-8">
                <img src="{{ asset('assets/images/radman-logo.png') }}"
                     alt="رادمان"
                     class="max-w-[160px] max-h-16 object-contain">
            </div>

            <div class="mb-8">
                <h2 class="text-2xl font-black text-slate-900 mb-3">
                    ایجاد حساب کاربری
                </h2>
                <p class="text-sm text-slate-500 leading-7">
                    اطلاعات زیر را تکمیل کنید تا حساب کاربری شما ایجاد شود.
                </p>
            </div>

            @if (session()->has('status'))
                <div class="mb-5 rounded-xl bg-green-50 border border-green-200 text-green-700 p-4 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 p-4 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            @if (!$otpSent)
                <form wire:submit="sendOtp" class="space-y-5">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                نام و نام خانوادگی
                            </label>
                            <input
                                type="text"
                                wire:model="name"
                                placeholder="نام و نام خانوادگی"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                            >
                            @error('name')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                نام فروشگاه / کسب‌وکار
                            </label>
                            <input
                                type="text"
                                wire:model="business_name"
                                placeholder="نام فروشگاه"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                            >
                            @error('business_name')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                شماره موبایل
                            </label>
                            <input
                                type="tel"
                                wire:model="mobile"
                                placeholder="09123456789"
                                dir="ltr"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-left outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                            >
                            @error('mobile')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                کد ملی
                            </label>
                            <input
                                type="text"
                                wire:model="national_code"
                                placeholder="کد ملی"
                                maxlength="10"
                                dir="ltr"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-left outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                            >
                            @error('national_code')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                استان
                            </label>
                            <select
                                wire:model.live="province_id"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                            >
                                <option value="">انتخاب استان</option>
                                @foreach($this->provinces as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                            @error('province_id')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                شهر
                            </label>
                            <select
                                wire:model.live="city_id"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                            >
                                <option value="">انتخاب شهر</option>
                                @foreach($this->cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                            @error('city_id')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                شعبه
                            </label>
                            <select
                                wire:model="branch_id"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                            >
                                <option value="">انتخاب شعبه</option>
                                @foreach($this->branches() as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                            @error('branch_id')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:target="sendOtp"
                        class="w-full flex items-center justify-center gap-2 bg-orange-600 hover:bg-orange-700 disabled:opacity-60 disabled:cursor-not-allowed text-white font-bold py-4 rounded-xl transition"
                    >
                        <span wire:loading.remove wire:target="sendOtp">
                            دریافت کد تایید و ثبت‌نام
                        </span>

                        <span wire:loading.flex wire:target="sendOtp"
                              class="items-center justify-center gap-2">
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

            @elseif(!$registered)
                <form wire:submit="verifyAndRegister" class="space-y-5">


                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">
                            کد تایید
                        </label>

                        <input
                            type="text"
                            wire:model="otpCode"
                            maxlength="6"
                            inputmode="numeric"
                            placeholder="------"
                            dir="ltr"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-4 text-center text-2xl tracking-[0.7em] outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                        >

                        @error('otpCode')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:target="verifyAndRegister"
                        class="w-full flex items-center justify-center gap-2 bg-orange-600 hover:bg-orange-700 disabled:opacity-60 disabled:cursor-not-allowed text-white font-bold py-4 rounded-xl transition"
                    >
                        <span wire:loading.remove wire:target="verifyAndRegister">
                            تایید کد و تکمیل ثبت‌نام
                        </span>

                        <span wire:loading.flex wire:target="verifyAndRegister"
                              class="items-center justify-center gap-2">
                            <svg class="animate-spin w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor"
                                      d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"/>
                            </svg>
                            <span>در حال بررسی...</span>
                        </span>
                    </button>
                </form>

                {{-- ارسال مجدد کد؛ منطق اولیه حفظ شده --}}
                <div class="mt-5 flex justify-center">
                    <button
                        type="button"
                        wire:click="resendOtp"
                        @if($this->secondsUntilResend > 0) disabled @endif
                        wire:loading.attr="disabled"
                        wire:target="resendOtp"
                        class="text-sm text-orange-600 hover:text-orange-700 disabled:text-slate-400 disabled:cursor-not-allowed"
                    >
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

                        <span wire:loading.flex wire:target="resendOtp"
                              class="items-center justify-center gap-2">
                            <svg class="animate-spin w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor"
                                      d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"/>
                            </svg>
                            <span>در حال ارسال...</span>
                        </span>
                    </button>
                </div>

            @else
                <div class="rounded-xl bg-green-50 border border-green-200 p-5 text-center text-green-700">
                    ثبت‌نام شما با موفقیت انجام شد.
                </div>
            @endif

            <div class="mt-8 pt-6 border-t border-slate-100 text-center text-sm text-slate-500">
                قبلاً ثبت‌نام کرده‌اید؟
                <a href="{{ route('customer.login') }}"
                   class="font-bold text-orange-600 hover:text-orange-700">
                    ورود به حساب کاربری
                </a>
            </div>
        </div>
    </div>
</div>
