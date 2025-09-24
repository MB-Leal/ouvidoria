<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('fale_conosco', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email');
            $table->string('assunto');
            $table->text('mensagem');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fale_conosco');
    }
};