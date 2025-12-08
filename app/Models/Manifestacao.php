<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Manifestacao extends Model
{
    use HasFactory;

    protected $table = 'manifestacoes';

    protected $fillable = [
        'user_id',
        'protocolo',
        'tipo_manifestacao_id',
        'nome',
        'email',
        'telefone',
        'descricao',
        'status',
        'canal',
        'prioridade',
        'setor_responsavel',
        'tags',
        'anexo_path',
        'resposta',
        'respondido_em',
        'data_limite_resposta',
        'observacao_interna',
        'arquivado_em',
        'motivo_arquivamento'
    ];

    protected $casts = [
        'respondido_em' => 'datetime',
        'arquivado_em' => 'datetime',
        'data_limite_resposta' => 'date',
        'tags' => 'array',
    ];

    // Métodos CORRETOS (estes devem estar no Model, não na Migration)
    public function responsavel()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tipo()
    {
        return $this->belongsTo(TipoManifestacao::class, 'tipo_manifestacao_id');
    }

    // Acessor para status formatado
    public function getStatusFormatadoAttribute()
    {
        $statuses = [
            'ABERTO' => 'Aberto',
            'EM_ANALISE' => 'Em Análise',
            'RESPONDIDO' => 'Respondido',
            'FINALIZADO' => 'Finalizado'
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    // Acessor para cor do status
    public function getStatusCorAttribute()
    {
        $cores = [
            'ABERTO' => 'warning',
            'EM_ANALISE' => 'info',
            'RESPONDIDO' => 'success',
            'FINALIZADO' => 'secondary'
        ];

        return $cores[$this->status] ?? 'light';
    }

    // Acessor para cor da prioridade
    public function getPrioridadeCorAttribute()
    {
        return match ($this->prioridade) {
            'urgente' => 'danger',
            'alta' => 'warning',
            'media' => 'info',
            'baixa' => 'success',
            default => 'secondary'
        };
    }

    // Método para calcular dias restantes
    public function getDiasRestantesAttribute()
    {
        if (!$this->data_limite_resposta) {
            return null;
        }

        $hoje = now()->startOfDay();
        $limite = \Carbon\Carbon::parse($this->data_limite_resposta)->startOfDay();

        return $hoje->diffInDays($limite, false); // negativo se atrasado

    }

    // Scope para manifestações não arquivadas
    public function scopeNaoArquivadas($query)
    {
        return $query->whereNull('arquivado_em');
    }

    // Scope para manifestações atribuídas ao usuário
    public function scopeAtribuidas($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
