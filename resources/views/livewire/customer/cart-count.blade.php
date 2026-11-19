<button
    type="button"
    wire:click="$dispatch('open-cart-drawer')"
    class="relative flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-600 transition hover:border-orange-200 hover:bg-orange-50 hover:text-orange-600"
    title="سبد خرید"
>
    {{-- آیکون سبد خرید فعلی --}}
    <svg xmlns="http://www.w3.org/2000/svg"
         class="h-5 w-5"
         fill="none"
         viewBox="0 0 24 24"
         stroke="currentColor"
         stroke-width="1.8">
        <path stroke-linecap="round"
              stroke-linejoin="round"
              d="M3 3h2l2.4 12.2a2 2 0 002 1.6h8.8a2 2 0 002-1.6L22 8H6"/>
        <circle cx="10" cy="20" r="1"/>
        <circle cx="18" cy="20" r="1"/>
    </svg>


@if ($count > 0)
        <span class="absolute -right-1.5 -top-1.5 flex h-5 min-w-5 items-center justify-center rounded-full bg-orange-600 px-1 text-[10px] font-bold text-white">
            {{ $count }}
        </span>
    @endif
</button>
