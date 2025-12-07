<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Manifestacao extends Model
{
    use HasFactory;

    protected $table = 'manifestacoes';

    protected $fillable = [
        'protocolo',
        'tipo_manifestacao_id',
        'nome',
        'email',
        'telefone',
        'descricao',
        'status',
        'canal',
        'anexo_path',
        'resposta',
        'respondido_em',
        'observacao_interna'
    ];

    protected $casts = [
        'respondido_em' => 'datetime',
    ];

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
}