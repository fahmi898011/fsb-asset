<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // 1. Admin IT
        DB::table('users')->insert([
            'name' => 'Fahmi Ardiansyah',
            'username' => 'fahmi',
            'email' => 'fahmi@fsb.co.id',
            'password' => Hash::make('apple'), // Default password
            'role' => 'admin',
            'created_at' => now(),
        ]);

        // 2. Staff GA
        DB::table('users')->insert([
            'name' => 'Staf Umum',
            'username' => 'umum',
            'email' => 'ga@fsb.co.id',
            'password' => Hash::make('12345'),
            'role' => 'ga',
            'created_at' => now(),
        ]);

        // 3. Staff AUDIT
        DB::table('users')->insert([
            'name' => 'Staff Audit',
            'username' => 'audit',
            'email' => 'sa@fsb.co.id',
            'password' => Hash::make('12345'),
            'role' => 'auditor',
            'created_at' => now(),
        ]);
    }
}