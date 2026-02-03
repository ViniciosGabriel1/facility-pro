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
        Schema::create('consulta_servico', function (Blueprint $table) {
            $table->id();

            $table->foreignId('consulta_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('servico_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedSmallInteger('quantidade')->default(1);

            $table->decimal('valor_unitario', 10, 2)->nullable();
            $table->decimal('subtotal', 10, 2)->nullable();

            $table->timestamps();

            $table->unique(['consulta_id', 'servico_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consulta_servico');
    }
};
