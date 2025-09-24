<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaleConosco extends Model
{
    use HasFactory;

    protected $table = 'fale_conosco';

    protected $fillable = [
        'nome',
        'email',
        'assunto',
        'mensagem',
    ];
}
