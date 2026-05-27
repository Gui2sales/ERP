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
        Schema::create('busca_telas_index', function (Blueprint $table) {
            $table->id();
            $table->string('NOME');
            $table->string('NOME_EXIBIDO');
            $table->string('ROTA');
            $table->string('SIGLA')->nullable();
            $table->boolean('ATIVO')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('busca_telas_index');
    }
};
