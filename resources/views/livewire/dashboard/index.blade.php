<div>   
        <div class="py-4">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Panel administracyjny</h2>                       
                           <!-- Sekcja informacji o systemie -->
                            <div class="mb-6 p-4 bg-white rounded-lg shadow-sm border border-gray-200">
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-sm text-gray-700">
                                    <div>
                                        <p class="font-semibold text-gray-900">Wersja PHP</p>
                                        <p class="text-blue-600">{{ PHP_VERSION }}</p>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">Wersja Laravela</p>
                                        <p class="text-blue-600">{{ app()->version() }}</p>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">Baza danych</p>
                                        <p class="text-blue-600">{{ DB::getDatabaseName() }}</p>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">Środowisko</p>
                                        <p class="text-blue-600">{{ app()->environment() }}</p>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">Pamięć serwera</p>
                                        <p class="text-blue-600">{{ ini_get('memory_limit') }}</p>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">Maksymalny czas wykonania</p>
                                        <p class="text-blue-600">{{ ini_get('max_execution_time') }}s</p>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">Rozmiar uploadu</p>
                                        <p class="text-blue-600">{{ ini_get('upload_max_filesize') }}</p>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">Czas serwera</p>
                                        <p class="text-blue-600">{{ now()->format('Y-m-d H:i:s') }}</p>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">Liczba tabel</p>
                                        <p class="text-blue-600">{{ count(DB::select('SHOW TABLES')) }}</p>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">Rozmiar bazy</p>
                                        <p class="text-blue-600">{{ number_format(DB::select("SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS 'DB Size in MB' FROM information_schema.tables WHERE table_schema = '" . DB::getDatabaseName() . "'")[0]->{'DB Size in MB'} ?? 0, 2) }} MB</p>
                                    </div>
                                </div>
                            </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">                        
                             <!-- Karta Eksportu SQL -->
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                                <div class="p-6">
                                    <div class="flex items-center mb-4">
                                        <div class="p-2 rounded-lg bg-blue-100">
                                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-lg font-semibold text-gray-900">Eksport SQL</h3>
                                            <p class="text-sm text-gray-500">Eksport danych do pliku SQL</p>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-4">
                                        <p class="text-sm text-gray-600">Eksportuj wszystkie dane z bazy do pliku SQL</p>
                                        <button 
                                            wire:click="export" 
                                            wire:loading.attr="disabled"
                                            class="w-full px-4 py-2 bg-blue-600 text-white font-medium rounded-lg shadow
                                            hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                                            disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center
                                            transition-colors duration-200">
                                            <span wire:loading.remove wire:target="export" class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M3 12v3c0 1.657 3.134 3 7 3s7-1.343 7-3v-3c0 1.657-3.134 3-7 3s-7-1.343-7-3z" />
                                                    <path d="M3 7v3c0 1.657 3.134 3 7 3s7-1.343 7-3V7c0 1.657-3.134 3-7 3S3 8.657 3 7z" />
                                                    <path d="M17 5c0 1.657-3.134 3-7 3S3 6.657 3 5s3.134-3 7-3 7 1.343 7 3z" />
                                                </svg>
                                                Eksportuj dane SQL
                                            </span>
                                            <span wire:loading wire:target="export" class="flex items-center">
                                                <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                Eksportowanie danych...
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Karta Logów systemu -->
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                                <div class="p-6">
                                    <div class="flex items-center mb-4">
                                        <div class="p-2 rounded-lg bg-yellow-100">
                                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-lg font-semibold text-gray-900">Logi systemu</h3>
                                            <p class="text-sm text-gray-500">Przeglądanie i zarządzanie logami aplikacji</p>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-4">
                                        <p class="text-sm text-gray-600">Wyświetl logi systemu do analizy błędów i działania aplikacji</p>
                                        <button 
                                            wire:click="toggleLogs"
                                            class="w-full px-4 py-2 bg-yellow-600 text-white font-medium rounded-lg shadow
                                            hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2
                                            transition-colors duration-200 flex items-center justify-center">
                                            <span class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                                {{ $showLogs ? 'Ukryj logi' : 'Pokaż logi' }}
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Sekcja wyświetlania logów -->
    @if($showLogs)
        <div class="py-12">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold">Logi aplikacji</h2>
                            <div class="flex gap-2">
                                <div class="flex items-center gap-2">
                                    <label class="text-sm font-medium text-gray-700">Liczba linii:</label>
                                    <select wire:model="logLines" wire:change="loadLogs" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                        <option value="200">200</option>
                                        <option value="500">500</option>
                                        <option value="1000">1000</option>
                                    </select>
                                </div>
                                <button wire:click="refreshLogs" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Odśwież
                                </button>
                                <button wire:click="downloadLogs" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Pobierz
                                </button>
                                <button wire:click="clearLogs" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Czy na pewno chcesz wyczyścić wszystkie logi?')">
                                    Wyczyść
                                </button>
                            </div>
                        </div>

                        <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                            <pre class="text-green-400 text-sm font-mono whitespace-pre-wrap">{{ $logContent ?: 'Brak logów do wyświetlenia.' }}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        @this.on('notification', (data) => {
            if (data.type === 'error') {
                Swal.fire({
                    title: 'Błąd!',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#d33'
                });
            } else if (data.type === 'success') {
                Swal.fire({
                    title: 'Sukces!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#28a745'
                });
            }
        });

        @this.on('download-logs', () => {
            // Tworzenie linku do pobrania pliku
            const link = document.createElement('a');
            link.href = '/admin/download-logs';
            link.download = 'laravel.log';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    });
</script>