<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();

            // Clínica dona da consulta
            $table->foreignId('clinica_id')
                ->constrained('clinicas')
                ->cascadeOnDelete();

            // Paciente atendido
            $table->foreignId('paciente_id')
                ->constrained('pacientes')
                ->cascadeOnDelete();

            // Dentista responsável
            $table->foreignId('dentista_id')
                ->constrained('dentistas')
                ->cascadeOnDelete();

            // Data e hora da consulta (marcada ou chegada)
            $table->dateTime('data_hora');

            // Status do fluxo
            $table->string('status')->default('aguardando');
            /**
             * aguardando
             * em_atendimento
             * finalizada
             * cancelada
             */

            // Observações opcionais
            $table->text('observacoes')->nullable();

            $table->timestamps();

            // Índice útil para fila por clínica
            $table->index(['clinica_id', 'data_hora']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};
