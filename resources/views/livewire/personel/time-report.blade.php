<div>
    {{-- Modal autoryzacji --}}
    @if($showAuthModal && !$isAuthenticated)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            {{-- Tło --}}
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            
            {{-- Wyśrodkowanie modala --}}
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            {{-- Panel modala --}}
            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div>
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                        <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    
                    <div class="mt-3 text-center sm:mt-5">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Panel Podglądu Czasu Pracy
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Zaloguj się używając swojego numeru pracownika
                            </p>
                        </div>
                    </div>
                </div>
                
                <form wire:submit.prevent="authenticate" class="mt-5 sm:mt-6">
                    {{-- Numer pracownika --}}
                    <div class="mb-4">
                        <label for="personalNumber" class="block text-sm font-medium text-gray-700 mb-2">
                            Numer pracownika
                        </label>
                        <input 
                            type="text" 
                            id="personalNumber"
                            wire:model="personalNumber"
                            class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('personalNumber') border-red-300 @enderror"
                            placeholder="Wprowadź numer personalny"
                            autofocus
                        >
                        @error('personalNumber')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Hasło --}}
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Hasło
                        </label>
                        <input 
                            type="password" 
                            id="password"
                            wire:model="password"
                            class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('password') border-red-300 @enderror"
                            placeholder="Wprowadź hasło"
                        >
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror                       
                    </div>
                    
                    {{-- Przycisk --}}
                    <div class="mt-5 sm:mt-6">
                        <button 
                            type="submit"
                            class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm"
                        >
                            Zaloguj się
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
    
    {{-- Główna treść panelu --}}
    @if($isAuthenticated && $personel)
    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            {{-- Nagłówek z informacjami o pracowniku --}}
            @php
                // Znajdź aktywną sesję z dzisiaj
                $todaySession = \App\Models\WorkSession::query()
                    ->where('personel_id', $personel->id)
                    ->whereDate('work_date', \Carbon\Carbon::today())
                    ->whereNull('end_time')
                    ->with('workStatus')
                    ->latest('start_time')
                    ->first();
            @endphp
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h2 class="text-2xl font-bold text-gray-900">
                                    {{ $personel->first_name }} {{ $personel->last_name }}
                                </h2>
                                @if($todaySession)
                                    <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full flex items-center gap-1.5">
                                        <span class="relative flex h-2 w-2">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                        </span>
                                        Obecnie w pracy
                                    </span>
                                @endif
                            </div>
                            
                            <p class="text-sm text-gray-500 mb-2">
                                Numer pracownika: {{ $personel->personal_number }}
                                @if($personel->position)
                                    | Stanowisko: {{ $personel->position->name }}
                                @endif
                            </p>
                            
                            @if($todaySession)
                                <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                    <div class="flex items-center gap-2 text-sm">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-blue-900 font-medium">Rozpoczęcie pracy dzisiaj:</span>
                                        <span class="text-blue-700 font-bold">{{ \Carbon\Carbon::parse($todaySession->start_time)->format('H:i') }}</span>
                                        @if($todaySession->workStatus)
                                            <span class="text-blue-600">| Status: {{ $todaySession->workStatus->name }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <button 
                            wire:click="logout"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            Wyloguj
                        </button>
                    </div>
                </div>
            </div>           
           
            
            {{-- Statystyki miesięczne --}}
            @php
                $standardMinutes = 0;
                $overtimeMinutes = 0;
                foreach($calendarDays as $day) {
                    foreach($day['sessions'] as $session) {
                        $adjusted = $session->getAdjustedDuration();
                        if ($adjusted > 480) {
                            $standardMinutes += 480;
                            $overtimeMinutes += ($adjusted - 480);
                        } else {
                            $standardMinutes += $adjusted;
                        }
                    }
                }
            @endphp
            
           
            </div>
            
            {{-- Nawigacja miesięczna --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <button 
                            wire:click="previousMonth"
                            class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:bg-gray-200 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Poprzedni
                        </button>
                        
                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-gray-900">
                                {{ \Carbon\Carbon::create($currentYear, $currentMonth, 1)->locale('pl')->isoFormat('MMMM YYYY') }}
                            </h3>
                            <button 
                                wire:click="goToCurrentMonth"
                                class="mt-2 text-sm text-blue-600 hover:text-blue-800 underline"
                            >
                                Bieżący miesiąc
                            </button>
                        </div>
                        
                        <button 
                            wire:click="nextMonth"
                            class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:bg-gray-200 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            Następny
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            
            {{-- Tabela z kalendarzem --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-4">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-lg font-semibold text-gray-900">
                                Raport czasu pracy - {{ \Carbon\Carbon::create($currentYear, $currentMonth, 1)->locale('pl')->isoFormat('MMMM YYYY') }}
                            </h3>
                            
                            {{-- Legenda --}}
                            <div class="flex gap-4 text-xs">
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 bg-red-50 border border-red-200 rounded"></div>
                                    <span class="text-gray-600">Święto</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 bg-gray-50 border border-gray-200 rounded"></div>
                                    <span class="text-gray-600">Weekend</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 bg-blue-50 border border-blue-200 rounded"></div>
                                    <span class="text-gray-600">Dzisiaj</span>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Informacja o zasadach naliczania i statusach --}}
                        <div class="space-y-3">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                <div class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div class="text-xs text-blue-800">
                                        <span class="font-semibold">Zasady naliczania czasu pracy:</span>
                                        Standardowy czas pracy to 8h (480 minut). Nadgodziny powyżej 8h są zaokrąglane w dół do pełnych 15 minut.
                                    </div>
                                </div>
                            </div>                           
                        </div>
                    </div>
                    
                    @if(empty($calendarDays))
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Brak danych</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Nie znaleziono sesji pracy w wybranym miesiącu.
                            </p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-300 border border-gray-300">
                                <thead class="bg-gradient-to-r from-blue-600 to-blue-700">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 text-center text-xs font-bold text-white uppercase tracking-wider border-r border-blue-500">
                                            Data
                                        </th>
                                        <th scope="col" class="px-4 py-3 text-center text-xs font-bold text-white uppercase tracking-wider border-r border-blue-500">
                                            Dzień
                                        </th>
                                        <th scope="col" class="px-4 py-3 text-center text-xs font-bold text-white uppercase tracking-wider border-r border-blue-500">
                                            Wejście
                                        </th>
                                        <th scope="col" class="px-4 py-3 text-center text-xs font-bold text-white uppercase tracking-wider border-r border-blue-500">
                                            Wyjście
                                        </th>
                                        <th scope="col" class="px-4 py-3 text-center text-xs font-bold text-white uppercase tracking-wider border-r border-blue-500">
                                            Czas pracy
                                        </th>
                                        <th scope="col" class="px-4 py-3 text-center text-xs font-bold text-white uppercase tracking-wider border-r border-blue-500">
                                            Nadgodziny
                                        </th>
                                        <th scope="col" class="px-4 py-3 text-center text-xs font-bold text-white uppercase tracking-wider">
                                            Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @php
                                        $cumulativeMinutes = 0;
                                    @endphp
                                    @foreach($calendarDays as $day)
                                        @php
                                            $cumulativeMinutes += $day['totalMinutes'];
                                            $rowClass = '';
                                            $textClass = '';
                                            
                                            if ($day['isHoliday']) {
                                                $rowClass = 'bg-red-50';
                                                $textClass = 'text-red-700';
                                            } elseif ($day['isToday']) {
                                                $rowClass = 'bg-blue-50';
                                                $textClass = 'text-blue-700';
                                            } elseif ($day['isWeekend']) {
                                                $rowClass = 'bg-gray-50';
                                                $textClass = 'text-red-600';
                                            } else {
                                                $textClass = 'text-gray-900';
                                            }
                                        @endphp
                                        
                                        @if($day['sessions']->count() > 0)
                                            @foreach($day['sessions'] as $index => $session)
                                                <tr class="hover:bg-blue-100 {{ $rowClass }} border-b border-gray-200">
                                                    @if($index === 0)
                                                        <td rowspan="{{ $day['sessions']->count() }}" class="px-4 py-3 text-center border-r border-gray-300">
                                                            <div class="text-sm font-bold {{ $textClass }}">
                                                                {{ $day['date']->format('d.m.Y') }}
                                                            </div>
                                                            @if($day['isHoliday'])
                                                                <div class="text-xs text-red-600 font-semibold mt-1">
                                                                    {{ $day['holidayName'] }}
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td rowspan="{{ $day['sessions']->count() }}" class="px-4 py-3 text-center text-sm font-medium {{ $textClass }} border-r border-gray-300">
                                                            {{ ucfirst($day['dayName']) }}
                                                        </td>
                                                    @endif
                                                    
                                                    <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-200">
                                                        {{ $session->start_time ? \Carbon\Carbon::parse($session->start_time)->format('H:i') : '-' }}
                                                    </td>
                                                    <td class="px-4 py-3 text-center text-sm border-r border-gray-200">
                                                        @if($session->end_time)
                                                            <span class="text-gray-900">{{ \Carbon\Carbon::parse($session->end_time)->format('H:i') }}</span>
                                                        @elseif($session->workStatus && $session->workStatus->name === 'Obecny')
                                                            <div class="flex flex-col items-center">
                                                                <span class="text-orange-600 font-semibold">W trakcie</span>
                                                                @if($day['isToday'])
                                                                    <span class="text-xs text-orange-500 mt-0.5">Obecnie pracuje</span>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <span class="text-gray-400">-</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-3 text-center text-sm border-r border-gray-200">
                                                        @if($session->end_time)
                                                            <div class="font-semibold {{ $session->has_overtime ? 'text-green-700' : 'text-gray-900' }}">
                                                                {{ $session->duration_human ?? '-' }}
                                                            </div>
                                                            @if($session->has_overtime)
                                                                <div class="text-xs text-green-600 font-medium mt-0.5">
                                                                    ⏱️ Nadgodziny
                                                                </div>
                                                            @endif
                                                            @if($session->incomplete_shift_warning)
                                                                <div class="text-xs text-orange-600 font-medium mt-0.5">
                                                                    ⚠️ Niepełny czas
                                                                </div>
                                                            @endif
                                                        @elseif($session->workStatus && $session->workStatus->name === 'Obecny')
                                                            <div class="flex flex-col items-center">
                                                                <span class="text-blue-600 font-semibold">-</span>
                                                                <span class="text-xs text-blue-500 mt-0.5">Oczekiwanie</span>
                                                            </div>
                                                        @else
                                                            <span class="text-gray-400">-</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-3 text-center text-sm border-r border-gray-200">
                                                        @if($session->end_time)
                                                            <div class="font-semibold {{ $session->has_overtime ? 'text-green-700' : 'text-gray-900' }}">
                                                                {{ intval($session->duration - 480) ?? '-' }} min
                                                            </div>
                                                        @else
                                                            <span class="text-gray-400">-</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-3 text-center">
                                                        <div class="flex flex-col items-center gap-1">
                                                            @php
                                                                $statusName = $session->workStatus->name ?? '-';
                                                                $isCompleted = $session->end_time !== null;
                                                                
                                                                // Logika wyświetlania statusu zgodna z modelem WorkSession
                                                                if ($isCompleted && $statusName === 'Obecny') {
                                                                    $displayStatus = 'Obecny (zakończył pracę)';
                                                                } else {
                                                                    $displayStatus = $statusName;
                                                                }
                                                            @endphp
                                                            
                                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-md 
                                                                @if($isCompleted && $statusName === 'Obecny') bg-green-100 text-green-800
                                                                @elseif(!$isCompleted && $statusName === 'Obecny') bg-blue-100 text-blue-800
                                                                @elseif($statusName === 'Nieobecny') bg-red-100 text-red-800
                                                                @elseif($statusName === 'Urlop') bg-yellow-100 text-yellow-800
                                                                @elseif($statusName === 'L4') bg-purple-100 text-purple-800
                                                                @else bg-gray-100 text-gray-800
                                                                @endif">
                                                                {{ $displayStatus }}
                                                            </span>
                                                            
                                                            @if($session->notes)
                                                                <div class="text-xs text-gray-500 italic max-w-xs truncate" title="{{ $session->notes }}">
                                                                    📝 {{ $session->notes }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="{{ $rowClass }} border-b border-gray-200">
                                                <td class="px-4 py-3 text-center border-r border-gray-300">
                                                    <div class="text-sm font-bold {{ $textClass }}">
                                                        {{ $day['date']->format('d.m.Y') }}
                                                    </div>
                                                    @if($day['isHoliday'])
                                                        <div class="text-xs text-red-600 font-semibold mt-1">
                                                            {{ $day['holidayName'] }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 text-center text-sm font-medium {{ $textClass }} border-r border-gray-300">
                                                    {{ ucfirst($day['dayName']) }}
                                                </td>
                                                <td class="px-4 py-3 text-center text-sm text-gray-400 border-r border-gray-200">-</td>
                                                <td class="px-4 py-3 text-center text-sm text-gray-400 border-r border-gray-200">-</td>
                                                <td class="px-4 py-3 text-center text-sm text-gray-400 border-r border-gray-200">-</td>
                                                <td class="px-4 py-3 text-center text-sm text-gray-400 border-r border-gray-200">-</td>
                                                <td class="px-4 py-3 text-center text-sm text-gray-400">-</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gradient-to-r from-gray-100 to-gray-200">
                                    <tr class="border-t-2 border-gray-400">
                                        <td colspan="4" class="px-4 py-3 text-right text-xs font-semibold text-gray-700 uppercase">
                                            Czas standardowy:
                                        </td>
                                        <td class="px-4 py-3 text-center text-sm font-bold text-gray-900">
                                            {{ $this->formatMinutes($standardMinutes) }}
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="px-4 py-3 text-right text-xs font-semibold text-gray-700 uppercase">
                                            Nadgodziny:
                                        </td>
                                        <td class="px-4 py-3 text-center text-sm font-bold text-green-700">
                                            {{ $this->formatMinutes($overtimeMinutes) }}
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr class="border-t border-gray-300">
                                        <td colspan="4" class="px-4 py-4 text-right text-sm font-bold text-gray-900 uppercase">
                                            Suma za miesiąc:
                                        </td>
                                        <td class="px-4 py-4 text-center text-base font-bold text-blue-600">
                                            {{ $this->formatMinutes($monthMinutes) }}
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

