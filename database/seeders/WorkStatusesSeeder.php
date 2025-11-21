<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('work_statuses')->insert([
            'name' => 'Obecny',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('work_statuses')->insert([
            'name' => 'Nieobecny',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('work_statuses')->insert([
            'name' => 'Urlop wypoczynkowy',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('work_statuses')->insert([
            'name' => 'Zwolnienie Lekarskie',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('work_statuses')->insert([
            'name' => 'Wyjazd służbowy',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('work_statuses')->insert([
            'name' => 'Nieobecny z zgody',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
