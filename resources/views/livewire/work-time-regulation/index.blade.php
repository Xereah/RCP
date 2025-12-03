<div class="min-h-screen bg-gradient-to-br from-gray-50 to-slate-100 py-4 px-4" 
     x-data="{ showTooltip: null }">
    <div class="mx-auto">        
        <!-- Professional Header Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200/50 p-8 hover:shadow-xl transition-shadow duration-300">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div class="flex items-center space-x-5">
                    <div class="relative">
                        <!-- Professional icon container -->
                        <div class="w-16 h-16 bg-gradient-to-br from-indigo-600 to-indigo-800 rounded-xl flex items-center justify-center shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <!-- Professional badge -->
                        <div class="absolute -top-1 -right-1 w-6 h-6 bg-emerald-500 rounded-full flex items-center justify-center">
                            <span class="text-xs font-semibold text-white">{{ count($workTimeRegulations) }}</span>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-1">
                            Regulaminy czasu pracy
                        </h1>
                        <p class="text-lg text-gray-600">Zarządzaj regulaminami czasu pracy zgodnie z Kodeksem Pracy</p>
                    </div>
                </div>
                
                <!-- CTA Button -->
                <div class="flex-shrink-0">
                    <a href="{{ route('work-time-regulations.create') }}" 
                       wire:navigate
                       class="inline-flex items-center px-6 py-3 bg-indigo-800 hover:bg-indigo-900 text-white font-semibold rounded-xl shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Dodaj regulamin
                    </a>
                </div>
            </div>
        </div>

        @include('components.toasts')    

        <!-- Main Content Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200/50 overflow-hidden">
            
            <!-- Professional Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <!-- Table Header -->
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">Lp.</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">Nazwa</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">Kod</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">Godziny dziennie</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">Godziny tygodniowo</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider"></th>                               
                        </tr>
                    </thead>
                    
                    <!-- Table Body -->
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($workTimeRegulations as $key => $regulation)
                            <tr class="hover:bg-gray-50 transition-colors duration-150" wire:key="{{ $regulation->id }}">
                                <!-- Row Number -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                            <span class="text-sm font-semibold text-gray-700">
                                                {{ ($workTimeRegulations->currentPage() - 1) * $workTimeRegulations->perPage() + $loop->iteration }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Name -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-2 h-8 bg-indigo-600 rounded-full mr-3"></div>
                                        <div>
                                            <div class="text-base font-semibold text-gray-900">
                                                {{ $regulation->name }}
                                            </div>
                                            @if($regulation->is_task_based)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                                    Zadaniowy
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Code -->
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $regulation->code }}
                                    </span>
                                </td>

                                <!-- Daily Hours -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $regulation->daily_hours }}h</div>
                                </td>

                                <!-- Weekly Hours -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $regulation->weekly_hours }}h</div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($regulation->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            Aktywny
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            Nieaktywny
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('work-time-regulations.show', $regulation->id) }}" 
                                           wire:navigate
                                           class="inline-flex items-center justify-center p-2 text-white bg-green-500 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                                           title="Zobacz szczegóły">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('work-time-regulations.edit', $regulation->id) }}" 
                                           wire:navigate
                                           class="inline-flex items-center justify-center p-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                           title="Edytuj regulamin">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                        </a>
                                        <button @click="confirmAction('delete', {{ $regulation->id }}, 'Na pewno chcesz usunąć ten regulamin?', 'Tak, usuń!', 'warning')"
                                               class="inline-flex items-center justify-center p-2 text-white bg-red-500 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                                                title="Usuń regulamin">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
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
            @if($workTimeRegulations->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Pokazano <span class="font-semibold">{{ $workTimeRegulations->firstItem() }}</span> - 
                            <span class="font-semibold">{{ $workTimeRegulations->lastItem() }}</span> z 
                            <span class="font-semibold">{{ $workTimeRegulations->total() }}</span> wyników
                        </div>
                        <div class="flex space-x-1">
                            {!! $workTimeRegulations->withQueryString()->links() !!}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

