<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MasterDataSeeder extends Seeder
{
    public function run()
    {
        // 1. Matikan Foreign Key Check
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 2. Kosongkan Tabel
        DB::table('categories')->truncate();
        DB::table('rooms')->truncate();

        $now = Carbon::now();

        // ==========================================
        // DATA KATEGORI (Dengan Kode)
        // ==========================================
        $categories = [
            ['code' => 'IT',   'name' => 'Elektronik & IT',      'created_at' => $now, 'updated_at' => $now],
            ['code' => 'FUR',  'name' => 'Furniture & Meubel',   'created_at' => $now, 'updated_at' => $now],
            ['code' => 'MSN',  'name' => 'Mesin Perbankan',      'created_at' => $now, 'updated_at' => $now], // Mesin hitung uang
            ['code' => 'VH',   'name' => 'Kendaraan Dinas',      'created_at' => $now, 'updated_at' => $now], // Vehicle
            ['code' => 'OFF',  'name' => 'Peralatan Kantor',     'created_at' => $now, 'updated_at' => $now], // AC, Dispenser
            ['code' => 'SEC',  'name' => 'Keamanan (Security)',  'created_at' => $now, 'updated_at' => $now], // CCTV, Brankas
            ['code' => 'LOG',  'name' => 'Alat Tulis & Logistik','created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('categories')->insert($categories);
        $this->command->info('Data Kategori (Code + Name) berhasil diinput!');

        // ==========================================
        // DATA RUANGAN (Dengan Kode Lokasi)
        // ==========================================
        $rooms = [
            ['code' => 'LBY', 'name' => 'Lobby & Banking Hall',      'created_at' => $now, 'updated_at' => $now],
            ['code' => 'TLR', 'name' => 'Area Teller',               'created_at' => $now, 'updated_at' => $now],
            ['code' => 'CS',  'name' => 'Area Customer Service',     'created_at' => $now, 'updated_at' => $now],
            ['code' => 'OPS', 'name' => 'Back Office (Operasional)', 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'KHS', 'name' => 'Ruang Khasanah (Vault)',    'created_at' => $now, 'updated_at' => $now],
            ['code' => 'DIR', 'name' => 'Ruang Direksi / Pimpinan',  'created_at' => $now, 'updated_at' => $now],
            ['code' => 'MTG', 'name' => 'Ruang Rapat (Meeting)',     'created_at' => $now, 'updated_at' => $now],
            ['code' => 'SRV', 'name' => 'Ruang Server (IT)',         'created_at' => $now, 'updated_at' => $now],
            ['code' => 'MKT', 'name' => 'Ruang Marketing / AO',      'created_at' => $now, 'updated_at' => $now],
            ['code' => 'ARS', 'name' => 'Gudang Arsip',              'created_at' => $now, 'updated_at' => $now],
            ['code' => 'PAN', 'name' => 'Pantry & Dapur',            'created_at' => $now, 'updated_at' => $now],
            ['code' => 'MUS', 'name' => 'Mushola',                   'created_at' => $now, 'updated_at' => $now],
            ['code' => 'SEC', 'name' => 'Pos Satpam',                'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('rooms')->insert($rooms);
        $this->command->info('Data Ruangan (Code + Name) berhasil diinput!');

        // 3. Nyalakan Foreign Key Check
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}