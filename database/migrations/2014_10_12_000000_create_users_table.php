<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique(); // Ganti email jadi username
            $table->string('email')->nullable(); // Opsional, buat kontak saja
            $table->string('password');
            $table->string('role', 20)->default('ga'); // admin, ga, auditor
            $table->boolean('is_active')->default(true); // Untuk blokir user tanpa hapus
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
