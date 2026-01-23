<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manifestacao;
use App\Models\TipoManifestacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RelatorioController extends Controller
{
    /**
     * Exibe o formulário de filtro e, se houver datas, o relatório.
     * Corresponde à rota 'admin.relatorios.index'.
     */
    public function index(Request $request)
    {
        // 1. Definição do Período de Relatório
        $data_inicio = $request->input('data_inicio');
        $data_fim = $request->input('data_fim');

        $relatorio = null;

        if ($data_inicio && $data_fim) {
            // Se as datas foram fornecidas, gera o relatório
            $relatorio = $this->gerarRelatorioData($data_inicio, $data_fim);
        }

        return view('admin.relatorios.index', compact('relatorio', 'data_inicio', 'data_fim'));
    }

    /**
     * Lógica principal para calcular os dados do relatório.
     *
     * @param string $data_inicio
     * @param string $data_fim
     * @return array
     */
    private function gerarRelatorioData(string $data_inicio, string $data_fim)
{
    $inicio = $data_inicio . ' 00:00:00';
    $fim = $data_fim . ' 23:59:59';

    $query = Manifestacao::whereBetween('created_at', [$inicio, $fim]);
    $total = (clone $query)->count();

    if ($total === 0) return null;

    // 1. Distribuições Básicas
    $por_status = (clone $query)->select('status', DB::raw('count(*) as total'))
        ->groupBy('status')->pluck('total', 'status')->toArray();
        
    $por_tipo = (clone $query)->with('tipo')->select('tipo_manifestacao_id', DB::raw('count(*) as total'))
        ->groupBy('tipo_manifestacao_id')->get();

    $por_canal = (clone $query)->select('canal', DB::raw('count(*) as total'))
        ->groupBy('canal')->pluck('total', 'canal')->toArray();

    // 2. Eficiência de Prazos (Conforme o seu SQL)
    $prazos_por_tipo = Manifestacao::join('tipos_manifestacao', 'manifestacoes.tipo_manifestacao_id', '=', 'tipos_manifestacao.id')
        ->whereBetween('manifestacoes.created_at', [$inicio, $fim])
        ->whereNotNull('data_resposta')
        ->select(
            'tipos_manifestacao.nome as tipo_nome',
            DB::raw('COUNT(*) as total_respondidas'),
            DB::raw('SUM(CASE WHEN DATEDIFF(data_resposta, data_entrada) <= tipos_manifestacao.prazo_dias THEN 1 ELSE 0 END) as dentro_prazo'),
            DB::raw('SUM(CASE WHEN DATEDIFF(data_resposta, data_entrada) > tipos_manifestacao.prazo_dias THEN 1 ELSE 0 END) as fora_prazo')
        )
        ->groupBy('tipos_manifestacao.id', 'tipos_manifestacao.nome')->get();

    // 3. Perfil de Identificação
    $identificacao = [
        'sigilosa' => (clone $query)->where('sigilo_dados', true)->count(),
        'anonima' => (clone $query)->where(function($q) {
            $q->whereNull('nome')->orWhere('nome', 'like', '%Anônimo%');
        })->count(),
        'nao_sigilosa' => (clone $query)->where('sigilo_dados', false)
            ->whereNotNull('nome')->where('nome', 'not like', '%Anônimo%')->count(),
    ];

    // 4. Índices
    $respondidas = ($por_status['RESPONDIDO'] ?? 0) + ($por_status['FINALIZADO'] ?? 0);
    $resolutividade = number_format(($respondidas / $total) * 100, 2);
    
    $dentro_prazo_total = $prazos_por_tipo->sum('dentro_prazo');
    $total_resp = $prazos_por_tipo->sum('total_respondidas');
    $perc_prazo = $total_resp > 0 ? number_format(($dentro_prazo_total / $total_resp) * 100, 2) : 0;

    return [
        'periodo' => [
            'inicio' => \Carbon\Carbon::parse($data_inicio)->format('d/m/Y'),
            'fim' => \Carbon\Carbon::parse($data_fim)->format('d/m/Y')
        ],
        'total' => $total,
        'por_status' => $por_status,
        'por_tipo' => $por_tipo,
        'por_canal' => $por_canal,
        'prazos_por_tipo' => $prazos_por_tipo,
        'identificacao' => $identificacao,
        'indices' => [
            'resolutividade' => $resolutividade,
            'perc_prazo_ok' => $perc_prazo,
            'satisfacao' => 'Em implementação'
        ]
    ];
}
}
