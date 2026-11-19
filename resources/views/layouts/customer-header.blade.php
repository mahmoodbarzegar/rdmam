{{-- Header --}}
<header class="sticky top-0 z-50 border-b border-slate-200 bg-white">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">

        {{-- لوگو --}}
        <a href="#"
           class="flex items-center font-semibold bg-blend-color">
            <img
                src="{{ asset('assets/images/radman-logo.png') }}"
                alt="رادمان"
                class="h-9 w-auto"
            >
            شرکت پخش رادمان
        </a>

        <div class="flex items-center gap-3">

            <livewire:customer.cart-count />
            {{-- منوی کاربر --}}
            <div
                x-data="{ open: false }"
                @click.outside="open = false"
                @keydown.escape.window="open = false"
                class="relative"
            >
                <button
                    type="button"
                    @click="open = !open"
                    class="flex h-10 items-center gap-2 rounded-xl border border-slate-200 px-3 text-sm font-medium text-slate-700 transition hover:border-orange-200 hover:bg-orange-50 hover:text-orange-600"
                >
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.1a7.5 7.5 0 0115 0"/>
                    </svg>

                    <span class="max-w-32 truncate">
                        {{ auth()->user()->name }}
                    </span>

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-4 w-4 transition-transform"
                         :class="{ 'rotate-180': open }"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m6 9 6 6 6-6"/>
                    </svg>
                </button>

                {{-- Dropdown --}}
                <div
                    x-cloak
                    x-show="open"
                    x-transition.origin.top.right
                    class="absolute left-0 mt-2 w-52 overflow-hidden rounded-xl border border-slate-200 bg-white py-2 shadow-lg"
                >
                    <div class="border-b border-slate-100 px-4 py-3">
                        <p class="truncate text-sm font-semibold text-slate-800">
                            {{ auth()->user()->name }}
                        </p>

                        <p class="mt-1 truncate text-xs text-slate-400">
                            {{ auth()->user()->email }}
                        </p>
                    </div>

                    {{-- پروفایل --}}
                    <a href="#"
                       class="flex items-center gap-3 px-4 py-3 text-sm text-slate-600 transition hover:bg-orange-50 hover:text-orange-600">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.1a7.5 7.5 0 0115 0"/>
                        </svg>

                        پروفایل
                    </a>

                    <div class="my-1 border-t border-slate-100"></div>

                    {{-- خروج --}}
                    <form method="POST" action="{{ route('customer.logout') }}">
                        @csrf

                        <button
                            type="submit"
                            class="flex w-full items-center gap-3 px-4 py-3 text-sm text-red-600 transition hover:bg-red-50"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M18 15l3-3m0 0l-3-3m3 3H9"/>
                            </svg>

                            خروج از حساب
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>
