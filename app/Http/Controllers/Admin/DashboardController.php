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
        $user = auth()->user();
        // Estatísticas gerais
        $stats = [
            'total' => Manifestacao::count(),
            'abertas' => Manifestacao::where('status', 'ABERTO')->count(),
            'em_analise' => Manifestacao::where('status', 'EM_ANALISE')->count(),
            'respondidas' => Manifestacao::where('status', 'RESPONDIDO')->count(),
            'finalizadas' => Manifestacao::where('status', 'FINALIZADO')->count(),
            'atrasadas' => 0, // Inicializar como 0
            'arquivadas' => Manifestacao::whereNotNull('arquivado_em')->count(),
        ];

        // Se não for admin, ajustar estatísticas
        if (!$user->isAdmin()) {
            $stats['total'] = Manifestacao::where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereNull('user_id');
            })->count();

            $stats['abertas'] = Manifestacao::where('status', 'ABERTO')
                ->where(function ($query) use ($user) {
                    $query->where('user_id', $user->id)
                        ->orWhereNull('user_id');
                })->count();
        }

        // Manifestações recentes (últimas 10)
        $recentes = Manifestacao::with(['tipo', 'responsavel'])
            ->latest()
            ->limit(10)
            ->when(!$user->isAdmin(), function ($query) use ($user) {
                return $query->where(function ($q) use ($user) {
                    $q->where('user_id', $user->id)
                        ->orWhereNull('user_id');
                });
            })
            ->get();

        // Estatísticas por tipo
        $porTipo = Manifestacao::select('tipo_manifestacao_id', DB::raw('count(*) as total'))
            ->with('tipo')
            ->when(!$user->isAdmin(), function ($query) use ($user) {
                return $query->where(function ($q) use ($user) {
                    $q->where('user_id', $user->id)
                        ->orWhereNull('user_id');
                });
            })
            ->groupBy('tipo_manifestacao_id')
            ->get();

        // Manifestações por status (para gráfico)
        $porStatus = Manifestacao::select('status', DB::raw('count(*) as total'))
            ->when(!$user->isAdmin(), function ($query) use ($user) {
                return $query->where(function ($q) use ($user) {
                    $q->where('user_id', $user->id)
                        ->orWhereNull('user_id');
                });
            })
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');

        // Manifestações por prioridade - INICIALIZAR CORRETAMENTE
        $porPrioridade = Manifestacao::select('prioridade', DB::raw('count(*) as total'))
            ->when(!$user->isAdmin(), function ($query) use ($user) {
                return $query->where(function ($q) use ($user) {
                    $q->where('user_id', $user->id)
                        ->orWhereNull('user_id');
                });
            })
            ->groupBy('prioridade')
            ->get();

        // Manifestações atrasadas - DEFINIR A VARIÁVEL $atrasadas
        $atrasadas = Manifestacao::with(['tipo', 'responsavel'])
            ->where('data_limite_resposta', '<', now())
            ->whereIn('status', ['ABERTO', 'EM_ANALISE'])
            ->when(!$user->isAdmin(), function ($query) use ($user) {
                return $query->where('user_id', $user->id);
            })
            ->orderBy('data_limite_resposta')
            ->limit(5)
            ->get();

        // Atualizar estatística de atrasadas
        $stats['atrasadas'] = $atrasadas->count();

        // Top responsáveis (apenas para admin)
        $topResponsaveis = collect(); // Inicializar como collection vazia
        if ($user->isAdmin()) {
            $topResponsaveis = User::where('ativo', true)
                ->withCount(['manifestacoesAtribuidas' => function ($query) {
                    $query->whereNull('arquivado_em');
                }])
                ->orderBy('manifestacoes_atribuidas_count', 'desc')
                ->limit(5)
                ->get();
        }

        return view('admin.dashboard', compact(
            'stats',
            'recentes',
            'porTipo',
            'porStatus',
            'porPrioridade',
            'atrasadas', // ADICIONAR AQUI!
            'topResponsaveis'
        ));
    }
}
