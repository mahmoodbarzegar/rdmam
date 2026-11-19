
<div class="space-y-6" dir="rtl">

    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">
                اطلاعات مشتری
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                مشاهده و مدیریت اطلاعات مشتری
            </p>
        </div>

        <a
            href="{{ route('branchAdmin.customers.list') }}"
            wire:navigate
            class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 19l-7-7 7-7"/>
            </svg>
            بازگشت به لیست
        </a>
    </div>

    {{-- Success Message --}}
    @if(session()->has('success'))
        <div class="flex items-center gap-2 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- Customer Information --}}
        <div class="space-y-6 lg:col-span-2">

            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

                <div class="border-b border-gray-100 px-5 py-4">
                    <h3 class="font-semibold text-gray-800">
                        اطلاعات شخصی و کسب‌وکار
                    </h3>
                </div>

                <div class="grid grid-cols-1 gap-6 p-5 sm:grid-cols-2">

                    {{-- Customer ID --}}
                    <div>
                        <p class="text-xs text-gray-400">شناسه مشتری</p>
                        <p class="mt-2 font-semibold text-gray-800">
                            {{ $customer->id }}
                        </p>
                    </div>

                    {{-- Name --}}
                    <div>
                        <p class="text-xs text-gray-400">نام و نام خانوادگی</p>
                        <p class="mt-2 font-medium text-gray-800">
                            {{ $customer->user?->name ?? '---' }}
                        </p>
                    </div>

                    {{-- Mobile --}}
                    <div>
                        <p class="text-xs text-gray-400">شماره موبایل</p>
                        <p class="mt-2 font-medium text-gray-800" dir="ltr">
                            {{ $customer->user?->mobile ?? '---' }}
                        </p>
                    </div>

                    {{-- Business Name --}}
                    <div>
                        <p class="text-xs text-gray-400">نام کسب‌وکار</p>
                        <p class="mt-2 font-medium text-gray-800">
                            {{ $customer->business_name ?: '---' }}
                        </p>
                    </div>

                    {{-- Province --}}
                    <div>
                        <p class="text-xs text-gray-400">استان</p>
                        <p class="mt-2 font-medium text-gray-800">
                            {{ $customer->province?->name ?? '---' }}
                        </p>
                    </div>

                    {{-- City --}}
                    <div>
                        <p class="text-xs text-gray-400">شهر</p>
                        <p class="mt-2 font-medium text-gray-800">
                            {{ $customer->city?->name ?? '---' }}
                        </p>
                    </div>

                    {{-- Current Status --}}
                    <div>
                        <p class="text-xs text-gray-400">وضعیت فعلی</p>
                        <p class="mt-2">
                            <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700">
                                {{ $this->statusLabel($customer->status->value ?? $customer->status) }}
                            </span>
                        </p>
                    </div>

                    {{-- Status Reason --}}
                    @if($customer->status_reason)
                        <div class="sm:col-span-2">
                            <p class="text-xs text-gray-400">دلیل وضعیت ثبت‌شده</p>
                            <p class="mt-2 rounded-lg bg-gray-50 p-3 text-sm leading-7 text-gray-700">
                                {{ $customer->status_reason }}
                            </p>
                        </div>
                    @endif

                    {{-- Approved At --}}
                    @if($customer->approved_at)
                        <div>
                            <p class="text-xs text-gray-400">تاریخ تأیید</p>
                            <p class="mt-2 text-sm font-medium text-gray-800">
                                {{ $customer->approved_at }}
                            </p>
                        </div>
                    @endif

                </div>
            </div>

        </div>

        {{-- Status Management --}}
        <div class="h-fit overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

            <div class="border-b border-gray-100 px-5 py-4">
                <h3 class="font-semibold text-gray-800">
                    تغییر وضعیت مشتری
                </h3>
                <p class="mt-1 text-xs text-gray-500">
                    وضعیت موردنظر را انتخاب و ذخیره کنید.
                </p>
            </div>

            <form wire:submit="updateStatus" class="space-y-5 p-5">

                {{-- Status --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        وضعیت جدید
                    </label>

                    <select
                        wire:model.live="status"
                        class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-700 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 @error('status') border-red-500 @enderror"
                    >
                        @foreach($statuses as $item)
                            <option value="{{ $item->value }}">
                                {{ $this->statusLabel($item->value) }}
                            </option>
                        @endforeach
                    </select>

                    @error('status')
                    <p class="mt-1 text-xs text-red-600">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Status Reason --}}
                @if($status !== \App\Enums\CustomerStatus::Active->value)

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            دلیل وضعیت انتخاب‌شده
                            <span class="text-red-500">*</span>
                        </label>

                        <textarea
                            wire:model="status_reason"
                            rows="4"
                            maxlength="1000"
                            placeholder="دلیل انتخاب این وضعیت را وارد کنید..."
                            class="w-full resize-y rounded-lg border border-gray-300 px-3 py-2.5 text-sm leading-6 text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 @error('status_reason') border-red-500 @enderror"
                        ></textarea>

                        @error('status_reason')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                        @enderror

                        <p class="mt-1 text-xs text-gray-400">
                            وارد کردن دلیل برای این وضعیت الزامی است.
                        </p>

{{--                        <div>--}}
{{--                            <input type="number" wire:model="credit">--}}
{{--                        </div>--}}
                    </div>

                @endif

                {{-- Info --}}
                <div class="rounded-lg bg-gray-50 p-3">
                    @if($status === \App\Enums\CustomerStatus::Active->value)
                        <div class="flex items-start gap-2">
                            <svg class="mt-0.5 h-5 w-5 shrink-0 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5 13l4 4L19 7"/>
                            </svg>
                            <p class="text-xs leading-6 text-gray-600">
                                با تأیید مشتری، شناسه مدیر تأییدکننده و تاریخ تأیید ثبت خواهد شد.
                            </p>
                        </div>
                    @else
                        <div class="flex items-start gap-2">
                            <svg class="mt-0.5 h-5 w-5 shrink-0 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 9v4m0 4h.01M10.3 3.86 1.82 18a2 2 0 0 0 1.7 3h16.96a2 2 0 0 0 1.7-3L13.7 3.86a2 2 0 0 0-3.4 0Z"/>
                            </svg>
                            <p class="text-xs leading-6 text-gray-600">
                                دلیل انتخاب وضعیت باید ثبت شود.
                            </p>
                        </div>
                    @endif
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:target="updateStatus"
                    class="flex w-full items-center justify-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-indigo-700 disabled:cursor-not-allowed disabled:opacity-50"
                >
                    <span wire:loading.remove wire:target="updateStatus">
                        ذخیره تغییرات
                    </span>

                    <span wire:loading wire:target="updateStatus">
                        در حال ذخیره...
                    </span>
                </button>

            </form>
        </div>

    </div>

</div>
