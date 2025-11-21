<div class="space-y-6">

    <!-- GRID 2 columns -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Numer personalny -->
        <div>
            <label for="personal_number" class="block text-sm font-semibold text-gray-900 mb-3">
                <div class="flex items-center gap-2">
                    <div class="w-5 h-5 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    Numer personalny
                </div>
            </label>

            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>

                <input wire:model="form.personal_number"
                       id="personal_number"
                       type="text"
                       placeholder="Podaj numer personalny"
                       class="block w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl
                              focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                              text-gray-900 placeholder-gray-500 transition-colors duration-200">
            </div>

            @error('form.personal_number')
                <div class="mt-2 flex items-center space-x-2">
                    <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm text-red-600">{{ $message }}</span>
                </div>
            @enderror
        </div>

        <!-- Nazwisko -->
        <div>
            <label for="last_name" class="block text-sm font-semibold text-gray-900 mb-3">
                <div class="flex items-center gap-2">
                    <div class="w-5 h-5 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    Nazwisko
                </div>
            </label>

            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>

                <input wire:model="form.last_name"
                       id="last_name"
                       type="text"
                       placeholder="Podaj nazwisko"
                       class="block w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl 
                              focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                              text-gray-900 placeholder-gray-500 transition-colors">
            </div>

            @error('form.last_name')
                <div class="mt-2 flex items-center space-x-2">
                    <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm text-red-600">{{ $message }}</span>
                </div>
            @enderror
        </div>

        <!-- Imię -->
        <div>
            <label for="first_name" class="block text-sm font-semibold text-gray-900 mb-3">
                <div class="flex items-center gap-2">
                    <div class="w-5 h-5 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    Imię
                </div>
            </label>

            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>

                <input wire:model="form.first_name"
                       id="first_name"
                       type="text"
                       placeholder="Podaj imię"
                       class="block w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl
                              focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                              text-gray-900 placeholder-gray-500 transition-colors">
            </div>

            @error('form.first_name')
                <div class="mt-2 flex items-center space-x-2">
                    <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm text-red-600">{{ $message }}</span>
                </div>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-900 mb-3">
                <div class="flex items-center gap-2">
                    <div class="w-5 h-5 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    Email
                </div>
            </label>

            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>

                <input wire:model="form.email"
                       id="email"
                       type="email"
                       placeholder="Podaj adres email"
                       class="block w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl
                              focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                              text-gray-900 placeholder-gray-500 transition-colors">
            </div>

            @error('form.email')
                <div class="mt-2 flex items-center space-x-2">
                    <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm text-red-600">{{ $message }}</span>
                </div>
            @enderror
        </div>

        <!-- Stanowisko -->
        <div>
            <label for="position_id" class="block text-sm font-semibold text-gray-900 mb-3">
                <div class="flex items-center gap-2">
                    <div class="w-5 h-5 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    Nazwa stanowiska
                </div>
            </label>

            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>

                <select wire:model="form.position_id"
                        id="position_id"
                        class="block w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl
                               focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Wybierz stanowisko</option>
                    @foreach ($positions as $position)
                        <option value="{{ $position->id }}">{{ $position->name }}</option>
                    @endforeach
                </select>
            </div>

            @error('form.position_id')
                <div class="mt-2 flex items-center space-x-2">
                    <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm text-red-600">{{ $message }}</span>
                </div>
            @enderror
        </div>

        <!-- Aktywny -->
        <div>
            <label for="is_active" class="block text-sm font-semibold text-gray-900 mb-3">
                <div class="flex items-center gap-2">
                    <div class="w-5 h-5 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    Aktywny
                </div>
            </label>

            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>

                <select wire:model="form.is_active"
                        id="is_active"
                        class="block w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl
                               focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Wybierz status</option>
                    <option value="1">Aktywny</option>
                    <option value="0">Nieaktywny</option>
                </select>
            </div>

            @error('form.is_active')
                <div class="mt-2 flex items-center space-x-2">
                    <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm text-red-600">{{ $message }}</span>
                </div>
            @enderror
        </div>
        <!-- Miejsce pracy -->
        <div>
            <label for="work_place_id" class="block text-sm font-semibold text-gray-900 mb-3">
                <div class="flex items-center gap-2">
                    <div class="w-5 h-5 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        
                        </svg>
                    </div>
                    Miejsce pracy
                </div>
            </label>

            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>

                <select wire:model="form.work_place_id"
                        id="work_place_id"
                        class="block w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl
                               focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Wybierz miejsce pracy</option>
                    @foreach ($workPlaces as $workPlace)
                        <option value="{{ $workPlace->id }}">{{ $workPlace->name }}</option>
                    @endforeach
                </select>
            </div>

            @error('form.work_place_id')
                <div class="mt-2 flex items-center space-x-2">
                    <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm text-red-600">{{ $message }}</span>
                </div>
            @enderror
        </div>
    </div>

    <!-- Submit Button -->
    <div class="pt-6">
        <button type="submit"
                class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5 13l4 4L19 7"></path>
            </svg>
            Zapisz
        </button>
    </div>
</div>
