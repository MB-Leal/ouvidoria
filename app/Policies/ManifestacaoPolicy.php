<?php

namespace App\Policies;

use App\Models\Manifestacao;
use App\Models\User;

class ManifestacaoPolicy
{
    public function view(User $user, Manifestacao $manifestacao): bool
    {
        // Admin pode ver tudo
        if ($user->isAdmin()) {
            return true;
        }

        // Ouvidor e secretário podem ver se estão atribuídos ou se não tem responsável
        return $manifestacao->user_id === null || $manifestacao->user_id === $user->id;
    }

    public function update(User $user, Manifestacao $manifestacao): bool
    {
        // Admin pode editar tudo
        if ($user->isAdmin()) {
            return true;
        }

        // Ouvidor pode editar se estiver atribuído a ele
        if ($user->isOuvidor()) {
            return $manifestacao->user_id === $user->id;
        }

        // Secretário só pode editar se estiver atribuído e não for respondido
        if ($user->isSecretario()) {
            return $manifestacao->user_id === $user->id && $manifestacao->status !== 'RESPONDIDO';
        }

        return false;
    }

    public function atribuir(User $user): bool
    {
        // Apenas admin e ouvidor podem atribuir
        return $user->isAdmin() || $user->isOuvidor();
    }

    public function arquivar(User $user): bool
    {
        // Apenas admin e ouvidor podem arquivar
        return $user->isAdmin() || $user->isOuvidor();
    }
}