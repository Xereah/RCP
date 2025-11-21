<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkPlacesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('work_places')->insert([           
            'name' => 'Łódź',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('work_places')->insert([           
            'name' => 'Piotrków Trybunalski',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('work_places')->insert([           
            'name' => 'Sieradz',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
