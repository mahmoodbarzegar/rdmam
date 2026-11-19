<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>انتخاب نوع ورود</title>
    <link rel="icon" href="{{ asset('assets/images/radman-logo.png') }}">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="min-h-screen bg-slate-100">

<main class="flex min-h-screen items-center justify-center px-4 py-10">
    <div class="w-full max-w-3xl">

        <!-- Header -->
        <div class="mb-10 text-center">
            <h1 class="text-3xl font-extrabold text-slate-800">
                خوش آمدید
            </h1>

            <p class="mt-3 text-slate-500">
                برای ادامه، نوع ورود خود را انتخاب کنید.
            </p>
        </div>

        <!-- Login Cards -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

            <!-- Customer -->
            <a href="{{ route('customer.login') }}"
               class="group rounded-2xl border border-slate-200
                          bg-white p-8 text-center shadow-sm
                          transition duration-300
                          hover:-translate-y-1 hover:border-blue-400
                          hover:shadow-xl">

                <div class="mx-auto flex h-20 w-20 items-center
                                justify-center rounded-2xl bg-blue-100
                                text-4xl transition group-hover:bg-blue-600">
                    <span>👤</span>
                </div>

                <h2 class="mt-6 text-xl font-bold text-slate-800">
                    ورود مشتری
                </h2>

                <p class="mt-3 text-sm leading-7 text-slate-500">
                    برای ورود به حساب کاربری و استفاده از خدمات،
                    روی دکمه زیر کلیک کنید.
                </p>

                <span class="mt-6 inline-flex w-full items-center
                                 justify-center rounded-xl bg-blue-600
                                 px-5 py-3 font-semibold text-white
                                 transition group-hover:bg-blue-700">
                        ورود به حساب مشتری
                    </span>
            </a>

            <!-- Admin -->
            <a href="{{ route('branchAdmin.login') }}"
               class="group rounded-2xl border border-slate-200
                          bg-white p-8 text-center shadow-sm
                          transition duration-300
                          hover:-translate-y-1 hover:border-purple-400
                          hover:shadow-xl">

                <div class="mx-auto flex h-20 w-20 items-center
                                justify-center rounded-2xl bg-purple-100
                                text-4xl transition group-hover:bg-purple-600">
                    <span>🛡️</span>
                </div>

                <h2 class="mt-6 text-xl font-bold text-slate-800">
                    ورود مدیر شعبه
                </h2>

                <p class="mt-3 text-sm leading-7 text-slate-500">
                    برای ورود به پنل مدیریت و مدیریت سیستم،
                    روی دکمه زیر کلیک کنید.
                </p>

                <span class="mt-6 inline-flex w-full items-center
                                 justify-center rounded-xl bg-purple-600
                                 px-5 py-3 font-semibold text-white
                                 transition group-hover:bg-purple-700">
                        ورود به پنل مدیریت
                    </span>
            </a>

        </div>

        <p class="mt-8 text-center text-xs text-slate-400">
            تمامی حقوق محفوظ است.
        </p>

    </div>
</main>

</body>
</html>
