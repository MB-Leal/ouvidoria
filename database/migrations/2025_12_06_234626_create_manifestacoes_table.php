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
        Schema::create('manifestacoes', function (Blueprint $table) {
            $table->id();
            $table->string('protocolo')->unique(); // FASPM-2024-000001
            $table->foreignId('tipo_manifestacao_id')->constrained('tipos_manifestacao');
            $table->string('nome');
            $table->string('email');
            $table->string('telefone')->nullable();
            $table->text('descricao');
            $table->enum('status', [
                'ABERTO', 
                'EM_ANALISE', 
                'RESPONDIDO', 
                'FINALIZADO'
            ])->default('ABERTO');
            $table->enum('canal', [
                'WEB', 
                'EMAIL', 
                'TELEFONE', 
                'PRESENCIAL'
            ])->default('WEB');
            $table->string('anexo_path')->nullable();
            $table->text('resposta')->nullable();
            $table->timestamp('respondido_em')->nullable();
            $table->text('observacao_interna')->nullable();
            $table->timestamps();
            
            $table->index('protocolo');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manifestacoes');
    }
};
