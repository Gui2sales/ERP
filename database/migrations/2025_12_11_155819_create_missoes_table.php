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
        Schema::create('missoes', function (Blueprint $table) {
            $table->id();
            $table->string('chamado');
            $table->string('solicitante');
            $table->text('descricao')->nullable();
            $table->string('sistema');
            $table->string('status');
            $table->string('tipo');
            $table->string('prioridade');
            $table->string('colaborador');
            $table->integer('area');
            $table->date('abertura');
            $table->date('encerramento')->nullable();
            $table->date('vencimento')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('missoes');
    }
};
