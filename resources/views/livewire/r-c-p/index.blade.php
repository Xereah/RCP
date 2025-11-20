<div class="min-h-screen bg-slate-950 text-white py-12">
    <div class="mx-auto max-w-5xl px-6 py-16">
        <div class="rounded-[32px] border border-white/10 bg-white/5 p-10 text-center shadow-2xl shadow-indigo-900/30 backdrop-blur-md md:text-left">
            <div class="flex flex-col gap-8 md:flex-row md:items-center">
                <div class="flex-1 space-y-4">
                    <p class="text-xs uppercase tracking-[0.4em] text-indigo-200/80">Panel rejestracji</p>
                    <h1 class="text-4xl font-semibold text-white md:text-5xl">Rejestracja czasu pracy</h1>
                    <p class="text-base text-slate-300">Wybierz akcję i wpisz numer na wirtualnej klawiaturze, aby system zapisał wejście lub wyjście Twojej zmiany.</p>
                </div>
                <div class="flex justify-center md:justify-end">
                    <div class="rounded-3xl border border-white/10 bg-gradient-to-br from-indigo-500/20 via-fuchsia-500/10 to-transparent p-6 shadow-xl shadow-indigo-900/50">
                        <img src="{{ asset('images/Logo_WBG.jpg') }}" alt="Logo WBG" class="h-24 w-auto drop-shadow-md" />
                    </div>
                </div>
            </div>

            <div class="mt-10 flex flex-col items-center gap-3 md:flex-row md:justify-between">
                <p class="text-sm text-slate-300"><img src="{{ asset('images/stopka_WBG.jpg') }}" alt="Logo WBG" class="h-24 w-auto drop-shadow-md" /></p>
                <div class="inline-flex w-full items-center justify-center gap-4 rounded-2xl bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 px-10 py-6 text-4xl font-bold text-white shadow-[0_10px_25px_rgba(99,102,241,0.4)] md:w-auto"
                    x-data="{ time: new Date().toLocaleTimeString('pl-PL', { hour12: false }) }"
                    x-init="setInterval(() => time = new Date().toLocaleTimeString('pl-PL', { hour12: false }), 1000)"
                    x-text="time"></div>
            </div>
        </div>

        @if($alertMessage)
        <div
            class="mt-10 rounded-2xl border px-6 py-4 text-base font-medium
                {{ $alertVariant === 'success' ? 'border-emerald-500/40 bg-emerald-500/10 text-emerald-200' : 'border-rose-500/40 bg-rose-500/10 text-rose-200' }}">
            {{ $alertMessage }}
        </div>
        @endif

        <div class="mt-12 grid gap-8 md:grid-cols-2">
            <button wire:click="openModal('entry')" wire:loading.attr="disabled" wire:target="openModal"
                class="group relative overflow-hidden rounded-3xl border border-emerald-500/30 bg-gradient-to-br from-emerald-500/20 via-emerald-400/10 to-transparent px-8 py-10 text-left transition hover:scale-[1.01] hover:border-emerald-400/60 focus:outline-none focus:ring-2 focus:ring-emerald-400/60">
                <div class="absolute inset-px rounded-[22px] border border-white/10"></div>
                <div class="relative flex items-center justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.2em] text-emerald-200/80">Wejście</p>
                        <p class="mt-2 text-3xl font-semibold text-white">Zarejestruj start</p>
                        <p class="mt-3 text-sm text-white/70">Numer wpiszesz na wirtualnej klawiaturze.</p>
                    </div>
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-500/20 text-white">
                        <svg class="h-9 w-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                </div>
            </button>

            <button wire:click="openModal('exit')" wire:loading.attr="disabled" wire:target="openModal"
                class="group relative overflow-hidden rounded-3xl border border-rose-500/30 bg-gradient-to-br from-rose-500/20 via-rose-400/10 to-transparent px-8 py-10 text-left transition hover:scale-[1.01] hover:border-rose-400/60 focus:outline-none focus:ring-2 focus:ring-rose-400/60">
                <div class="absolute inset-px rounded-[22px] border border-white/10"></div>
                <div class="relative flex items-center justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.2em] text-rose-200/80">Wyjście</p>
                        <p class="mt-2 text-3xl font-semibold text-white">Zakończ zmianę</p>
                        <p class="mt-3 text-sm text-white/70">System automatycznie policzy przepracowany czas.</p>
                    </div>
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-rose-500/20 text-white">
                        <svg class="h-9 w-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 12H4" />
                        </svg>
                    </div>
                </div>
            </button>
        </div>
    </div>

    @if($showModal)
    <div x-data x-on:keydown.escape.window="$wire.closeModal()"
        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur">
        <div class="relative w-full max-w-xl rounded-3xl border border-white/10 bg-slate-900/95 p-8 shadow-2xl">
            <button wire:click="closeModal"
                class="absolute right-4 top-4 rounded-full p-2 text-white/70 transition hover:bg-white/10 hover:text-white"
                aria-label="Zamknij modal">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 6l12 12M6 18L18 6" />
                </svg>
            </button>

            <div class="text-center">
                <p class="text-sm uppercase tracking-[0.3em] text-white/60">
                    {{ $mode === 'entry' ? 'Rejestracja wejścia' : 'Rejestracja wyjścia' }}
                </p>
                <h2 class="mt-2 text-3xl font-semibold text-white">
                    Podaj numer pracownika
                </h2>
                <div
                    class="mt-6 rounded-2xl border border-white/10 bg-black/30 px-6 py-4 text-4xl font-mono tracking-widest text-white">
                    {{ $employeeNumber ?: '____' }}
                </div>
                @error('employeeNumber')
                <p class="mt-3 text-sm text-rose-300">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-8 grid grid-cols-3 gap-4 text-2xl font-semibold text-white">
                @foreach(range(1, 9) as $digit)
                <button wire:click="appendDigit('{{ $digit }}')"
                    class="rounded-2xl border border-white/10 bg-white/5 py-4 transition hover:bg-white/20">
                    {{ $digit }}
                </button>
                @endforeach

                <button wire:click="clear"
                    class="rounded-2xl border border-amber-400/40 bg-amber-500/10 py-4 text-base uppercase tracking-[0.2em] text-amber-100 transition hover:bg-amber-500/20">
                    Reset
                </button>
                <button wire:click="appendDigit('0')"
                    class="rounded-2xl border border-white/10 bg-white/5 py-4 transition hover:bg-white/20">
                    0
                </button>
                <button wire:click="erase"
                    class="rounded-2xl border border-white/10 bg-white/5 py-4 transition hover:bg-white/20">
                    ←
                </button>
            </div>

            <button wire:click="submit" wire:loading.attr="disabled" wire:target="submit"
                class="mt-8 w-full rounded-2xl bg-gradient-to-r {{ $mode === 'entry' ? 'from-emerald-400 to-teal-500' : 'from-rose-400 to-pink-500' }} px-6 py-4 text-lg font-semibold text-white shadow-lg shadow-black/40 transition hover:brightness-110 focus:outline-none focus:ring-2 focus:ring-white/40">
                Potwierdź {{ $mode === 'entry' ? 'wejście' : 'wyjście' }}
            </button>
        </div>
    </div>
    @endif
</div>