<div class="space-y-6">
    <!-- Name and Code Row -->
    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-900 mb-3">
                <div class="flex items-center gap-2">
                    <div class="w-5 h-5 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    Nazwa regulaminu <span class="text-red-500">*</span>
                </div>
            </label>
            <div class="relative">
                <input wire:model="form.name" 
                       id="name" 
                       name="name" 
                       type="text" 
                       class="block w-full px-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 placeholder-gray-500 transition-colors duration-200"
                       placeholder="np. Pełny etat (8h)"
                       required>
            </div>
            @error('form.name')
                <div class="mt-2 flex items-center space-x-2">
                    <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm text-red-600">{{ $message }}</span>
                </div>
            @enderror
        </div>

        <div>
            <label for="code" class="block text-sm font-semibold text-gray-900 mb-3">
                <div class="flex items-center gap-2">
                    <div class="w-5 h-5 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                    </div>
                    Kod regulaminu <span class="text-red-500">*</span>
                </div>
            </label>
            <div class="relative">
                <input wire:model="form.code" 
                       id="code" 
                       name="code" 
                       type="text" 
                       class="block w-full px-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 placeholder-gray-500 transition-colors duration-200"
                       placeholder="np. FULL_TIME"
                       required>
            </div>
            @error('form.code')
                <div class="mt-2 flex items-center space-x-2">
                    <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm text-red-600">{{ $message }}</span>
                </div>
            @enderror
        </div>
    </div>

    <!-- Description -->
    <div>
        <label for="description" class="block text-sm font-semibold text-gray-900 mb-3">
            <div class="flex items-center gap-2">
                <div class="w-5 h-5 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center">
                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                    </svg>
                </div>
                Opis
            </div>
        </label>
        <textarea wire:model="form.description" 
                  id="description" 
                  name="description" 
                  rows="3"
                  class="block w-full px-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 placeholder-gray-500 transition-colors duration-200"
                  placeholder="Opisz regulamin czasu pracy"></textarea>
        @error('form.description')
            <div class="mt-2 flex items-center space-x-2">
                <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-sm text-red-600">{{ $message }}</span>
            </div>
        @enderror
    </div>

    <!-- Work Hours Row -->
    <div class="grid md:grid-cols-3 gap-6">
        <div>
            <label for="daily_hours" class="block text-sm font-semibold text-gray-900 mb-3">
                <div class="flex items-center gap-2">
                    <div class="w-5 h-5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    Godziny dziennie <span class="text-red-500">*</span>
                </div>
            </label>
            <input wire:model="form.daily_hours" 
                   id="daily_hours" 
                   name="daily_hours" 
                   type="number" 
                   step="0.01"
                   min="0"
                   max="24"
                   class="block w-full px-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900"
                   required>
            @error('form.daily_hours')
                <div class="mt-2 flex items-center space-x-2">
                    <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm text-red-600">{{ $message }}</span>
                </div>
            @enderror
        </div>

        <div>
            <label for="weekly_hours" class="block text-sm font-semibold text-gray-900 mb-3">
                <div class="flex items-center gap-2">
                    <div class="w-5 h-5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    Godziny tygodniowo <span class="text-red-500">*</span>
                </div>
            </label>
            <input wire:model="form.weekly_hours" 
                   id="weekly_hours" 
                   name="weekly_hours" 
                   type="number" 
                   step="0.01"
                   min="0"
                   max="168"
                   class="block w-full px-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900"
                   required>
            @error('form.weekly_hours')
                <div class="mt-2 flex items-center space-x-2">
                    <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm text-red-600">{{ $message }}</span>
                </div>
            @enderror
        </div>

        <div>
            <label for="monthly_hours" class="block text-sm font-semibold text-gray-900 mb-3">
                <div class="flex items-center gap-2">
                    <div class="w-5 h-5 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    Godziny miesięcznie
                </div>
            </label>
            <input wire:model="form.monthly_hours" 
                   id="monthly_hours" 
                   name="monthly_hours" 
                   type="number" 
                   step="0.01"
                   min="0"
                   class="block w-full px-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900"
                   placeholder="Opcjonalnie">
            @error('form.monthly_hours')
                <div class="mt-2 flex items-center space-x-2">
                    <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm text-red-600">{{ $message }}</span>
                </div>
            @enderror
        </div>
    </div>

    <!-- Break Times Row -->
    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <label for="break_minutes" class="block text-sm font-semibold text-gray-900 mb-3">
                <div class="flex items-center gap-2">
                    <div class="w-5 h-5 bg-gradient-to-r from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    Przerwa w pracy (minuty) <span class="text-red-500">*</span>
                </div>
            </label>
            <input wire:model="form.break_minutes" 
                   id="break_minutes" 
                   name="break_minutes" 
                   type="number" 
                   min="0"
                   class="block w-full px-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900"
                   required>
            @error('form.break_minutes')
                <div class="mt-2 flex items-center space-x-2">
                    <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm text-red-600">{{ $message }}</span>
                </div>
            @enderror
            <p class="mt-1 text-sm text-gray-500">Przerwa zgodna z art. 134 KP (15 min przy > 6h pracy)</p>
        </div>

        <div>
            <label for="nursing_mother_break" class="block text-sm font-semibold text-gray-900 mb-3">
                <div class="flex items-center gap-2">
                    <div class="w-5 h-5 bg-gradient-to-r from-pink-500 to-pink-600 rounded-lg flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    Przerwa dla matki karmiącej (minuty) <span class="text-red-500">*</span>
                </div>
            </label>
            <input wire:model="form.nursing_mother_break" 
                   id="nursing_mother_break" 
                   name="nursing_mother_break" 
                   type="number" 
                   min="0"
                   class="block w-full px-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900"
                   required>
            @error('form.nursing_mother_break')
                <div class="mt-2 flex items-center space-x-2">
                    <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm text-red-600">{{ $message }}</span>
                </div>
            @enderror
            <p class="mt-1 text-sm text-gray-500">Zgodnie z art. 187 KP (2x30min lub 1x60min)</p>
        </div>
    </div>

    <!-- Flexibility Row -->
    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <label for="start_time_flex" class="block text-sm font-semibold text-gray-900 mb-3">
                <div class="flex items-center gap-2">
                    <div class="w-5 h-5 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    Elastyczność startu (±minuty) <span class="text-red-500">*</span>
                </div>
            </label>
            <input wire:model="form.start_time_flex" 
                   id="start_time_flex" 
                   name="start_time_flex" 
                   type="number" 
                   min="0"
                   class="block w-full px-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900"
                   required>
            @error('form.start_time_flex')
                <div class="mt-2 flex items-center space-x-2">
                    <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm text-red-600">{{ $message }}</span>
                </div>
            @enderror
            <p class="mt-1 text-sm text-gray-500">Dla ruchomego czasu pracy (art. 140¹ KP)</p>
        </div>

        <div>
            <label for="end_time_flex" class="block text-sm font-semibold text-gray-900 mb-3">
                <div class="flex items-center gap-2">
                    <div class="w-5 h-5 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    Elastyczność zakończenia (±minuty) <span class="text-red-500">*</span>
                </div>
            </label>
            <input wire:model="form.end_time_flex" 
                   id="end_time_flex" 
                   name="end_time_flex" 
                   type="number" 
                   min="0"
                   class="block w-full px-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900"
                   required>
            @error('form.end_time_flex')
                <div class="mt-2 flex items-center space-x-2">
                    <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm text-red-600">{{ $message }}</span>
                </div>
            @enderror
        </div>
    </div>

    <!-- Checkboxes Row -->
    <div class="grid md:grid-cols-2 gap-6">
        <div class="flex items-center p-4 bg-purple-50 rounded-xl border border-purple-200">
            <input wire:model="form.is_task_based" 
                   id="is_task_based" 
                   name="is_task_based" 
                   type="checkbox"
                   class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
            <label for="is_task_based" class="ml-3 block text-sm font-medium text-gray-900">
                Zadaniowy czas pracy
                <p class="text-xs text-gray-600 mt-1">Art. 140 KP - dla kierowników i zarządzających</p>
            </label>
        </div>

        <div class="flex items-center p-4 bg-green-50 rounded-xl border border-green-200">
            <input wire:model="form.is_active" 
                   id="is_active" 
                   name="is_active" 
                   type="checkbox"
                   class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
            <label for="is_active" class="ml-3 block text-sm font-medium text-gray-900">
                Aktywny
                <p class="text-xs text-gray-600 mt-1">Czy regulamin jest dostępny do przypisania</p>
            </label>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="pt-6">
        <button type="submit"
                class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span>Zapisz regulamin</span>
        </button>
    </div>
</div>

