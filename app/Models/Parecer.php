<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parecer extends Model
{
    use HasFactory;

    protected $table = 'pareceres';

    // Um parecer pertence a uma demanda
    public function demanda()
    {
        return $this->belongsTo(Demanda::class, 'demanda_id');
    }

    // Um parecer é dado por um usuário
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
