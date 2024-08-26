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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cpf')->unique();
            $table->string('numero_telefone');
            $table->string('email')->unique();
            $table->date('data_nascimento');
            $table->string('tipo_carteira')->nullable();
            $table->string('numero_carteira')->nullable();
            $table->decimal('saldo_carteira', 10, 2)->default(0.00);
            $table->string('foto_perfil')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
