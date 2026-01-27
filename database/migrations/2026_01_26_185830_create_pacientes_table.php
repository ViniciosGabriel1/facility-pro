<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('clinica_id')
                ->constrained('clinicas')
                ->cascadeOnDelete();

            $table->string('nome');
            $table->string('telefone', 20)->nullable();
            $table->string('cpf', 14)->nullable();
            $table->text('observacoes')->nullable();

            $table->boolean('ativo')->default(true);

            $table->timestamps();

            // evita CPF duplicado dentro da mesma clínica
            $table->unique(['clinica_id', 'cpf']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
