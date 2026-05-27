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
        Schema::create('notificacoes', function (Blueprint $table) {
            $table->id();
            $table->string('raiz');
            $table->string('usuario_id');
            $table->boolean('lido')->default(false);
            $table->string('titulo');
            $table->text('mensagem');
            $table->string('remetente')->nullable();
            $table->datetime('data_envio');
            $table->datetime('data_leituira')->nullable();
            $table->datetime('data_re_envio')->nullable();
            $table->boolean('favorito')->default(false);
            $table->boolean('enviar_email')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificacoes');
    }
};
