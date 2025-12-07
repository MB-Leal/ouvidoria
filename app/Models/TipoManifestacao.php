<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoManifestacao extends Model
{
    use HasFactory;

    // Especificar o nome da tabela
    protected $table = 'tipos_manifestacao';

    protected $fillable = ['nome', 'cor', 'prazo_dias', 'ativo'];
    
    public function manifestacoes()
    {
        return $this->hasMany(Manifestacao::class, 'tipo_manifestacao_id');
    }
}