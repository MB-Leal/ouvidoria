<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManifestacaoController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ManifestacaoController as AdminManifestacaoController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TipoManifestacaoController;
use App\Http\Controllers\Admin\RelatorioController;

/*
|--------------------------------------------------------------------------
| Rotas Públicas
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Manifestações - Área Pública (Adequado à LGPD)
Route::prefix('manifestacoes')->name('manifestacoes.')->group(function () {
    Route::get('/nova', [ManifestacaoController::class, 'create'])->name('create');
    Route::post('/', [ManifestacaoController::class, 'store'])->name('store');
    Route::get('/acompanhar', [ManifestacaoController::class, 'acompanhar'])->name('acompanhar');
    Route::post('/buscar', [ManifestacaoController::class, 'buscar'])->name('buscar');
    Route::get('/{manifestacao}', [ManifestacaoController::class, 'show'])->name('show');
});

/*
|--------------------------------------------------------------------------
| Rotas Administrativas (Área Restrita)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    | Gestão de Manifestações (Admin)
    */
    Route::prefix('manifestacoes')->name('manifestacoes.')->group(function () {
        Route::get('/', [AdminManifestacaoController::class, 'index'])->name('index');
        
        // Cadastro Manual (Presencial/Telefone)
        Route::get('/nova-manual', [AdminManifestacaoController::class, 'createManual'])->name('create.manual');
        Route::post('/nova-manual', [AdminManifestacaoController::class, 'storeManual'])->name('store.manual');
        
        // ROTA ADICIONADA: Notificação Manual via E-mail (Modal de Sucesso)
        Route::post('/{manifestacao}/notificar', [AdminManifestacaoController::class, 'notificarManual'])->name('notificar');

        // Visualização e Edição
        Route::get('/{manifestacao}', [AdminManifestacaoController::class, 'show'])->name('show');
        Route::get('/{manifestacao}/edit', [AdminManifestacaoController::class, 'edit'])->name('edit');
        Route::put('/{manifestacao}', [AdminManifestacaoController::class, 'update'])->name('update');
        
        // Fluxo de Trabalho
        Route::post('/{manifestacao}/atribuir', [AdminManifestacaoController::class, 'atribuir'])->name('atribuir');
        Route::post('/{manifestacao}/arquivar', [AdminManifestacaoController::class, 'arquivar'])->name('arquivar');
    });

    /*
    | Gestão de Usuários e Tipos
    */
    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('tipos', TipoManifestacaoController::class)->except(['show']);

    /*
    | Relatórios
    */
    Route::prefix('relatorios')->name('relatorios.')->group(function () {
        Route::get('/', [RelatorioController::class, 'index'])->name('index');
    });
});

/*
|--------------------------------------------------------------------------
| Rotas de Autenticação
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';