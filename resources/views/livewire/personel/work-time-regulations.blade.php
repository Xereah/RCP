<div class="min-h-screen bg-gradient-to-br from-gray-50 to-slate-100 py-4 px-4">
    <div class="mx-auto">
        <!-- Professional Header Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200/50 p-8 hover:shadow-xl transition-shadow duration-300 mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div class="flex items-center space-x-5">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl flex items-center justify-center shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-1">
                            Regulaminy czasu pracy
                        </h1>
                        <p class="text-lg text-gray-600">{{ $personel->first_name }} {{ $personel->last_name }}</p>
                    </div>
                </div>
                
                <!-- Back Button -->
                <div class="flex-shrink-0">
                    <a href="{{ route('personels.index') }}" wire:navigate
                        class="inline-flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-xl shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Powrót
                    </a>
                </div>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl">
                {{ session('message') }}
            </div>
        @endif

        <div class="grid lg:grid-cols-2 gap-6">
            <!-- Formularz -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200/50 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        {{ $editingId ? 'Edycja regulaminu' : 'Dodaj nowy regulamin' }}
                    </h2>
                </div>

                <div class="p-6">
                    <form wire:submit="save" class="space-y-4">
                        <!-- Regulamin -->
                        <div>
                            <label for="work_time_regulation_id" class="block text-sm font-semibold text-gray-900 mb-2">
                                Regulamin czasu pracy <span class="text-red-500">*</span>
                            </label>
                            <select wire:model="work_time_regulation_id" id="work_time_regulation_id"
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">Wybierz regulamin</option>
                                @foreach ($regulations as $regulation)
                                    <option value="{{ $regulation->id }}">
                                        {{ $regulation->name }} ({{ $regulation->daily_hours }}h/dzień)
                                    </option>
                                @endforeach
                            </select>
                            @error('work_time_regulation_id')
                                <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Data rozpoczęcia -->
                        <div>
                            <label for="valid_from" class="block text-sm font-semibold text-gray-900 mb-2">
                                Data rozpoczęcia <span class="text-red-500">*</span>
                            </label>
                            <input type="date" wire:model="valid_from" id="valid_from"
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @error('valid_from')
                                <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Data zakończenia -->
                        <div>
                            <label for="valid_to" class="block text-sm font-semibold text-gray-900 mb-2">
                                Data zakończenia (opcjonalnie)
                            </label>
                            <input type="date" wire:model="valid_to" id="valid_to"
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @error('valid_to')
                                <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                            @enderror
                            <p class="text-sm text-gray-500 mt-1">Pozostaw puste dla regulaminu bez daty końcowej</p>
                        </div>

                        <!-- Notatki -->
                        <div>
                            <label for="notes" class="block text-sm font-semibold text-gray-900 mb-2">
                                Notatki
                            </label>
                            <textarea wire:model="notes" id="notes" rows="3"
                                      class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                      placeholder="np. okres karmiącej matki do końca pierwszego roku życia dziecka"></textarea>
                            @error('notes')
                                <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Przyciski -->
                        <div class="flex gap-3 pt-4">
                            <button type="submit"
                                    class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-sm hover:shadow-md transition-all">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ $editingId ? 'Zaktualizuj' : 'Dodaj' }}
                            </button>
                            @if($editingId)
                                <button type="button" wire:click="cancelEdit"
                                        class="px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-xl transition-all">
                                    Anuluj
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Historia -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200/50 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Historia regulaminów ({{ count($history) }})
                    </h2>
                </div>

                <div class="p-6">
                    @if(count($history) > 0)
                        <div class="space-y-4">
                            @foreach ($history as $entry)
                                <div class="border border-gray-200 rounded-xl p-4 {{ $entry->isCurrentlyValid() ? 'bg-green-50 border-green-300' : 'bg-gray-50' }}">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-900">{{ $entry->workTimeRegulation->name }}</h3>
                                            <p class="text-sm text-gray-600">{{ $entry->workTimeRegulation->daily_hours }}h dziennie / {{ $entry->workTimeRegulation->weekly_hours }}h tygodniowo</p>
                                        </div>
                                        @if($entry->isCurrentlyValid())
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Aktywny
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <div class="text-sm text-gray-700 space-y-1">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span>{{ $entry->valid_from->format('d.m.Y') }} - {{ $entry->valid_to ? $entry->valid_to->format('d.m.Y') : 'obecnie' }}</span>
                                        </div>
                                        @if($entry->notes)
                                            <div class="flex items-start gap-2 mt-2">
                                                <svg class="w-4 h-4 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                                </svg>
                                                <span class="text-gray-600">{{ $entry->notes }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex gap-2 mt-3 pt-3 border-t border-gray-200">
                                        <button wire:click="edit({{ $entry->id }})"
                                                class="flex-1 px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm rounded-lg transition-colors">
                                            Edytuj
                                        </button>
                                        <button wire:click="delete({{ $entry->id }})"
                                                wire:confirm="Na pewno chcesz usunąć ten regulamin? Operacja jest nieodwracalna."
                                                class="flex-1 px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-sm rounded-lg transition-colors">
                                            Usuń
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p>Brak przypisanych regulaminów czasu pracy</p>
                            <p class="text-sm">Dodaj pierwszy regulamin używając formularza obok</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

