<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

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
    'sigilo_dados', 
    'assunto', 
    'descricao', 
    'status', 
    'updated_by', 
    'archived_by',
    'canal', 
    'prioridade', 
    'setor_responsavel', 
    'tags', 
    'anexo_path', 
    'resposta',
    'respondido_em', 
    'data_limite_resposta', 
    'data_resposta', 
    'data_entrada',
    'data_registro_sistema', 
    'observacao_interna', 
    'arquivado_em', 
    'motivo_arquivamento'
];

protected $casts = [
        'sigilo_dados' => 'boolean',
        'data_entrada' => 'datetime',
        'data_registro_sistema' => 'datetime',
        'respondido_em' => 'datetime',
        'arquivado_em' => 'datetime',
        'data_limite_resposta' => 'date',
        'data_resposta' => 'datetime',
        'tags' => 'array',
    ];

// Relacionamentos para auditoria
public function editor() {
    return $this->belongsTo(User::class, 'updated_by')->withDefault(['name' => 'N/A']);
}

public function arquivador() {
    return $this->belongsTo(User::class, 'archived_by')->withDefault(['name' => 'N/A']);
}

public function responsavel() {
    return $this->belongsTo(User::class, 'user_id')->withDefault(['name' => 'Sistema/Web']);
}

    
    public function tipo()
    {
        return $this->belongsTo(TipoManifestacao::class, 'tipo_manifestacao_id');
    }    

    /*
    |--------------------------------------------------------------------------
    | Acessores (Formatadores de Dados)
    |--------------------------------------------------------------------------
    */

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

    /**
     * Calcula dias restantes baseado na data limite.
     * Retorna número positivo para dias restantes e negativo para atraso.
     */
    public function getDiasRestantesAttribute()
    {
        if (!$this->data_limite_resposta) {
            return null;
        }

        $hoje = now()->startOfDay();
        $limite = Carbon::parse($this->data_limite_resposta)->startOfDay();

        return (int) $hoje->diffInDays($limite, false);
    }

    /*
    |--------------------------------------------------------------------------
    | Escopos de Busca (Scopes)
    |--------------------------------------------------------------------------
    */

    public function scopeNaoArquivadas($query)
    {
        return $query->whereNull('arquivado_em');
    }

    public function scopeAtribuidas($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

protected static function booted()
{
    static::creating(function ($manifestacao) {
        $tipo = \App\Models\TipoManifestacao::find($manifestacao->tipo_manifestacao_id);
        if ($tipo) {
            $dataBase = $manifestacao->data_entrada ? \Carbon\Carbon::parse($manifestacao->data_entrada) : now();
            if (!$manifestacao->data_limite_resposta) {
                $manifestacao->data_limite_resposta = $dataBase->addDays($tipo->prazo_dias);
            }
        }
    });
}
}