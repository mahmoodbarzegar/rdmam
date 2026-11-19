<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{--    @php($siteFavicon = \App\Models\Setting::get('site_favicon'))--}}
    {{--    @if($siteFavicon)--}}
    {{--        <link rel="icon" href="{{ \Storage::url($siteFavicon) }}">--}}
    {{--    @endif--}}

    <link rel="icon" href="{{ asset('assets/images/radman-logo.png') }}">
    <title>{{ $title ?? 'مدیریت شعب رادمان' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

    @stack('styles')
</head>
<body class="min-h-screen bg-gray-50 font-sans antialiased">

{{-- Sidebar / Header --}}
<header class="border-b border-gray-200 bg-white">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4">
        <h1 class="font-bold text-gray-800">
            پنل مدیریت
        </h1>

        <span class="text-sm text-gray-500">
                مدیریت مشتریان
            </span>
    </div>
</header>
{{-- هدر اصلی سایت (مشترک با لایوت پیش‌فرض Livewire، برای جلوگیری از تکرار کد) --}}
{{--@include('partials.site-header')--}}

<main class="mx-auto w-full max-w-[1600px] px-4 py-8 sm:px-6 lg:px-10 xl:px-12">
    {{ $slot }}</main>

{{--<livewire:shop.site-footer />--}}

{{-- سیستم Toast سبک برای پیام‌های لحظه‌ای (مثلا افزودن به مقایسه) --}}
<div x-data="{ show: false, message: '' }"
     x-on:toast.window="message = $event.detail.message; show = true; setTimeout(() => show = false, 3000)"
     x-show="show" x-transition
     class="fixed bottom-4 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-sm px-4 py-2 rounded-lg shadow-lg z-50"
     style="display: none;">
    <span x-text="message"></span>
</div>

@livewireScripts
@stack('scripts')
</body>
</html>
