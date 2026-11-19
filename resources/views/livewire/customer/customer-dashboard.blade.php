
<div class="min-h-screen bg-slate-50 py-8" dir="rtl">

    @include('layouts.customer-header')


    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- عنوان صفحه --}}
        <div class="mb-7 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    محصولات
                </h1>

                <p class="mt-2 text-sm text-slate-500">
                    محصولات قابل سفارش را مشاهده و به سبد خرید اضافه کنید.
                </p>
            </div>

            <div class="flex items-center gap-2 text-sm text-slate-500">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-orange-50 text-orange-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M3 3h2l2.4 12.2a2 2 0 002 1.6h8.9a2 2 0 002-1.6L22 8H6"/>
                        <circle cx="10" cy="21" r="1"/>
                        <circle cx="18" cy="21" r="1"/>
                    </svg>
                </span>

                <span>{{ $products->total() }} محصول</span>
            </div>
        </div>

        {{-- پیام موفقیت --}}
        @if ($successMessage)
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 4000)"
                x-show="show"
                x-transition
                class="mb-5 flex items-center justify-between rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700"
            >
                <div class="flex items-center gap-2">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 13l4 4L19 7"/>
                    </svg>

                    {{ $successMessage }}
                </div>

                <button
                    type="button"
                    wire:click="$set('successMessage', null)"
                    class="text-green-700 hover:text-green-900"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif

        {{-- فیلترها --}}
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center">

            {{-- جستجو --}}
            <div class="relative min-w-0 flex-1">
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4">
                    <svg class="h-5 w-5 text-slate-400"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m21 21-4.5-4.5m2-5.5a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z"/>
                    </svg>
                </div>

                <input
                    type="search"
                    wire:model.live.debounce.400ms="search"
                    placeholder="جستجو بر اساس نام یا کد محصول..."
                    class="h-12 w-full rounded-xl border border-slate-200 bg-white pr-12 pl-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                >
            </div>

            {{-- مرتب‌سازی --}}
            <div class="w-full sm:w-52 sm:shrink-0">
                <select
                    wire:model.live="sort"
                    class="h-12 w-full rounded-xl border border-slate-200 bg-white px-4 text-sm text-slate-700 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100"
                >
                    <option value="newest">جدیدترین</option>
                    <option value="price_asc">ارزان‌ترین</option>
                    <option value="price_desc">گران‌ترین</option>
                    <option value="best_selling">پرفروش‌ترین</option>
                    <option value="name">نام محصول</option>
                    <option value="code">کد محصول</option>
                </select>
            </div>

            {{-- حذف فیلترها --}}
            @if ($search !== '' || $sort !== 'newest' )
                <button
                    type="button"
                    wire:click="resetFilters"
                    wire:loading.attr="disabled"
                    class="inline-flex h-12 shrink-0 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 text-sm font-medium text-slate-600 transition hover:border-red-200 hover:bg-red-50 hover:text-red-600 disabled:opacity-50"
                >
                    <svg class="h-4 w-4"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M6 18 18 6M6 6l12 12"/>
                    </svg>

                    حذف فیلترها
                </button>
            @endif

        </div>

        {{-- لیست محصولات --}}
        <div
            wire:loading.class="opacity-50"
            wire:target="search,sort,gotoPage,nextPage,previousPage"
            class="space-y-4 transition-opacity"
        >

            @forelse ($products as $product)

                @php
                    $isCarton = filter_var(
                        $cartonMode[$product->id] ?? false,
                        FILTER_VALIDATE_BOOLEAN
                    );

                    $canBuyByCarton =
                        $product->min_order_carton_qty !== null &&
                        $product->max_order_carton_qty !== null;

                    $minQty = $isCarton
                        ? (int) $product->min_order_carton_qty
                        : (int) $product->min_order_qty;

                    $maxQty = $isCarton
                        ? (int) $product->max_order_carton_qty
                        : (int) $product->max_order_qty;

                    $unitLabel = $isCarton ? 'کارتن' : 'عدد';

                    $isAvailable = true;//(int) $product->stock_quantity > 0;

                    $quantity = $quantities[$product->id] ?? $minQty;

                @endphp

                <div
                    wire:key="product-{{ $product->id }}"
                    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:border-slate-300 hover:shadow-md"
                >
                    <div class="p-4 sm:p-5">

                        <div class="flex flex-col gap-5 lg:flex-row lg:items-center">

                            {{-- اطلاعات محصول --}}
                            <div class="min-w-0 flex-1">

                                <div class="mb-3 flex flex-wrap items-center gap-2">

                                    <span class="rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                                        کد کالا: {{ $product->erp_code }}
                                    </span>

                       {{--             @if ($isAvailable)
                                        <span class="inline-flex items-center gap-1 rounded-lg bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                            موجود
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-lg bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600">
                                            <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                            ناموجود
                                        </span>
                                    @endif--}}

                                </div>

                                <h2 class="text-base font-bold leading-7 text-slate-800 sm:text-lg">
                                    {{ $product->name }}
                                </h2>

                                <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-3">

                                    <div class="rounded-xl bg-slate-50 p-3">
                                        <p class="text-xs text-slate-500">
                                            حداقل سفارش
                                        </p>

                                        <p class="mt-1 text-sm font-bold text-slate-700">
                                            {{ $minQty }}
                                            <span class="text-xs font-normal text-slate-500">
                                                {{ $unitLabel }}
                                            </span>
                                        </p>
                                    </div>

                                    <div class="rounded-xl bg-slate-50 p-3">
                                        <p class="text-xs text-slate-500">
                                            حداکثر سفارش
                                        </p>

                                        <p class="mt-1 text-sm font-bold text-slate-700">
                                            {{ $maxQty }}
                                            <span class="text-xs font-normal text-slate-500">
                                                {{ $unitLabel }}
                                            </span>
                                        </p>
                                    </div>

                                    <div class="col-span-2 rounded-xl bg-slate-50 p-3 sm:col-span-1">
                                        <p class="text-xs text-slate-500">
                                            آخرین مهلت تسویه
                                        </p>

                                        <p class="mt-1 text-sm font-bold text-slate-700">
                                            @if ($product->settlement_deadline_days)
                                                {{ $product->settlement_deadline_days }}روز
                                            @else
                                                <span class="font-normal text-slate-400">
                                                    تعیین نشده
                                                </span>
                                            @endif
                                        </p>
                                    </div>

                                </div>
                            </div>

                            {{-- قیمت و سفارش --}}
                            <div class="w-full border-t border-slate-100 pt-4 lg:w-72 lg:shrink-0 lg:border-r lg:border-t-0 lg:pr-5 lg:pt-0">

                                <div class="mb-4">
                                    <p class="text-xs text-slate-500">
                                        قیمت هر {{ $unitLabel }}
                                    </p>

                                    @if ($product->customerPrice)
                                        <div class="mt-1 flex items-baseline gap-1">
                                            <span class="text-xl font-extrabold text-slate-800">
                                                {{ number_format($product->customerPrice->price) }}
                                            </span>

                                            <span class="text-xs text-slate-500">
                                                تومان
                                            </span>
                                        </div>
                                    @else
                                        <p class="mt-1 text-sm font-semibold text-red-500">
                                            قیمت ثبت نشده است
                                        </p>
                                    @endif
                                </div>

                                {{-- انتخاب نوع خرید --}}
                                @if ($canBuyByCarton)
                                    <div class="mb-3">
                                        <label class="mb-2 block text-xs font-medium text-slate-500">
                                            نوع خرید
                                        </label>

                                        <div class="flex items-center gap-2">

                                            {{-- خرید عددی --}}
                                            <label class="flex cursor-pointer items-center gap-2 rounded-lg border px-3 py-2 text-sm transition"
                                                   :class="{}">
                                                <input
                                                    type="radio"
                                                    wire:model.live="cartonMode.{{ $product->id }}"
                                                    value="0"
                                                    class="h-4 w-4 border-slate-300 text-orange-600 accent-orange-600 focus:ring-orange-500"
                                                >
                                                <span class="text-slate-700">عددی</span>
                                            </label>

                                            {{-- خرید کارتنی --}}
                                            @if ($canBuyByCarton)
                                                <label class="flex cursor-pointer items-center gap-2 rounded-lg border px-3 py-2 text-sm transition">
                                                    <input
                                                        type="radio"
                                                        wire:model.live="cartonMode.{{ $product->id }}"
                                                        value="1"
                                                        class="h-4 w-4 border-slate-300 text-orange-600 accent-orange-600 focus:ring-orange-500"
                                                    >
                                                    <span class="text-slate-700">کارتنی</span>
                                                </label>
                                            @endif

                                        </div>
                                    </div>
                                @endif


                                {{-- تعداد و افزودن به سبد --}}
                                <div class="flex items-stretch gap-2">

                                    {{-- کنترل تعداد --}}
                                    <div class="flex min-w-0 flex-1 items-center overflow-hidden rounded-xl border border-slate-200 bg-slate-50">

                                        {{-- کاهش تعداد --}}
                                        <button
                                            type="button"
                                            wire:click="decreaseQuantity({{ $product->id }})"
                                            @disabled(! $isAvailable || (int) $quantity <= $minQty)
                                            class="flex h-11 w-10 shrink-0 items-center justify-center text-slate-600 transition hover:bg-slate-200 hover:text-orange-600 disabled:cursor-not-allowed disabled:opacity-30"
                                        >
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      stroke-width="2" d="M5 12h14"/>
                                            </svg>
                                        </button>

                                        {{-- تعداد --}}
                                        <input
                                            type="number"
                                            min="{{ $minQty }}"
                                            max="{{ $maxQty }}"
                                            wire:model.blur.number="quantities.{{ $product->id }}"
                                            @disabled(! $isAvailable || ! $product->customerPrice)
                                            class="w-full min-w-0 border-x border-slate-200 bg-transparent px-1 py-3 text-center text-sm font-bold text-slate-700 outline-none disabled:opacity-50"
                                        >

                                        {{-- افزایش تعداد --}}
                                        <button
                                            type="button"
                                            wire:click="increaseQuantity({{ $product->id }})"
                                            @disabled(! $isAvailable || (int) $quantity >= $maxQty)
                                            class="flex h-11 w-10 shrink-0 items-center justify-center text-slate-600 transition hover:bg-slate-200 hover:text-orange-600 disabled:cursor-not-allowed disabled:opacity-30"
                                        >
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      stroke-width="2" d="M12 5v14m-7-7h14"/>
                                            </svg>
                                        </button>

                                    </div>

                                    {{-- افزودن به سبد --}}
                                    <button
                                        type="button"
                                        wire:click="addToCart({{ $product->id }})"
                                        wire:loading.attr="disabled"
                                        wire:target="addToCart({{ $product->id }})"
                                        @disabled(! $isAvailable || ! $product->customerPrice)
                                        class="flex shrink-0 items-center justify-center gap-2 rounded-xl bg-orange-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-orange-700 disabled:cursor-not-allowed disabled:bg-slate-300"
                                    >
        <span wire:loading.remove wire:target="addToCart({{ $product->id }})">
            افزودن
        </span>

                                        <span wire:loading wire:target="addToCart({{ $product->id }})">
            ...
        </span>

                                        <svg wire:loading.remove
                                             wire:target="addToCart({{ $product->id }})"
                                             class="h-4 w-4"
                                             fill="none"
                                             stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2" d="M12 5v14m-7-7h14"/>
                                        </svg>

                                        <svg wire:loading
                                             wire:target="addToCart({{ $product->id }})"
                                             class="h-4 w-4 animate-spin"
                                             fill="none"
                                             viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"/>
                                            <path class="opacity-75" fill="currentColor"
                                                  d="M4 12a8 8 0 018-8V0C5.37 0 0 5.37 0 12h4z"/>
                                        </svg>
                                    </button>

                                </div>

                                {{-- خطای تعداد --}}
                                @error("quantities.{$product->id}")
                                <p class="mt-2 text-xs leading-5 text-red-600">
                                    {{ $message }}
                                </p>
                                @enderror

                                <p class="mt-2 text-xs text-slate-400">
                                    حداقل {{ $minQty }} و حداکثر {{ $maxQty }} {{ $unitLabel }}
                                </p>


                                {{-- خطای تعداد --}}
                                @error("quantities.{$product->id}")
                                <p class="mt-2 text-xs leading-5 text-red-600">
                                    {{ $message }}
                                </p>
                                @enderror

                                <p class="mt-2 text-xs text-slate-400">
                                    مجاز به سفارش بین {{ $minQty }} تا {{ $maxQty }} {{ $unitLabel }} هستید.
                                </p>

                            </div>

                        </div>
                    </div>
                </div>

            @empty

                <div class="rounded-2xl border border-slate-200 bg-white px-4 py-16 text-center">

                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="7" stroke-width="1.5"/>
                            <path stroke-linecap="round" stroke-width="1.5" d="m16 16 4 4M8 11h6"/>
                        </svg>
                    </div>

                    <h3 class="mt-4 text-base font-bold text-slate-700">
                        محصولی پیدا نشد
                    </h3>

                    <p class="mt-2 text-sm text-slate-500">
                        محصولی با مشخصات انتخاب‌شده وجود ندارد.
                    </p>

                    <button
                        type="button"
                        wire:click="resetFilters"
                        class="mt-5 rounded-xl bg-orange-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-700"
                    >
                        حذف فیلترها
                    </button>

                </div>

            @endforelse

        </div>

        {{-- صفحه‌بندی --}}
        @if ($products->hasPages())
            <div class="mt-6 rounded-2xl border border-slate-200 bg-white px-4 py-4">
                {{ $products->links() }}
            </div>
        @endif

    </div>
</div>
