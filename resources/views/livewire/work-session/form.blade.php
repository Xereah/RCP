<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Numer personalny -->
        <div wire:click.away="hidePersonelDropdown">
            <label for="personel_search" class="block text-sm font-semibold text-gray-900 mb-3">
                <div class="flex items-center gap-2">
                    <div class="w-5 h-5 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    Pracownik
                </div>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <input
                    wire:model.live.debounce.300ms="personelSearch"
                    wire:focus="showPersonelDropdown"
                    wire:keydown.escape="hidePersonelDropdown"
                    id="personel_search"
                    name="personel_search"
                    type="text"
                    class="block w-full pl-12 pr-12 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 placeholder-gray-500 transition-colors duration-200"
                    placeholder="Wpisz nazwisko, imię lub numer"
                    autocomplete="off">
                <input type="hidden" wire:model="form.personel_id">
                @if($form->personel_id)
                    <span class="absolute inset-y-0 right-3 flex items-center text-indigo-600 text-xs font-semibold">
                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Wybrano
                    </span>
                @endif
            </div>
            @if($this->selectedPersonelLabel)
                <p class="mt-2 text-sm text-gray-600">
                    Aktualny wybór: {{ $this->selectedPersonelLabel }}
                </p>
            @endif
            <div
                class="relative"
                wire:loading.class="opacity-70"
                wire:target="personelSearch">
                @if($personelDropdownVisible)
                    <div class="absolute z-20 mt-2 w-full bg-white border border-gray-200 rounded-xl shadow-xl overflow-hidden">
                        <div class="max-h-64 overflow-y-auto divide-y divide-gray-100">
                            @forelse ($this->personelResults as $personel)
                                <button
                                    type="button"
                                    wire:key="personel-option-{{ $personel->id }}"
                                    wire:click="selectPersonel({{ $personel->id }})"
                                    class="w-full text-left px-4 py-3 hover:bg-indigo-50 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <span class="font-semibold text-gray-900">
                                            {{ $personel->last_name }} {{ $personel->first_name }}
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            nr {{ $personel->personal_number }}
                                        </span>
                                    </div>
                                    @if($personel->position)
                                        <p class="text-xs text-gray-500">
                                            {{ $personel->position->name }}
                                        </p>
                                    @endif
                                </button>
                            @empty
                                <div class="px-4 py-3 text-sm text-gray-500">
                                    Brak wyników — doprecyzuj wyszukiwanie.
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endif
            </div>
            @error('form.personel_id')
                <div class="mt-2 flex items-center space-x-2">
                    <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm text-red-600">{{ $message }}</span>
                </div>
            @enderror
        </div>

        <!-- Data -->
        <div>
            <label for="work_date" class="block text-sm font-semibold text-gray-900 mb-3">
                <div class="flex items-center gap-2">
                    <div class="w-5 h-5 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    Data
                </div>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <input wire:model="form.work_date"
                       id="work_date"
                       name="work_date"
                       type="date"
                       class="block w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 placeholder-gray-500 transition-colors duration-200"
                       placeholder="Podaj datę"
                       autocomplete="work_date">
            </div>
            @error('form.work_date')
                <div class="mt-2 flex items-center space-x-2">
                    <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm text-red-600">{{ $message }}</span>
                </div>
            @enderror
        </div>

        <!-- Godzina rozpoczęcia -->
        <div>
            <label for="start_time" class="block text-sm font-semibold text-gray-900 mb-3">
                <div class="flex items-center gap-2">
                    <div class="w-5 h-5 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    Godzina rozpoczęcia
                </div>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <input wire:model="form.start_time"
                       id="start_time"
                       name="start_time"
                       type="time"
                       class="block w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 placeholder-gray-500 transition-colors duration-200"
                       placeholder="Podaj godzinę rozpoczęcia"
                       autocomplete="start_time">
            </div>
            @error('form.start_time')
                <div class="mt-2 flex items-center space-x-2">
                    <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm text-red-600">{{ $message }}</span>
                </div>
            @enderror
        </div>

        <!-- Godzina zakończenia -->
        <div>
            <label for="end_time" class="block text-sm font-semibold text-gray-900 mb-3">
                <div class="flex items-center gap-2">
                    <div class="w-5 h-5 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    Godzina zakończenia
                </div>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <input wire:model="form.end_time"
                       id="end_time"
                       name="end_time"
                       type="time"
                       class="block w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 placeholder-gray-500 transition-colors duration-200"
                       placeholder="Podaj godzinę zakończenia"
                       autocomplete="end_time">
            </div>
            @error('form.end_time')
                <div class="mt-2 flex items-center space-x-2">
                    <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm text-red-600">{{ $message }}</span>
                </div>
            @enderror
        </div>

        <!-- Status -->
        <div>
            <label for="status_id" class="block text-sm font-semibold text-gray-900 mb-3">
                <div class="flex items-center gap-2">
                    <div class="w-5 h-5 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    Status
                </div>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <select wire:model="form.status_id"
                        id="status_id"
                        name="status_id"
                        class="block w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 placeholder-gray-500 transition-colors duration-200">
                    <option value="">Wybierz status</option>
                    @foreach ($workStatuses as $workStatus)
                        <option value="{{ $workStatus->id }}">{{ $workStatus->name }}</option>
                    @endforeach
                </select>
            </div>
            @error('form.status_id')
                <div class="mt-2 flex items-center space-x-2">
                    <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm text-red-600">{{ $message }}</span>
                </div>
            @enderror
        </div>

        <!-- Informacje -->
        <div class="md:col-span-2">
            <label for="notes" class="block text-sm font-semibold text-gray-900 mb-3">
                <div class="flex items-center gap-2">
                    <div class="w-5 h-5 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    Informacje
                </div>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <textarea wire:model="form.notes"
                          id="notes"
                          name="notes"
                          class="block w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 placeholder-gray-500 transition-colors duration-200"
                          placeholder="Podaj informacje"
                          autocomplete="notes"></textarea>
            </div>
            @error('form.notes')
                <div class="mt-2 flex items-center space-x-2">
                    <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm text-red-600">{{ $message }}</span>
                </div>
            @enderror
        </div>
    </div>

    <div class="pt-6">
        <button type="submit"
                class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span>Zapisz</span>
        </button>
    </div>
</div>