<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {       
        DB::table('roles')->insert([           
            'name' => 'Super Admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('roles')->insert([           
            'name' => 'Admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('roles')->insert([           
            'name' => 'Accountant',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password123'),
            'role_id' => 1, 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
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
