<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Auth\Access\AuthorizationException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Renderiza uma exceção HTTP em uma resposta.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // 1. TRATAMENTO PERSONALIZADO PARA ERROS 403 (AUTORIZAÇÃO E HTTP EXCEPTION)
        // O bloco irá capturar tanto a AuthorizationException (Policies) quanto a HttpException (abort(403))
        if (
            $exception instanceof AuthorizationException ||
            ($exception instanceof HttpException && $exception->getStatusCode() === 403)
        ) {

            // Verifica se a requisição é para o painel de administração (admin/*)
            if ($request->is('admin/*')) {

                // Define a mensagem personalizada
                $message = 'Você não tem permissão para editar essa manifestação.';

                // Redireciona para o dashboard com uma mensagem de erro na sessão
                return redirect()
                    ->route('admin.dashboard') // Assumindo que a rota 'admin.dashboard' existe
                    ->with('error', $message . ' Defina um responsável para continuar editando.');
            }
        }

        return parent::render($request, $exception);
    }
}
