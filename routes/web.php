<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DemandaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin; // Importa a pasta Admin para facilitar
use Illuminate\Support\Facades\Route;


/*
 * ROTAS PÚBLICAS
 */
Route::get('/', function () {
    return view('welcome');
});

Route::get('/registrar-demanda', [DemandaController::class, 'index'])->name('demanda.index');
Route::get('/registrar-demanda/{tipo}', [DemandaController::class, 'create'])->name('demanda.create');
Route::post('/registrar-demanda', [DemandaController::class, 'store'])->name('demanda.store');
Route::get('/demanda-registrada', function () {
    return view('demandas.sucesso');
})->name('demanda.sucesso');

Route::get('/consultar-demanda', [DemandaController::class, 'showConsultaForm'])->name('demanda.consultar');
Route::post('/consultar-demanda', [DemandaController::class, 'showDemanda'])->name('demanda.show');

Route::get('/relatorios-publicos', [DemandaController::class, 'relatoriosPublicos'])->name('demanda.relatorios');

// Rotas de autenticação do Laravel Breeze
require __DIR__.'/auth.php';


/*
 * MÓDULO ADMINISTRATIVO
 * Todas as rotas dentro deste grupo exigem que o usuário esteja autenticado.
 */
Route::middleware(['auth'])->group(function () {
    // Dashboard do sistema administrativo
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rotas de perfil do usuário (padrão do Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rotas de recurso para gerenciar as demandas (acessível a todos os usuários autenticados)
    Route::resource('demandas', Admin\DemandaController::class)->names('admin.demandas');
    
    // Rota para salvar um novo parecer (acessível a todos os usuários autenticados)
    Route::post('/demandas/{demanda}/parecer', [Admin\DemandaController::class, 'storeParecer'])->name('admin.demandas.store_parecer');

    // Rota que só usuários com o perfil 'admin' podem acessar
    Route::middleware(['perfil:admin'])->group(function () {
        // Rotas de recurso para gerenciar os usuários
        Route::resource('usuarios', Admin\UsuarioController::class)->names('admin.usuarios');
    });
});

