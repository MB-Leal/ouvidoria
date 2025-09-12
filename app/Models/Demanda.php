<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demanda extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'demandas';

    // Uma demanda pertence a um tipo (ex: Elogio, Sugestão)
    public function tipo()
    {
        return $this->belongsTo(TipoDemanda::class, 'tipo_id');
    }

    // Uma demanda pode ter muitos pareceres (respostas)
    public function pareceres()
    {
        return $this->hasMany(Parecer::class, 'demanda_id');
    }
}
