<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_code')->unique(); // Barcode/Inventaris Number
            $table->string('name');
            
            // Foreign Keys
            $table->foreignId('category_id')->constrained('categories')->onDelete('restrict');
            $table->foreignId('room_id')->constrained('rooms')->onDelete('restrict');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // PIC
            
            // Detail Fisik & Nilai
            $table->string('condition', 50)->default('Baik'); // Baik, Rusak Ringan, Rusak Berat
            $table->date('purchase_date')->nullable();
            $table->decimal('price', 15, 2)->default(0); // Support angka triliunan
            
            // Status & Dokumen
            $table->string('status', 20)->default('active'); // active, maintenance, disposed
            $table->string('image_path')->nullable(); // Foto barang
            $table->string('document_path')->nullable(); // Nota/BAST
            $table->text('description')->nullable();
            
            $table->timestamps();
            $table->softDeletes(); // Wajib untuk audit
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets');
    }
}
