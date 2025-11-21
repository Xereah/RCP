<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('position')->insert([           
            'name' => 'Dyrektor',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('position')->insert([           
            'name' => 'Zastępca Dyrektora',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('position')->insert([           
            'name' => 'Główny Księgowy',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('position')->insert([           
            'name' => 'Kierownik',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('position')->insert([           
            'name' => 'Starszy Inspektor',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('position')->insert([           
            'name' => 'Inspektor',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('position')->insert([           
            'name' => 'Z-ca Kierownika',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('position')->insert([           
            'name' => 'Starszy Specjalista',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('position')->insert([           
            'name' => 'Asystent',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('position')->insert([           
            'name' => 'p.o. Kierownik',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('position')->insert([           
            'name' => 'Starszy Geodeta',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('position')->insert([           
            'name' => 'Geodeta',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('position')->insert([           
            'name' => 'Klasyfikator Gleb',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('position')->insert([           
            'name' => 'Podinspektor',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('position')->insert([           
            'name' => 'Główny Specjalista',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('position')->insert([           
            'name' => 'Młodszy Geodeta',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('position')->insert([           
            'name' => 'Starszy Pomiarowy',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('position')->insert([           
            'name' => 'Geodeta - Specjalista ds. Rozwoju Obszarów Wiejskich',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('position')->insert([           
            'name' => 'Podinspektor',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('position')->insert([           
            'name' => 'Adwokat',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('position')->insert([           
            'name' => 'Główny Specjalista ds. BHP i Ppoż',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
