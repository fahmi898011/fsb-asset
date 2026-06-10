<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Header Sesi Opname
        Schema::create('audit_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Contoh: Opname Q1 2025
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->foreignId('user_id')->constrained('users'); // Auditor
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 2. Detail Hasil Scan
        Schema::create('audit_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('audit_session_id')->constrained('audit_sessions')->onDelete('cascade');
            $table->foreignId('asset_id')->constrained('assets');
            
            // Status saat dicek
            $table->enum('status', ['match', 'moved', 'unregistered'])->default('match'); 
            $table->text('note')->nullable(); // Catatan auditor (misal: "Kondisi fisik baret")
            $table->timestamp('scanned_at')->useCurrent();
            
            // Mencegah duplikasi scan aset yang sama di satu sesi
            $table->unique(['audit_session_id', 'asset_id']); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_results');
        Schema::dropIfExists('audit_sessions');
    }
}
