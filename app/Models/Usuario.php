<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'usuarios';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Um usuário pode ter muitos perfis (Administrador, Ouvidor, Secretário)
    public function perfis()
    {
        return $this->belongsToMany(Perfil::class, 'usuario_perfil', 'usuario_id', 'perfil_id');
    }
}
