<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDemanda extends Model
{
    use HasFactory;

    protected $table = 'tipos_demanda';

    // Um tipo de demanda pode ter muitas demandas associadas
    public function demandas()
    {
        return $this->hasMany(Demanda::class, 'tipo_id');
    }
}
