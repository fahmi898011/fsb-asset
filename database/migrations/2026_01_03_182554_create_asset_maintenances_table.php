<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetMaintenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users'); // Siapa yang input (GA)
            
            $table->date('maintenance_date');
            $table->string('type'); // Servis Rutin, Perbaikan Rusak, Ganti Sparepart
            $table->decimal('cost', 15, 2)->default(0); // Biaya
            $table->string('vendor')->nullable(); // Nama Bengkel / Teknisi
            $table->text('description'); // Rincian pengerjaan
            $table->string('invoice_path')->nullable(); // Upload Nota Servis
            
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
        Schema::dropIfExists('asset_maintenances');
    }
}
