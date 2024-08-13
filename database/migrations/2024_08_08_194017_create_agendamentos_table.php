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
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            $table->date('dia_agendamento');
            $table->time('hora_agendamento');
            $table->string('tipo_carteira');
            $table->string('local');
            $table->unsignedBigInteger('cliente_id');
            $table->string('cliente_nome');
            $table->string('cliente_cpf');
            $table->string('cliente_numero');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendamentos');
    }
};
