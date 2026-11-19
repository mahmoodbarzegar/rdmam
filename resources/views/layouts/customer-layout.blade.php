<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link rel="icon" href="{{ asset('assets/images/radman-logo.png') }}">
    <title>{{ $title ?? 'رادمان' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

    @stack('styles')
</head>
<body class="font-sans">

<main>{{ $slot }}</main>

<livewire:customer.cart-drawer />

@include('components.toast')

@livewireScripts
@stack('scripts')
</body>
</html>
