<div
    x-data="{
        toasts: [],
        nextId: 1,

        addToast(detail) {
            const id = this.nextId++;
            const duration = Number(detail.duration) || 4000;

            this.toasts.push({
                id,
                type: detail.type || 'success',
                message: detail.message || 'عملیات با موفقیت انجام شد.',
                duration,
                remaining: duration,
                progress: 100,
                startedAt: null,
                frame: null,
                paused: false
            });

            this.startTimer(id);
        },

        findToast(id) {
            return this.toasts.find(toast => toast.id === id);
        },

        startTimer(id) {
            const toast = this.findToast(id);

            if (!toast || toast.remaining <= 0) return;

            toast.startedAt = performance.now();

            const tick = () => {
                const current = this.findToast(id);

                if (!current || current.paused) return;

                const left = current.remaining - (performance.now() - current.startedAt);

                if (left <= 0) {
                    this.removeToast(id);
                    return;
                }

                current.progress = (left / current.duration) * 100;
                current.frame = requestAnimationFrame(tick);
            };

            toast.frame = requestAnimationFrame(tick);
        },

        pauseTimer(id) {
            const toast = this.findToast(id);

            if (!toast || toast.paused) return;

            cancelAnimationFrame(toast.frame);

            const elapsed = performance.now() - toast.startedAt;

            toast.remaining = Math.max(0, toast.remaining - elapsed);
            toast.progress = (toast.remaining / toast.duration) * 100;
            toast.paused = true;
        },

        resumeTimer(id) {
            const toast = this.findToast(id);

            if (!toast || !toast.paused) return;

            toast.paused = false;
            this.startTimer(id);
        },

        removeToast(id) {
            const toast = this.findToast(id);

            if (toast?.frame) {
                cancelAnimationFrame(toast.frame);
            }

            this.toasts = this.toasts.filter(t => t.id !== id);
        },

        typeClasses(type) {
            return {
                success: 'bg-green-50 text-green-600',
                error: 'bg-red-50 text-red-600',
                info: 'bg-blue-50 text-blue-600',
                warning: 'bg-amber-50 text-amber-600'
            }[type] || 'bg-slate-50 text-slate-600';
        },

        progressClasses(type) {
            return {
                success: 'bg-green-500',
                error: 'bg-red-500',
                info: 'bg-blue-500',
                warning: 'bg-amber-500'
            }[type] || 'bg-slate-500';
        },

        title(type) {
            return {
                success: 'عملیات موفق',
                error: 'خطا',
                info: 'اطلاع‌رسانی',
                warning: 'هشدار'
            }[type] || 'پیام';
        }
    }"
    @notify.window="addToast($event.detail)"
    class="fixed right-4 top-20 z-[100] flex w-[calc(100%-2rem)] max-w-sm flex-col gap-3"
    dir="rtl"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            @mouseenter="pauseTimer(toast.id)"
            @mouseleave="resumeTimer(toast.id)"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-5"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0 translate-x-5"
            class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg"
        >

            {{-- محتوا --}}
            <div class="flex items-center gap-3 p-4">

                {{-- آیکون --}}
                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl"
                    :class="typeClasses(toast.type)"
                >

                    {{-- Success --}}
                    <template x-if="toast.type === 'success'">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6"/>
                        </svg>
                    </template>

                    {{-- Error --}}
                    <template x-if="toast.type === 'error'">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                        </svg>
                    </template>

                    {{-- Info --}}
                    <template x-if="toast.type === 'info'">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="9"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 11v5m0-8h.01"/>
                        </svg>
                    </template>

                    {{-- Warning --}}
                    <template x-if="toast.type === 'warning'">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 9v4m0 4h.01M10.3 3.9 2.5 17.4A2 2 0 004.2 20h15.6a2 2 0 001.7-2.6L13.7 3.9a2 2 0 00-3.4 0z"/>
                        </svg>
                    </template>

                </div>

                {{-- متن --}}
                <div class="min-w-0 flex-1">

                    <p
                        class="text-sm font-semibold"
                        :class="{
                            'text-green-700': toast.type === 'success',
                            'text-red-700': toast.type === 'error',
                            'text-blue-700': toast.type === 'info',
                            'text-amber-700': toast.type === 'warning'
                        }"
                        x-text="title(toast.type)"
                    ></p>

                    <p
                        class="mt-1 break-words text-sm leading-6 text-slate-600"
                        x-text="toast.message"
                    ></p>

                </div>

                {{-- دکمه بستن --}}
                <button
                    type="button"
                    @click="removeToast(toast.id)"
                    class="shrink-0 rounded-lg p-1 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                >
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>

            </div>

            {{-- Progress Bar --}}
            <div class="h-1 w-full overflow-hidden bg-slate-100">
                <div
                    class="h-full"
                    :class="progressClasses(toast.type)"
                    :style="{ width: toast.progress + '%' }"
                ></div>
            </div>

        </div>
    </template>
</div>
