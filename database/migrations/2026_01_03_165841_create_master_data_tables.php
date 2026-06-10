<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterDataTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Master Kategori
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique(); // Contoh: ELK
            $table->string('name'); // Contoh: Elektronik
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 2. Master Ruangan
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique(); // Contoh: R01
            $table->string('name'); // Contoh: Ruang Server
            $table->string('location')->nullable(); // Contoh: Lantai 2
            $table->text('description')->nullable();
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
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('categories');
    }
}
