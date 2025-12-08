<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Verificar se o usuário tem um dos roles permitidos
        if (!in_array($user->role, $roles)) {
            abort(403, 'Acesso não autorizado. Você não tem permissão para acessar esta área.');
        }

        return $next($request);
    }
}