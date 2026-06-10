<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNikEmailAlamatToEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
{
    Schema::table('employees', function (Blueprint $table) {
        $table->string('nik')->nullable();
        $table->string('email')->nullable();
        $table->text('alamat')->nullable();
    });
}

public function down(): void
{
    Schema::table('employees', function (Blueprint $table) {
        $table->dropColumn([
            'nik',
            'email',
            'alamat'
        ]);
    });
}
}
