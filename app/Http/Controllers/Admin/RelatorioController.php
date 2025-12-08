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
    private function gerarRelatorioData(string $data_inicio, string $data_fim): array
    {
        // Converte as datas para objetos Carbon para garantir a precisão da consulta
    $start = Carbon::parse($data_inicio)->startOfDay();
    $end = Carbon::parse($data_fim)->endOfDay();

    // Query Base: Filtrar apenas as manifestações dentro do período
    $query = Manifestacao::whereBetween('created_at', [$start, $end]);

    // 1. Contagem Total
    $total_manifestacoes = $query->count();

    if ($total_manifestacoes === 0) {
        // Se não há manifestações, retorne um array vazio ou com zeros
        return [
            'total' => 0,
            'por_status' => [],
            'por_tipo' => [],
            'indices' => [
                'resolutividade' => '0.00',
                'perc_prazo_ok' => '0.00',
                'satisfacao' => 'N/A',
                'parceria' => 'N/A',
            ],
            'periodo' => [
                'inicio' => $start->format('d/m/Y'),
                'fim' => $end->format('d/m/Y'),
            ]
        ];
    }

    // 2. Estatísticas por Situação/Status
    $por_status = (clone $query)
        ->select('status', DB::raw('count(*) as total'))
        ->groupBy('status')
        ->pluck('total', 'status')
        ->toArray();

    // 3. Estatísticas por Tipo (Natureza)
    $por_tipo = (clone $query)
        ->select('tipo_manifestacao_id', DB::raw('count(*) as total'))
        ->with('tipo')
        ->groupBy('tipo_manifestacao_id')
        ->get();

    // 4. Cálculo de Índices
    $respondidas = $por_status['RESPONDIDA'] ?? 0;
    $resolutividade = number_format(($respondidas / $total_manifestacoes) * 100, 2);

    // 5. Tempo de Resposta (Assumindo coluna 'data_resposta' e prazo de 30 dias)
    // Se a sua coluna de resposta for outra (ex: 'updated_at'), ajuste aqui.
    $dentro_do_prazo = (clone $query)
        ->where('status', 'RESPONDIDA')
        ->whereNotNull('data_resposta')
        // Verifica se a diferença de dias entre a criação e a resposta é <= 30
        ->whereRaw('DATEDIFF(data_resposta, created_at) <= 30') 
        ->count();

    $perc_prazo = $respondidas > 0 ? number_format(($dentro_do_prazo / $respondidas) * 100, 2) : 0;

    // 6. Estatísticas por Canal de Atendimento (NOVO)
$por_canal = (clone $query)
    ->select('canal', DB::raw('count(*) as total'))
    ->groupBy('canal')
    ->pluck('total', 'canal')
    ->toArray();

    return [
        'total' => $total_manifestacoes,
        'por_status' => $por_status,
        'por_tipo' => $por_tipo,
        'por_canal' => $por_canal,
        'indices' => [
            'resolutividade' => $resolutividade,
            'perc_prazo_ok' => $perc_prazo,
            'satisfacao' => 'N/A (Requer pesquisa)',
            'parceria' => 'N/A (Requer pesquisa)',
        ],
        'periodo' => [
            'inicio' => $start->format('d/m/Y'),
            'fim' => $end->format('d/m/Y'),
        ]
    ];
    }
}