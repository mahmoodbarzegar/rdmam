
<div>
    {{-- Overlay --}}
    <div
        x-data
        x-show="$wire.open"
        x-cloak
        x-transition.opacity.duration.300ms
        @click="$wire.closeDrawer()"
        @keydown.escape.window="$wire.closeDrawer()"
        class="fixed inset-0 z-[80] bg-slate-900/40 backdrop-blur-[2px]"
    ></div>

    {{-- Drawer --}}
    <aside
        x-data
        x-show="$wire.open"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed right-0 top-0 z-[90] flex h-dvh w-full max-w-md flex-col bg-white shadow-2xl"
        dir="rtl"
    >

        {{-- Header --}}
        <div class="flex shrink-0 items-center justify-between border-b border-slate-100 px-5 py-5">

            <div>
                <h2 class="text-lg font-bold text-slate-800">
                    سبد خرید
                </h2>

                <p class="mt-1 text-xs text-slate-400">
                    {{ count($cart) }} محصول در سبد خرید
                </p>
            </div>

            <button
                type="button"
                wire:click="closeDrawer"
                class="flex h-9 w-9 items-center justify-center rounded-xl text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                aria-label="بستن سبد خرید"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

        </div>

        {{-- Cart Items --}}
        <div class="flex-1 overflow-y-auto px-5 py-4">

            @forelse($cart as $key => $item)

                <div
                    wire:key="cart-item-{{ $key }}"
                    class="mb-4 rounded-2xl border border-slate-100 bg-white p-4 transition hover:border-slate-200"
                >

                    {{-- Product name / code --}}
                    <div class="flex items-start justify-between gap-3">

                        <div class="min-w-0">
                            <h3 class="font-bold leading-6 text-slate-800">
                                {{ $item['name'] }}
                            </h3>

                            <p class="mt-1 text-xs text-slate-400">
                                کد محصول:

                                <span class="font-medium text-slate-600">
                                    {{ $item['product_code'] ?? '---' }}
                                </span>
                            </p>
                        </div>

                        {{-- Remove --}}
                        <button
                            type="button"
                            wire:click="removeItem('{{ $key }}')"
                            wire:confirm="آیا از حذف این محصول اطمینان دارید؟"
                            wire:loading.attr="disabled"
                            wire:target="removeItem('{{ $key }}')"
                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-slate-400 transition hover:bg-red-50 hover:text-red-500 disabled:opacity-50"
                            title="حذف محصول"
                        >
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                      d="M6 7h12m-10 0V5h8v2m-7 0v12m6-12v12M5 7l1 14h12l1-14"/>
                            </svg>
                        </button>

                    </div>

                    {{-- Purchase type --}}
                    <div class="mt-4 flex items-center justify-between">

                        <span class="text-xs text-slate-400">
                            نوع خرید
                        </span>

                        @if(($item['purchase_type'] ?? 'unit') === 'carton')

                            <span class="rounded-lg bg-orange-50 px-3 py-1.5 text-xs font-semibold text-orange-700">
                                <span class="inline-block h-1.5 w-1.5 rounded-full bg-orange-500"></span>
                                کارتنی
                            </span>

                        @else

                            <span class="rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600">
                                <span class="inline-block h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                عددی
                            </span>

                        @endif

                    </div>

                    {{-- Quantity and price --}}
                    <div class="mt-3 flex items-center justify-between border-t border-slate-100 pt-3">

                        <div>
                            <p class="text-xs text-slate-400">
                                تعداد
                            </p>

                            <p class="mt-1 font-bold text-slate-700">
                                {{ number_format((int) $item['quantity']) }}

                                <span class="text-xs font-normal text-slate-400">
                                    {{ $item['unit_label'] ?? 'عدد' }}
                                </span>
                            </p>
                        </div>

                        <div class="text-left">
                            <p class="text-xs text-slate-400">
                                قیمت کل
                            </p>

                            <p class="mt-1 font-bold text-slate-800">
                                {{ number_format($item['price'] * $item['quantity']) }}

                                <span class="text-xs font-normal text-slate-400">
                                    تومان
                                </span>
                            </p>
                        </div>

                    </div>

                    {{-- Settlement deadline --}}
                    <div class="mt-3 flex items-center justify-between gap-2 rounded-xl bg-amber-50 px-3 py-2.5">

                        <div class="flex items-center gap-2 text-amber-700">

                            <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                      d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>

                            <span class="text-xs">
                                مهلت تسویه محصول
                            </span>

                        </div>

                        <span class="text-sm font-bold text-amber-700">
                            @if(is_numeric($item['settlement_deadline_days'] ?? null))
                                {{ number_format((float) $item['settlement_deadline_days'], 0) }}
                                روز
                            @else
                                تعیین نشده
                            @endif
                        </span>

                    </div>

                </div>

            @empty

                {{-- Empty cart --}}
                <div class="flex h-full flex-col items-center justify-center text-center">

                    <div class="flex h-20 w-20 items-center justify-center rounded-full bg-slate-50">

                        <svg class="h-9 w-9 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M3 3h2l2.4 12.2a2 2 0 002 1.6h8.9a2 2 0 002-1.6L22 8H6"/>
                            <circle cx="10" cy="21" r="1"/>
                            <circle cx="18" cy="21" r="1"/>
                        </svg>

                    </div>

                    <h3 class="mt-4 font-bold text-slate-700">
                        سبد خرید شما خالی است
                    </h3>

                    <p class="mt-2 text-sm text-slate-400">
                        هنوز محصولی به سبد خرید اضافه نکرده‌اید.
                    </p>

                    <button
                        type="button"
                        wire:click="closeDrawer"
                        class="mt-5 rounded-xl bg-orange-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-700"
                    >
                        مشاهده محصولات
                    </button>

                </div>

            @endforelse

        </div>

        {{-- Footer --}}
        @if(count($cart))

            <div class="shrink-0 border-t border-slate-100 bg-white px-5 py-5">

                {{-- Weighted settlement deadline --}}
                <div class="mb-4 rounded-xl border border-orange-100 bg-orange-50 p-4">

                    <div class="flex items-center justify-between gap-3">

                        <div>
                            <p class="text-sm font-semibold text-slate-700">
                                 مهلت تسویه کل :
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                بر اساس مبلغ محصولات سبد
                            </p>
                        </div>

                        <div class="text-left">

                            @if($this->weightedSettlementDeadline !== null)

                                <span class="text-xl font-bold text-orange-700">
                                    {{ $this->weightedSettlementDeadline }}
                                </span>

                                <span class="text-xs text-orange-600">
                                    روز
                                </span>

                            @else

                                <span class="text-xs font-medium text-slate-400">
                                    قابل محاسبه نیست
                                </span>

                            @endif

                        </div>

                    </div>

                </div>

                {{-- Total --}}
                <div class="mb-4 flex items-center justify-between">

                    <span class="text-sm text-slate-500">
                        جمع کل سبد خرید
                    </span>

                    <span class="text-xl font-bold text-slate-800">
                        {{ number_format($this->total) }}

                        <span class="text-xs font-normal text-slate-400">
                            تومان
                        </span>
                    </span>

                </div>

                {{-- Checkout --}}
                <a
                    href="#"
                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-orange-600 px-4 py-3.5 text-sm font-bold text-white transition hover:bg-orange-700"
                >
                    ادامه و مشاهده سبد خرید

                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 18l-6-6 6-6"/>
                    </svg>
                </a>

            </div>

        @endif

    </aside>
</div>
