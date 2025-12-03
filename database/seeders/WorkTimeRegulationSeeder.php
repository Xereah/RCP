<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkTimeRegulationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regulations = [
            [
                'name' => 'Pełny etat (8h)',
                'code' => 'FULL_TIME',
                'description' => 'Standardowy pełny etat - 8 godzin dziennie, 40 godzin tygodniowo zgodnie z Kodeksem Pracy',
                'daily_hours' => 8.00,
                'weekly_hours' => 40.00,
                'monthly_hours' => 160.00,
                'is_task_based' => false,
                'break_minutes' => 15,
                'nursing_mother_break' => 0,
                'start_time_flex' => 0,
                'end_time_flex' => 0,
                'is_active' => true,
            ],
            [
                'name' => '3/4 etatu (6h)',
                'code' => 'THREE_QUARTER_TIME',
                'description' => 'Trzy czwarte etatu - 6 godzin dziennie, 30 godzin tygodniowo',
                'daily_hours' => 6.00,
                'weekly_hours' => 30.00,
                'monthly_hours' => 120.00,
                'is_task_based' => false,
                'break_minutes' => 15,
                'nursing_mother_break' => 0,
                'start_time_flex' => 0,
                'end_time_flex' => 0,
                'is_active' => true,
            ],
            [
                'name' => '1/2 etatu (4h)',
                'code' => 'HALF_TIME',
                'description' => 'Pół etatu - 4 godziny dziennie, 20 godzin tygodniowo',
                'daily_hours' => 4.00,
                'weekly_hours' => 20.00,
                'monthly_hours' => 80.00,
                'is_task_based' => false,
                'break_minutes' => 0,
                'nursing_mother_break' => 0,
                'start_time_flex' => 0,
                'end_time_flex' => 0,
                'is_active' => true,
            ],
            [
                'name' => '1/4 etatu (2h)',
                'code' => 'QUARTER_TIME',
                'description' => 'Ćwierć etatu - 2 godziny dziennie, 10 godzin tygodniowo',
                'daily_hours' => 2.00,
                'weekly_hours' => 10.00,
                'monthly_hours' => 40.00,
                'is_task_based' => false,
                'break_minutes' => 0,
                'nursing_mother_break' => 0,
                'start_time_flex' => 0,
                'end_time_flex' => 0,
                'is_active' => true,
            ],
            [
                'name' => 'Matka karmiąca (7h)',
                'code' => 'NURSING_MOTHER',
                'description' => 'Regulamin dla matki karmiącej - 7 godzin pracy (8h minus 2x30min przerw karmiących wliczanych do czasu pracy)',
                'daily_hours' => 7.00,
                'weekly_hours' => 35.00,
                'monthly_hours' => 140.00,
                'is_task_based' => false,
                'break_minutes' => 15,
                'nursing_mother_break' => 60, // 2x30min
                'start_time_flex' => 0,
                'end_time_flex' => 0,
                'is_active' => true,
            ],
            [
                'name' => 'Zadaniowy czas pracy',
                'code' => 'TASK_BASED',
                'description' => 'Zadaniowy system czasu pracy dla kierowników i osób zarządzających zgodnie z art. 140 KP',
                'daily_hours' => 8.00,
                'weekly_hours' => 40.00,
                'monthly_hours' => null,
                'is_task_based' => true,
                'break_minutes' => 0,
                'nursing_mother_break' => 0,
                'start_time_flex' => 0,
                'end_time_flex' => 0,
                'is_active' => true,
            ],
            [
                'name' => 'Ruchomy czas pracy (8h)',
                'code' => 'FLEXIBLE_TIME',
                'description' => 'Ruchomy czas pracy z elastycznymi godzinami rozpoczęcia i zakończenia zgodnie z art. 140¹ KP',
                'daily_hours' => 8.00,
                'weekly_hours' => 40.00,
                'monthly_hours' => 160.00,
                'is_task_based' => false,
                'break_minutes' => 15,
                'nursing_mother_break' => 0,
                'start_time_flex' => 60, // ±1h
                'end_time_flex' => 60, // ±1h
                'is_active' => true,
            ],
            [
                'name' => 'Skrócony tydzień (7h)',
                'code' => 'REDUCED_WEEK',
                'description' => 'Skrócony tydzień pracy - 7 godzin dziennie, 35 godzin tygodniowo',
                'daily_hours' => 7.00,
                'weekly_hours' => 35.00,
                'monthly_hours' => 140.00,
                'is_task_based' => false,
                'break_minutes' => 15,
                'nursing_mother_break' => 0,
                'start_time_flex' => 0,
                'end_time_flex' => 0,
                'is_active' => true,
            ],
            [
                'name' => 'Praca dorywcza',
                'code' => 'OCCASIONAL_WORK',
                'description' => 'Praca dorywcza - do 10 dni w roku kalendarzowym, bez określonego wymiaru',
                'daily_hours' => 8.00,
                'weekly_hours' => 40.00,
                'monthly_hours' => null,
                'is_task_based' => false,
                'break_minutes' => 15,
                'nursing_mother_break' => 0,
                'start_time_flex' => 0,
                'end_time_flex' => 0,
                'is_active' => true,
            ],
        ];

        foreach ($regulations as $regulation) {
            DB::table('work_time_regulations')->insert([
                'name' => $regulation['name'],
                'code' => $regulation['code'],
                'description' => $regulation['description'],
                'daily_hours' => $regulation['daily_hours'],
                'weekly_hours' => $regulation['weekly_hours'],
                'monthly_hours' => $regulation['monthly_hours'],
                'is_task_based' => $regulation['is_task_based'],
                'break_minutes' => $regulation['break_minutes'],
                'nursing_mother_break' => $regulation['nursing_mother_break'],
                'start_time_flex' => $regulation['start_time_flex'],
                'end_time_flex' => $regulation['end_time_flex'],
                'is_active' => $regulation['is_active'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

