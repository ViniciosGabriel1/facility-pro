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
        Schema::create('servicos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('clinica_id')
                ->constrained('clinicas')
                ->cascadeOnDelete();

            $table->string('nome');
            $table->text('descricao')->nullable();

            $table->unsignedSmallInteger('tempo_medio_minutos')->nullable();

            $table->boolean('ativo')->default(true);

            $table->timestamps();

            // evita serviços duplicados na mesma clínica
            $table->unique(['clinica_id', 'nome']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicos');
    }
};
