<div class="min-h-screen bg-gradient-to-br from-gray-50 to-slate-100"
    x-data="{ showTooltip: null, exportDrawer: false }" x-cloak>
    <div class="mx-auto">
        <!-- Professional Header Card -->
        <div
            class="bg-white rounded-2xl shadow-lg border border-gray-200/50 p-8 hover:shadow-xl transition-shadow duration-300">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div class="flex items-center space-x-5">
                    <div class="relative">
                        <!-- Professional icon container -->
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-indigo-600 to-indigo-800 rounded-xl flex items-center justify-center shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <!-- Professional badge -->
                        <div
                            class="absolute -top-1 -right-1 w-6 h-6 bg-emerald-500 rounded-full flex items-center justify-center">
                            <span class="text-xs font-semibold text-white">{{ count($workSessions) }}</span>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-1">
                            Panel obecności
                        </h1>
                        <p class="text-lg text-gray-600">Zarządzaj obecnościami pracowników</p>
                    </div>
                </div>

                <!-- CTA Button -->
                <div class="flex-shrink-0">
                    <a href="{{ route('work-sessions.create') }}" wire:navigate
                        class="inline-flex items-center px-6 py-3 bg-indigo-800 hover:bg-indigo-900 text-white font-semibold rounded-xl shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Dodaj obecność
                    </a>
                </div>
            </div>
        </div>

        @include('components.toasts')

        <!-- Filters -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200/50 p-6 mt-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Filtry</h2>
                    <p class="text-sm text-gray-500">Doprecyzuj listę obecności według kryteriów</p>
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" @click="exportDrawer = true"
                        class="inline-flex items-center px-5 py-3 bg-indigo-700 text-white font-semibold rounded-xl shadow hover:bg-indigo-800 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-6h6v6m2 4H7a2 2 0 01-2-2V7a2 2 0 012-2h5l2 2h5a2 2 0 012 2v10a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Eksportuj do pliku
                    </button>

                    <button type="button" wire:click="resetFilters"
                        class="inline-flex items-center px-5 py-3 text-sm font-semibold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition">
                        Wyczyść filtry
                    </button>
                </div>

            </div>
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Szukaj pracownika</label>
                    <input type="text" wire:model.live.debounce.500ms="search" placeholder="Imię, nazwisko lub numer"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Status</label>
                    <select wire:model.live="statusId"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Wszystkie statusy</option>
                        @foreach ($statuses as $status)
                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Data od</label>
                    <input type="date" wire:model.live="dateFrom"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Data do</label>
                    <input type="date" wire:model.live="dateTo"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
        </div>      

        <!-- Main Content Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200/50 overflow-hidden mt-6">

            <!-- Professional Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <!-- Table Header -->
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th
                                class="px-6 py-4 text-center text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                Lp.</th>
                            <th
                                class="px-6 py-4 text-center text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                Numer personalny</th>
                            <th
                                class="px-6 py-4 text-center text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                Imię i nazwisko</th>
                            <th
                                class="px-6 py-4 text-center text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                Stanowisko</th>
                            <th
                                class="px-6 py-4 text-center text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                Data</th>
                            <th
                                class="px-6 py-4 text-center text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                Godzina wejścia</th>
                            <th
                                class="px-6 py-4 text-center text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                Godzina wyjścia</th>
                            <th
                                class="px-6 py-4 text-center text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                Zaliczony czas pracy</th>
                            <th
                                class="px-6 py-4 text-center text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-6 py-4 text-center text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                Informacje</th>
                            <th
                                class="px-6 py-4 text-center text-xs font-semibold text-gray-900 uppercase tracking-wider">
                            </th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($workSessions as $key => $workSession)
                        <tr class="hover:bg-gray-50 transition-colors duration-150" wire:key="{{ $workSession->id }}">
                            <!-- Row Number -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <span class="text-sm font-semibold text-gray-700">
                                            {{ ($workSessions->currentPage() - 1) * $workSessions->perPage() + $loop->iteration }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <!-- User Name -->
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center">
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ $workSession->personel->personal_number ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <!-- Last Name -->
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center">
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ $workSession->personel->last_name ?? '-' }}
                                            {{ $workSession->personel->first_name ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <!-- First Name -->
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center">
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ $workSession->personel->position->name ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <!-- Position -->
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center">
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">
                                        {{ $workSession->work_date ? \Carbon\Carbon::parse($workSession->work_date)->format('d.m.Y') : '-' }}

                                        </div>
                                    </div>
                                </div>
                            </td>
                            <!-- Work Date -->
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center">
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ $workSession->start_time ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <!-- Start Time -->
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center">
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ $workSession->end_time ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <!-- End Time -->
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center">
                                    <div>
                                        <span @class([
                                            'text-sm font-semibold px-3 py-1 rounded-lg inline-flex justify-center',
                                            'bg-emerald-50 text-emerald-700' => $workSession->has_overtime,
                                            'text-gray-900' => ! $workSession->has_overtime,
                                        ])>
                                            {{ $workSession->duration_human ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <!-- Status -->
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center">
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ $workSession->display_status }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <!-- Notes -->
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center">
                                    <div>
                                        <div @class([
                                            'text-sm font-semibold',
                                            'text-amber-600' => $workSession->incomplete_shift_warning,
                                            'text-gray-900' => ! $workSession->incomplete_shift_warning,
                                        ])>
                                            {{ $workSession->incomplete_shift_warning ?? ($workSession->notes ?? '-') }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <!-- Actions -->
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('work-sessions.edit', $workSession->id) }}" wire:navigate
                                        class="inline-flex items-center justify-center p-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                        title="Edytuj obecność">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                            </path>
                                        </svg>
                                    </a>
                                    <button
                                        @click="confirmAction('delete', {{ $workSession->id }}, 'Na pewno chcesz usunąć tę obecność?', 'Tak, usuń!', 'warning')"
                                        class="inline-flex items-center justify-center p-2 text-white bg-red-500 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                                        title="Usuń obecność">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($workSessions->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Pokazano <span class="font-semibold">{{ $workSessions->firstItem() }}</span> -
                        <span class="font-semibold">{{ $workSessions->lastItem() }}</span> z
                        <span class="font-semibold">{{ $workSessions->total() }}</span> wyników
                    </div>
                    <div class="flex space-x-1">
                        {!! $workSessions->withQueryString()->links() !!}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Export Drawer -->
    <div class="fixed inset-0 z-50" x-show="exportDrawer" x-transition.opacity>
        <div class="absolute inset-0 bg-gray-900/40" @click="exportDrawer = false"></div>
        <div class="absolute inset-y-0 right-0 w-full max-w-md bg-white shadow-2xl flex flex-col" x-show="exportDrawer"
            x-transition:enter="transform transition ease-in-out duration-300"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-300" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <div>
                    <p class="text-sm uppercase tracking-wide text-indigo-600 font-semibold">Eksport</p>
                    <h3 class="text-2xl font-bold text-gray-900">Zapisz obecności</h3>
                </div>
                <button type="button" class="p-2 rounded-full hover:bg-gray-100 transition"
                    @click="exportDrawer = false">
                    <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="p-6 space-y-6 flex-1 overflow-y-auto">
                <div>
                    <h4 class="text-base font-semibold text-gray-900">Zakres dat</h4>
                    <p class="text-sm text-gray-500">Eksport uwzględnia bieżące filtry listy.</p>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Eksport od</label>
                        <input type="date" wire:model="exportFrom"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('exportFrom')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Eksport do</label>
                        <input type="date" wire:model="exportTo"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('exportTo')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="bg-gray-50 border border-dashed border-gray-200 rounded-2xl p-4">
                    <p class="text-sm text-gray-600">
                        Eksport zawiera dane po zastosowaniu wszystkich filtrów (pracownik, status, zakres dat). Wybierz
                        format pliku i rozpocznij pobieranie.
                    </p>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 space-y-3">
                <button type="button" wire:click="export('csv')" wire:loading.attr="disabled" wire:target="export"
                    class="w-full inline-flex items-center justify-center px-4 py-3 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 transition disabled:opacity-60">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-6h6v6m2 4H7a2 2 0 01-2-2V7a2 2 0 012-2h5l2 2h5a2 2 0 012 2v10a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Pobierz CSV
                </button>
                <button type="button" wire:click="export('xlsx')" wire:loading.attr="disabled" wire:target="export"
                    class="w-full inline-flex items-center justify-center px-4 py-3 bg-indigo-700 text-white font-semibold rounded-xl hover:bg-indigo-800 transition disabled:opacity-60">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-6h6v6m2 4H7a2 2 0 01-2-2V7a2 2 0 012-2h5l2 2h5a2 2 0 012 2v10a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Pobierz XLSX
                </button>
            </div>
        </div>
    </div>
</div>