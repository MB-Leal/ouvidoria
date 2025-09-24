<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tipos_demanda', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 50)->unique();
            $table->string('slug', 50)->unique(); // Adicione esta linha
            $table->text('descricao')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipos_demanda');
    }
};