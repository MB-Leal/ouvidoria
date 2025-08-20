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
        Schema::create('pareceres', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('demanda_id');
        $table->unsignedBigInteger('usuario_id');
        $table->text('parecer');
        $table->timestamps();

        $table->foreign('demanda_id')->references('id')->on('demandas')->onDelete('cascade');
        $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pareceres');
    }
};
