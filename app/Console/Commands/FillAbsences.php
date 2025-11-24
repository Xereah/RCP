<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Personel;
use App\Models\WorkSession;
use App\Models\WorkStatus;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class FillAbsences extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'work:fill-absences {--date= : Data do sprawdzenia (format: YYYY-MM-DD)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uzupełnia nieobecności dla pracowników, którzy nie mają zapisanej sesji pracy';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🕐 Rozpoczynam uzupełnianie nieobecności...');
        
        // Pobierz datę do sprawdzenia
        $checkDate = $this->option('date')
            ? Carbon::parse($this->option('date'))
            : Carbon::yesterday();
        
        $this->info("📅 Sprawdzam nieobecności dla daty: {$checkDate->format('Y-m-d')}");
        
        // Sprawdź czy to weekend (sobota lub niedziela)
        if ($checkDate->isWeekend()) {
            $this->comment('⏭️  Weekend - pomijam uzupełnianie nieobecności');
            return self::SUCCESS;
        }
        
        // Pobierz status "Nieobecny"
        $absentStatus = WorkStatus::where('name', 'Nieobecny')->first();
        
        if (!$absentStatus) {
            $this->error('❌ Nie znaleziono statusu "Nieobecny" w bazie danych!');
            return self::FAILURE;
        }
        
        // Pobierz wszystkich aktywnych pracowników
        $activePersonels = Personel::where('is_active', true)->get();
        
        if ($activePersonels->isEmpty()) {
            $this->comment('⚠️  Brak aktywnych pracowników w systemie');
            return self::SUCCESS;
        }
        
        $this->info("👥 Znaleziono {$activePersonels->count()} aktywnych pracowników");
        
        $created = 0;
        $skipped = 0;
        
        // Utwórz progress bar
        $progressBar = $this->output->createProgressBar($activePersonels->count());
        $progressBar->start();
        
        foreach ($activePersonels as $personel) {
            // Sprawdź czy pracownik ma już sesję pracy na ten dzień
            $existingSession = WorkSession::where('personel_id', $personel->id)
                ->whereDate('work_date', $checkDate)
                ->exists();
            
            if (!$existingSession) {
                // Utwórz sesję z nieobecnością
                try {
                    WorkSession::create([
                        'personel_id' => $personel->id,
                        'work_date' => $checkDate->format('Y-m-d'),
                        'start_time' => null,
                        'end_time' => null,
                        'duration' => null,
                        'status_id' => $absentStatus->id,
                        'notes' => 'Automatycznie uzupełniona nieobecność',
                    ]);
                    
                    $created++;
                } catch (\Exception $e) {
                    $this->newLine();
                    $this->error("❌ Błąd przy tworzeniu sesji dla pracownika {$personel->personal_number}: {$e->getMessage()}");
                }
            } else {
                $skipped++;
            }
            
            $progressBar->advance();
        }
        
        $progressBar->finish();
        $this->newLine(2);
        
        // Podsumowanie
        $this->info('✅ Zakończono uzupełnianie nieobecności:');
        $this->table(
            ['Kategoria', 'Liczba'],
            [
                ['Utworzone nieobecności', $created],
                ['Pominięte (mają sesję)', $skipped],
                ['Razem pracowników', $activePersonels->count()],
            ]
        );
        
        if ($created > 0) {
            $this->info("✨ Pomyślnie utworzono {$created} zapisów nieobecności");
        } else {
            $this->comment('ℹ️  Nie utworzono żadnych nowych zapisów');
        }
        
        return self::SUCCESS;
    }
}

