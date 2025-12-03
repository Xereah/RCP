<div class="min-h-screen bg-gradient-to-br from-gray-50 to-slate-100 py-4 px-4">
    <div class="mx-auto">
        <!-- Professional Header Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200/50 p-8 hover:shadow-xl transition-shadow duration-300 mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div class="flex items-center space-x-5">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-600 to-green-800 rounded-xl flex items-center justify-center shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-1">
                            Szczegóły regulaminu
                        </h1>
                        <p class="text-lg text-gray-600">{{ $workTimeRegulation->name }}</p>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex gap-3">
                    <a href="{{ route('work-time-regulations.edit', $workTimeRegulation->id) }}" wire:navigate
                        class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edytuj
                    </a>
                    <a href="{{ route('work-time-regulations.index') }}" wire:navigate
                        class="inline-flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-xl shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Powrót
                    </a>
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <!-- Basic Information Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200/50 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Informacje podstawowe
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-start pb-4 border-b border-gray-200">
                        <span class="text-sm font-semibold text-gray-600">Nazwa:</span>
                        <span class="text-sm text-gray-900 font-medium text-right">{{ $workTimeRegulation->name }}</span>
                    </div>
                    <div class="flex justify-between items-start pb-4 border-b border-gray-200">
                        <span class="text-sm font-semibold text-gray-600">Kod:</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            {{ $workTimeRegulation->code }}
                        </span>
                    </div>
                    <div class="flex justify-between items-start pb-4 border-b border-gray-200">
                        <span class="text-sm font-semibold text-gray-600">Typ:</span>
                        <span class="text-sm text-gray-900 font-medium">
                            @if($workTimeRegulation->is_task_based)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    Zadaniowy czas pracy
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Standardowy
                                </span>
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between items-start pb-4 border-b border-gray-200">
                        <span class="text-sm font-semibold text-gray-600">Status:</span>
                        <span class="text-sm text-gray-900 font-medium">
                            @if($workTimeRegulation->is_active)
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
                        </span>
                    </div>
                    @if($workTimeRegulation->description)
                        <div class="pt-2">
                            <span class="text-sm font-semibold text-gray-600 block mb-2">Opis:</span>
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $workTimeRegulation->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Work Hours Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200/50 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Wymiar czasu pracy
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                        <span class="text-sm font-semibold text-gray-600">Godziny dziennie:</span>
                        <span class="text-2xl font-bold text-blue-600">{{ $workTimeRegulation->daily_hours }}h</span>
                    </div>
                    <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                        <span class="text-sm font-semibold text-gray-600">Godziny tygodniowo:</span>
                        <span class="text-2xl font-bold text-blue-600">{{ $workTimeRegulation->weekly_hours }}h</span>
                    </div>
                    @if($workTimeRegulation->monthly_hours)
                        <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                            <span class="text-sm font-semibold text-gray-600">Godziny miesięcznie:</span>
                            <span class="text-2xl font-bold text-blue-600">{{ $workTimeRegulation->monthly_hours }}h</span>
                        </div>
                    @endif
                    <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                        <span class="text-sm font-semibold text-gray-600">Przerwa w pracy:</span>
                        <span class="text-lg font-semibold text-gray-900">{{ $workTimeRegulation->break_minutes }} min</span>
                    </div>
                    @if($workTimeRegulation->nursing_mother_break > 0)
                        <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                            <span class="text-sm font-semibold text-gray-600">Przerwa dla matki karmiącej:</span>
                            <span class="text-lg font-semibold text-pink-600">{{ $workTimeRegulation->nursing_mother_break }} min</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Flexibility Card -->
            @if($workTimeRegulation->start_time_flex > 0 || $workTimeRegulation->end_time_flex > 0)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200/50 overflow-hidden md:col-span-2">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Elastyczność czasu pracy
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            @if($workTimeRegulation->start_time_flex > 0)
                                <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                                    <span class="text-sm font-semibold text-gray-600">Elastyczność rozpoczęcia:</span>
                                    <span class="text-lg font-semibold text-purple-600">±{{ $workTimeRegulation->start_time_flex }} min</span>
                                </div>
                            @endif
                            @if($workTimeRegulation->end_time_flex > 0)
                                <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                                    <span class="text-sm font-semibold text-gray-600">Elastyczność zakończenia:</span>
                                    <span class="text-lg font-semibold text-purple-600">±{{ $workTimeRegulation->end_time_flex }} min</span>
                                </div>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600 mt-4">
                            <strong>Ruchomy czas pracy</strong> zgodnie z art. 140¹ Kodeksu Pracy pozwala na elastyczne rozpoczynanie i kończenie pracy w określonych ramach czasowych.
                        </p>
                    </div>
                </div>
            @endif

            <!-- Legal Information Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200/50 overflow-hidden md:col-span-2">
                <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Podstawa prawna
                    </h2>
                </div>
                <div class="p-6 bg-amber-50/30">
                    <div class="prose prose-sm max-w-none text-gray-700">
                        <p class="mb-3">
                            <strong>Kodeks Pracy - Podstawowe przepisy dotyczące czasu pracy:</strong>
                        </p>
                        <ul class="space-y-2 text-sm">
                            <li><strong>Art. 129 KP</strong> - Czas pracy nie może przekraczać 8 godzin na dobę i przeciętnie 40 godzin w przeciętnie pięciodniowym tygodniu pracy w przyjętym okresie rozliczeniowym nieprzekraczającym 4 miesięcy.</li>
                            <li><strong>Art. 134 KP</strong> - Pracownikowi wykonującemu pracę co najmniej 6 godzin przysługuje przerwa w pracy trwająca co najmniej 15 minut, wliczana do czasu pracy.</li>
                            <li><strong>Art. 140 KP</strong> - Zadaniowy system czasu pracy dla pracowników zarządzających w imieniu pracodawcy zakładem pracy oraz innych przypadków określonych w przepisach.</li>
                            <li><strong>Art. 140¹ KP</strong> - Ruchomy czas pracy z elastycznymi godzinami rozpoczynania i kończenia pracy.</li>
                            <li><strong>Art. 187 KP</strong> - Pracownica karmiąca dziecko piersią ma prawo do dwóch półgodzinnych przerw w pracy wliczanych do czasu pracy (lub jednej godzinnej przerwy).</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timestamps Card -->
        <div class="mt-6 bg-white rounded-2xl shadow-lg border border-gray-200/50 p-6">
            <div class="flex justify-between text-sm text-gray-500">
                <div>
                    <span class="font-semibold">Utworzono:</span>
                    <span>{{ $workTimeRegulation->created_at->format('d.m.Y H:i') }}</span>
                </div>
                <div>
                    <span class="font-semibold">Ostatnia modyfikacja:</span>
                    <span>{{ $workTimeRegulation->updated_at->format('d.m.Y H:i') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

