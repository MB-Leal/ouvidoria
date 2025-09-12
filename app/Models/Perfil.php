<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;

    protected $table = 'perfis';

    // Um perfil pode ser associado a muitos usuários
    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'usuario_perfil', 'perfil_id', 'usuario_id');
    }
}
