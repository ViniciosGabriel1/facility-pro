<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('clinica_id')
                ->nullable()
                ->after('id')
                ->constrained('clinicas');

            $table->enum('tipo', ['secretaria', 'dentista'])
                ->after('password');

            $table->boolean('ativo')
                ->default(true)
                ->after('tipo');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['clinica_id']);
            $table->dropColumn(['clinica_id', 'tipo', 'ativo']);
        });
    }
};
