<?php

namespace App\Livewire\Dashboard;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithFileUploads;    

    public $refreshMessage = '';

    // Zmienne dla zarządzania logami
    public $showLogs = false;
    public $logContent = '';
    public $logLines = 100;
    public $logFile = 'RCP.log';

    public string $message = '';


    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.dashboard.index');
    }

    public function toggleLogs()
    {
        $this->showLogs = !$this->showLogs;
        if ($this->showLogs) {
            $this->loadLogs();
        }
    }

    public function loadLogs()
    {
        try {
            $logPath = storage_path('logs/' . $this->logFile);
            
            if (!File::exists($logPath)) {
                $this->logContent = 'Plik logów nie istnieje.';
                return;
            }

            $content = File::get($logPath);
            $lines = explode("\n", $content);
            
            // Pobierz ostatnie N linii
            $lines = array_slice($lines, -$this->logLines);
            $this->logContent = implode("\n", $lines);
            
        } catch (\Exception $e) {
            $this->logContent = 'Błąd podczas odczytu pliku logów: ' . $e->getMessage();
        }
    }

    public function clearLogs()
    {
        try {
            $logPath = storage_path('logs/' . $this->logFile);
            
            if (File::exists($logPath)) {
                File::put($logPath, '');
                $this->logContent = '';
                $this->dispatch('notification', ['message' => 'Logi zostały wyczyszczone.', 'type' => 'success']);
            }
        } catch (\Exception $e) {
            $this->dispatch('notification', ['message' => 'Błąd podczas czyszczenia logów: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function downloadLogs()
    {
        try {
            $logPath = storage_path('logs/' . $this->logFile);
            
            if (!File::exists($logPath)) {
                $this->dispatch('notification', ['message' => 'Plik logów nie istnieje.', 'type' => 'error']);
                return;
            }

            $this->dispatch('download-logs');
        } catch (\Exception $e) {
            $this->dispatch('notification', ['message' => 'Błąd podczas pobierania logów: ' . $e->getMessage(), 'type' => 'error']);
        }
    }

    public function refreshLogs()
    {
        $this->loadLogs();
        $this->dispatch('notification', ['message' => 'Logi zostały odświeżone.', 'type' => 'success']);
    }

    public function export()
    {
        $tables = DB::select('SHOW TABLES');
        $key = 'Tables_in_' . DB::getDatabaseName();
        $output = '';

        foreach ($tables as $table) {
            $tableName = $table->$key;
            
            // Pobierz wszystkie dane z tabeli
            $data = DB::table($tableName)->get();
            
            // Dodaj nagłówek tabeli
            $output .= "-- Table: {$tableName}\n";
            
            // Jeśli tabela zawiera dane, wygeneruj INSERT statements
            if ($data->isNotEmpty()) {
                $columns = array_keys((array)$data->first());
                $output .= "INSERT INTO `{$tableName}` (`" . implode('`, `', $columns) . "`) VALUES\n";
                
                $values = [];
                foreach ($data as $row) {
                    $rowValues = [];
                    foreach ($columns as $column) {
                        $value = $row->$column;
                        if ($value === null) {
                            $rowValues[] = 'NULL';
                        } else {
                            $rowValues[] = "'" . addslashes($value) . "'";
                        }
                    }
                    $values[] = "(" . implode(', ', $rowValues) . ")";
                }
                
                $output .= implode(",\n", $values) . ";\n\n";
            } else {
                $output .= "-- Table is empty\n\n";
            }
        }

        // Generuj nazwę pliku z timestampem
        $filename = 'RCP_export_' . date('Y-m-d_H-i-s') . '.sql';
        
        // Zwróć odpowiedź z plikiem do pobrania
        return response()->streamDownload(function() use ($output) {
            echo $output;
        }, $filename, [
            'Content-Type' => 'application/sql',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }
}
