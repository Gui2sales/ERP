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
        Schema::create('banco_talentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 55);
            $table->string('cpf', 11)->nullable();
            $table->string('numero', 11);
            $table->string('email', 80)->nullable();
            $table->string('linkedin', 80)->nullable();
            $table->date('nascimento')->nullable();
            $table->string('uf', 2)->nullable();
            $table->string('estado', 45)->nullable();
            $table->string('cidade', 45)->nullable();
            $table->string('endereco', 80)->nullable();
            $table->string('municipio', 40)->nullable();
            $table->string('cep', 8)->nullable();
            $table->string('cargo_de_interesse', 45)->nullable();
            $table->string('experiencia1', 45)->nullable();
            $table->string('experiencia2', 45)->nullable();
            $table->string('emprego_atual', 45)->nullable();
            $table->string('formacao1', 45)->nullable();
            $table->string('formacao2', 45)->nullable();
            $table->string('formacao3', 45)->nullable();
            $table->text('obs')->nullable();
            $table->float('nota_entrevista', 2, 2)->nullable();
            $table->string('recrutador', 50)->nullable();
            $table->string('origem_capitacao', 20)->nullable();
            $table->string('documentos', 20)->nullable();
            $table->boolean('flag_sigilo')->default(false);
            $table->string('fase_processo', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banco_talentos');
    }
};
