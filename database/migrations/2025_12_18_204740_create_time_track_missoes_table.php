<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('time_track_missoes', function (Blueprint $table) {
            $table->id();
            $table->string('chamado_id');
            $table->string('usuario_id');
            $table->timestamp('start')->nullable();
            $table->timestamp('stop')->nullable();
            $table->string('acesso');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_track_missoes');
    }
};
