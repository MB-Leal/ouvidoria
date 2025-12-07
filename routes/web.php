<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ManifestacaoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rotas públicas
Route::get('/nova-manifestacao', [ManifestacaoController::class, 'create'])->name('manifestacoes.create');
Route::post('/manifestacoes', [ManifestacaoController::class, 'store'])->name('manifestacoes.store');
Route::get('/acompanhar', [ManifestacaoController::class, 'acompanhar'])->name('manifestacoes.acompanhar');
Route::post('/buscar', [ManifestacaoController::class, 'buscar'])->name('manifestacoes.buscar');
Route::get('/manifestacoes/{manifestacao}', [ManifestacaoController::class, 'show'])->name('manifestacoes.show');


// Rotas administrativas (protegidas)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        $stats = [
            'total' => \App\Models\Manifestacao::count(),
            'abertas' => \App\Models\Manifestacao::where('status', 'ABERTO')->count(),
            'em_analise' => \App\Models\Manifestacao::where('status', 'EM_ANALISE')->count(),
            'respondidas' => \App\Models\Manifestacao::where('status', 'RESPONDIDO')->count(),
        ];
        return view('admin.dashboard', compact('stats'));
    })->name('dashboard');
});

require __DIR__.'/auth.php';
