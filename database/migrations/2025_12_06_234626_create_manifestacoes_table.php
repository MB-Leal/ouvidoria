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
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('protocolo')->unique(); // FASPM-2024-000001
            $table->foreignId('tipo_manifestacao_id')->constrained('tipos_manifestacao');
            $table->string('nome');
            $table->string('email');
            $table->string('telefone')->nullable();
            $table->boolean('sigilo_dados')->default(false);
            $table->string('assunto')->nullable();
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
                'PRESENCIAL',
                'WHATSAPP'
            ])->default('WEB');
            $table->string('anexo_path')->nullable();
            $table->text('resposta')->nullable();
            $table->timestamp('respondido_em')->nullable();
            $table->date('data_limite_resposta')->nullable();
            $table->text('observacao_interna')->nullable();
            $table->timestamp('arquivado_em')->nullable();
            $table->text('motivo_arquivamento')->nullable();
            $table->timestamps();
            
            $table->index('protocolo');
            $table->index('status');
            $table->timestamp('data_entrada')->nullable();
            $table->timestamp('data_registro_sistema')->nullable();
            $table->timestamp('data_resposta')->nullable();
            $table->enum('prioridade', ['baixa', 'media', 'alta', 'urgente'])->default('media');
            $table->string('setor_responsavel')->nullable();
            $table->json('tags')->nullable();
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
