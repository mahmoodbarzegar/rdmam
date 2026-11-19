<div class="space-y-6" dir="rtl">

    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">
                مشتریان غیرفعال
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                مدیریت و جستجوی مشتریان غیرفعال
            </p>
        </div>

        <div class="flex items-center gap-2 rounded-lg bg-red-50 px-4 py-2 text-sm text-red-700">
            <span class="h-2 w-2 rounded-full bg-red-500"></span>
            <span>لیست مشتریان غیرفعال</span>
        </div>
    </div>

    {{-- Filters --}}
    <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
        <div class="grid grid-cols-1 gap-3 md:grid-cols-2 lg:grid-cols-3">

            {{-- Search --}}
            <div class="relative lg:col-span-2">
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                    <svg class="h-5 w-5 text-gray-400" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="1.8"
                              d="m21 21-4.35-4.35m1.85-5.15a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>

                <input
                    type="text"
                    wire:model.live.debounce.400ms="search"
                    placeholder="جستجو نام، نام کسب‌وکار، موبایل، شهر یا استان..."
                    class="w-full rounded-lg border border-gray-300 bg-white py-2.5 pr-10 pl-4 text-sm text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                />
            </div>

            {{-- Status --}}
            <div>
                <select
                    wire:model.live="status"
                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-700 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                >
                    <option value="">همه وضعیت‌ها</option>

                    @foreach($statuses as $item)
                        <option value="{{ $item->value }}">
                            {{ $this->getStatusLabel($item->value) }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        {{-- Filter Footer --}}
        <div class="mt-4 flex flex-wrap items-center justify-between gap-3 border-t border-gray-100 pt-4">
            <div class="text-sm text-gray-500">
                تعداد نتایج:
                <span class="font-semibold text-gray-800">
                    {{ number_format($customers->total()) }}
                </span>
            </div>

            @if($search || $status)
                <button
                    type="button"
                    wire:click="clearFilters"
                    class="text-sm font-medium text-red-600 transition hover:text-red-700"
                >
                    پاک کردن فیلترها
                </button>
            @endif
        </div>
    </div>

    {{-- Loading --}}
    <div wire:loading.delay wire:target="search,status,gotoPage,previousPage,nextPage"
         class="text-sm text-indigo-600">
        در حال دریافت اطلاعات...
    </div>

    {{-- Desktop Table --}}
    <div class="hidden overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm md:block">

        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap text-right text-sm">
                <thead class="bg-gray-50 text-xs font-semibold text-gray-600">
                <tr>
                    <th class="px-5 py-4">#</th>
                    <th class="px-5 py-4">نام مشتری</th>
                    <th class="px-5 py-4">نام کسب‌وکار</th>
                    <th class="px-5 py-4">موبایل</th>
                    <th class="px-5 py-4">استان</th>
                    <th class="px-5 py-4">شهر</th>
                    <th class="px-5 py-4">وضعیت</th>
                    <th class="px-5 py-4">عملیات</th>
                </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                @forelse($customers as $customer)
                    <tr wire:key="customer-{{ $customer->id }}"
                        class="transition hover:bg-gray-50">

                        <td class="px-5 py-4 text-gray-400">
                            {{ $customers->firstItem() + $loop->index }}
                        </td>

                        <td class="px-5 py-4 font-medium text-gray-800">
                            {{ $customer->user?->name ?? '---' }}
                        </td>

                        <td class="px-5 py-4 text-gray-600">
                            {{ $customer->business_name ?: '---' }}
                        </td>

                        <td class="px-5 py-4 text-gray-600" dir="ltr">
                            {{ $customer->user?->mobile ?? '---' }}
                        </td>

                        <td class="px-5 py-4 text-gray-600">
                            {{ $customer->province?->name ?? '---' }}
                        </td>

                        <td class="px-5 py-4 text-gray-600">
                            {{ $customer->city?->name ?? '---' }}
                        </td>

                        <td class="px-5 py-4">
                                <span
                                    class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium ring-1 ring-inset {{ $this->getStatusClasses($customer->status->value ?? $customer->status) }}">
                                    {{ $this->getStatusLabel($customer->status->value ?? $customer->status) }}
                                </span>
                        </td>
                        <td class="px-5 py-4">
                            <a
                                href="{{ route('branchAdmin.customers.show', $customer) }}"
                                wire:navigate
                                class="inline-flex items-center gap-1.5 rounded-lg border border-indigo-200
               bg-indigo-50 px-3 py-2 text-xs font-medium text-indigo-700
               transition hover:bg-indigo-100"
                            >
                                مشاهده
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-12 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <svg class="h-10 w-10 text-gray-300"
                                     fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="1.5"
                                          d="M20 13V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8m4-7-3 3m0-3 3 3"/>
                                </svg>
                                <p class="font-medium text-gray-600">
                                    مشتری‌ای یافت نشد
                                </p>
                                <span class="text-xs text-gray-400">
                                        عبارت جستجو یا فیلترها را تغییر دهید.
                                    </span>
                            </div>
                        </td>
                    </tr>
                @endforelse

                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($customers->hasPages())
            <div class="border-t border-gray-100 px-5 py-4">
                {{ $customers->links() }}
            </div>
        @endif

    </div>

    {{-- Mobile Cards --}}
    <div class="space-y-3 md:hidden">

        @forelse($customers as $customer)
            <div wire:key="customer-mobile-{{ $customer->id }}"
                 class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">

                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <h3 class="truncate font-semibold text-gray-800">
                            {{ $customer->user?->name ?? '---' }}
                        </h3>

                        <p class="mt-1 truncate text-xs text-gray-500">
                            {{ $customer->business_name ?: 'بدون نام کسب‌وکار' }}
                        </p>
                    </div>

                    <span
                        class="shrink-0 rounded-full px-2.5 py-1 text-xs font-medium ring-1 ring-inset {{ $this->getStatusClasses($customer->status->value ?? $customer->status) }}">
                        {{ $this->getStatusLabel($customer->status->value ?? $customer->status) }}
                    </span>
                </div>

                <div class="mt-4 grid grid-cols-2 gap-3 border-t border-gray-100 pt-3">

                    <div>
                        <p class="text-xs text-gray-400">شماره موبایل</p>
                        <p class="mt-1 text-sm font-medium text-gray-700" dir="ltr">
                            {{ $customer->user?->mobile ?? '---' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-400">استان و شهر</p>
                        <p class="mt-1 text-sm text-gray-700">
                            {{ $customer->province?->name ?? '---' }}
                            -
                            {{ $customer->city?->name ?? '---' }}
                        </p>
                    </div>

                </div>
            </div>
        @empty
            <div class="rounded-xl border border-gray-200 bg-white px-4 py-10 text-center">
                <p class="text-sm text-gray-500">
                    مشتری‌ای با مشخصات موردنظر یافت نشد.
                </p>
            </div>
        @endforelse

        {{-- Mobile Pagination --}}
        @if($customers->hasPages())
            <div class="rounded-xl border border-gray-200 bg-white p-4">
                {{ $customers->links() }}
            </div>
        @endif

    </div>

</div>
