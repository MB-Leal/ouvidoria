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
        Schema::create('tipos_manifestacao', function (Blueprint $table) {
            $table->id();
            $table->string('nome'); // Reclamação, Elogio, Sugestão, Denúncia
            $table->string('cor')->default('#007bff'); // Cor para exibição
            $table->integer('prazo_dias')->default(30);
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_manifestacao');
    }
};
