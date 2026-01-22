<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manifestacao;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
public function index()
{
    $stats = [
        'total' => Manifestacao::count(),
        'abertas' => Manifestacao::where('status', 'ABERTO')->count(),
        'em_analise' => Manifestacao::where('status', 'EM_ANALISE')->count(),
        'respondidas' => Manifestacao::where('status', 'RESPONDIDO')->count(),
        'finalizadas' => Manifestacao::where('status', 'FINALIZADO')->count(),
        'arquivadas' => Manifestacao::whereNotNull('arquivado_em')->count(),
    ];

    $recentes = Manifestacao::with(['tipo', 'editor', 'responsavel'])->latest()->limit(10)->get();

    $porTipo = Manifestacao::with('tipo')->select('tipo_manifestacao_id', DB::raw('count(*) as total'))
        ->groupBy('tipo_manifestacao_id')->get();

    $porPrioridade = Manifestacao::select('prioridade', DB::raw('count(*) as total'))
        ->groupBy('prioridade')->get();

    $atrasadas = Manifestacao::with(['tipo', 'editor'])
        ->where('data_limite_resposta', '<', now())
        ->whereIn('status', ['ABERTO', 'EM_ANALISE'])
        ->orderBy('data_limite_resposta')->get();

    $stats['atrasadas'] = $atrasadas->count();

    return view('admin.dashboard', compact('stats', 'recentes', 'porTipo', 'porPrioridade', 'atrasadas'));
}
}
