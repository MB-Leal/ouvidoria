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
| Rotas acessíveis sem autenticação
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Manifestações - Área Pública
Route::prefix('manifestacoes')->name('manifestacoes.')->group(function () {
    Route::get('/nova', [ManifestacaoController::class, 'create'])->name('create');
    Route::post('/', [ManifestacaoController::class, 'store'])->name('store');
    Route::get('/acompanhar', [ManifestacaoController::class, 'acompanhar'])->name('acompanhar');
    Route::post('/buscar', [ManifestacaoController::class, 'buscar'])->name('buscar');
    Route::get('/{manifestacao}', [ManifestacaoController::class, 'show'])->name('show');
});

/*
|--------------------------------------------------------------------------
| Rotas Administrativas
|--------------------------------------------------------------------------
| Área restrita para usuários autenticados
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    /*
    |--------------------------------------------------------------------------
    | Gestão de Manifestações (Admin)
    |--------------------------------------------------------------------------
    */
    Route::prefix('manifestacoes')->name('manifestacoes.')->group(function () {
        Route::get('/', [AdminManifestacaoController::class, 'index'])->name('index');
        Route::get('/{manifestacao}', [AdminManifestacaoController::class, 'show'])->name('show');
        Route::get('/{manifestacao}/edit', [AdminManifestacaoController::class, 'edit'])->name('edit');
        Route::put('/{manifestacao}', [AdminManifestacaoController::class, 'update'])->name('update');
        Route::post('/{manifestacao}/atribuir', [AdminManifestacaoController::class, 'atribuir'])->name('atribuir');
        Route::post('/{manifestacao}/arquivar', [AdminManifestacaoController::class, 'arquivar'])->name('arquivar');
        Route::get('/nova-manual', [AdminManifestacaoController::class, 'createManual'])->name('create.manual');
        Route::post('/salvar-manual', [AdminManifestacaoController::class, 'storeManual'])->name('store.manual');
    });
    
    /*
    |--------------------------------------------------------------------------
    | Gestão de Usuários
    |--------------------------------------------------------------------------
    */
    Route::resource('users', UserController::class)->except(['show']);
    
    /*
    |--------------------------------------------------------------------------
    | Gestão de Tipos de Manifestação (CRUD)
    |--------------------------------------------------------------------------
    */
    Route::resource('tipos', TipoManifestacaoController::class)->except(['show']);
    
    /*
    |--------------------------------------------------------------------------
    | Relatórios
    |--------------------------------------------------------------------------
    */
    Route::prefix('relatorios')->name('relatorios.')->group(function () {
        Route::get('/', [RelatorioController::class, 'index'])->name('index');
        // Futuras rotas para relatórios específicos podem ser adicionadas aqui
        // Route::get('/mensal', [RelatorioController::class, 'mensal'])->name('mensal');
        // Route::get('/categorias', [RelatorioController::class, 'porCategoria'])->name('categorias');
    });
});

// Exemplo futuro:
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
});

/*
|--------------------------------------------------------------------------
| Rotas de Autenticação
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';