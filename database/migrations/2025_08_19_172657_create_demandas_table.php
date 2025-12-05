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
        Schema::create('demandas', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->nullable();
            $table->string('email')->nullable();
            $table->string('telefone', 20)->nullable();
            $table->string('assunto', 255);
            $table->unsignedBigInteger('tipo_id')->nullable();
            $table->string('protocolo', 50)->unique();
            $table->string('status', 50);
            $table->text('mensagem');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tipo_id')->references('id')->on('tipos_demanda')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandas');
    }
};
