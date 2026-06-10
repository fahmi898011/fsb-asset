<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users'); // Siapa yang mengubah (Actor)
            
            $table->string('action'); // CREATE, UPDATE, MUTATION, DISPOSAL
            $table->text('description'); // Keterangan detail perubahan
            
            $table->timestamp('created_at')->useCurrent(); // Cukup created_at saja
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asset_histories');
    }
}
