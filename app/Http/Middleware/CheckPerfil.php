<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPerfil
{
    public function handle(Request $request, Closure $next, ...$perfis): Response
    {
        // Verifica se o usuário está logado
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Verifica se o usuário tem pelo menos um dos perfis necessários
        if (!$request->user()->perfis()->whereIn('nome', $perfis)->exists()) {
            abort(403, 'Acesso não autorizado.'); // Retorna um erro 403 (Proibido)
        }

        return $next($request);
    }
}
