<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'ativo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'ativo' => 'boolean',
        ];
    }

    // Métodos de verificação de role
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isOuvidor(): bool
    {
        return $this->role === 'ouvidor';
    }

    public function isSecretario(): bool
    {
        return $this->role === 'secretario';
    }

    // Verificar permissões específicas
    public function canVisualizarManifestacoes(): bool
    {
        return in_array($this->role, ['admin', 'ouvidor', 'secretario']);
    }

    public function canResponderManifestacoes(): bool
    {
        return in_array($this->role, ['admin', 'ouvidor', 'secretario']);
    }

    public function canAtribuirManifestacoes(): bool
    {
        return in_array($this->role, ['admin', 'ouvidor']);
    }

    public function canArquivarManifestacoes(): bool
    {
        return in_array($this->role, ['admin', 'ouvidor']);
    }

    public function canGerenciarUsuarios(): bool
    {
        return $this->role === 'admin';
    }

    public function canGerarRelatorios(): bool
    {
        return in_array($this->role, ['admin', 'ouvidor']);
    }

    // Helper para nome formatado do role
    public function getRoleNameAttribute(): string
    {
        return match($this->role) {
            'admin' => 'Administrador',
            'ouvidor' => 'Ouvidor',
            'secretario' => 'Secretário',
            default => 'Desconhecido'
        };
    }

    // Relação com manifestações atribuídas
    public function manifestacoesAtribuidas()
    {
        return $this->hasMany(Manifestacao::class, 'user_id');
    }
}