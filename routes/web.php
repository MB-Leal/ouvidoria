<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManifestacaoController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ManifestacaoController as AdminManifestacaoController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TipoManifestacaoController;

// Rotas públicas
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/nova-manifestacao', [ManifestacaoController::class, 'create'])->name('manifestacoes.create');
Route::post('/manifestacoes', [ManifestacaoController::class, 'store'])->name('manifestacoes.store');
Route::get('/acompanhar', [ManifestacaoController::class, 'acompanhar'])->name('manifestacoes.acompanhar');
Route::post('/buscar', [ManifestacaoController::class, 'buscar'])->name('manifestacoes.buscar');
Route::get('/manifestacoes/{manifestacao}', [ManifestacaoController::class, 'show'])->name('manifestacoes.show');

// Rotas administrativas (protegidas)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manifestações
    Route::get('/manifestacoes', [AdminManifestacaoController::class, 'index'])->name('manifestacoes.index');
    Route::get('/manifestacoes/{manifestacao}', [AdminManifestacaoController::class, 'show'])->name('manifestacoes.show');
    Route::get('/manifestacoes/{manifestacao}/edit', [AdminManifestacaoController::class, 'edit'])->name('manifestacoes.edit');
    Route::put('/manifestacoes/{manifestacao}', [AdminManifestacaoController::class, 'update'])->name('manifestacoes.update');
    Route::post('/manifestacoes/{manifestacao}/atribuir', [AdminManifestacaoController::class, 'atribuir'])->name('manifestacoes.atribuir');
    Route::post('/manifestacoes/{manifestacao}/arquivar', [AdminManifestacaoController::class, 'arquivar'])->name('manifestacoes.arquivar');

    // Usuários (apenas admin)
    Route::resource('/users', UserController::class)->except(['show']);

    // 🆕 NOVA ROTA PARA GESTÃO DE TIPOS DE MANIFESTAÇÃO (CRUD)
    Route::resource('tipos', App\Http\Controllers\Admin\TipoManifestacaoController::class)->except(['show']);
    // 🆕 NOVA ROTA PARA RELATÓRIOS
    Route::get('relatorios', [App\Http\Controllers\Admin\RelatorioController::class, 'index'])->name('relatorios.index');
});

// Rotas de autenticação
require __DIR__ . '/auth.php';
