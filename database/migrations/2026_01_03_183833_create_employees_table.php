<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Buat Tabel Pegawai
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 20)->unique()->nullable(); // Nomor Induk Pegawai
            $table->string('name'); // Nama (Misal: Asep)
            $table->string('position'); // Jabatan (Misal: Marketing, Teller)
            $table->string('department'); // Divisi (Misal: Bisnis, Operasional)
            $table->string('phone')->nullable();
            $table->boolean('is_active')->default(true); // Status aktif pegawai
            $table->timestamps();
        });

        // 2. Update Tabel Assets (Ganti user_id jadi employee_id)
        Schema::table('assets', function (Blueprint $table) {
            // Hapus foreign key user_id yang lama (karena kita ganti konsep)
            // Pastikan Anda backup data jika ini aplikasi live. 
            // Untuk dev, kita drop kolomnya.
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            // Tambah kolom baru employee_id
            $table->foreignId('employee_id')->nullable()->after('room_id')->constrained('employees')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Rollback logic
        Schema::table('assets', function (Blueprint $table) {
            $table->dropForeign(['employee_id']);
            $table->dropColumn('employee_id');
            $table->foreignId('user_id')->nullable()->constrained('users');
        });
        Schema::dropIfExists('employees');
    }
}
