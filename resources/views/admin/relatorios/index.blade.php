@extends('admin.layouts.app')

@section('title', 'Relatório de Atividades da Ouvidoria')

@section('content')
<div class="container-fluid py-4">
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-chart-line me-2"></i> Relatório de Atividades</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filtrar Período</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.relatorios.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label for="data_inicio" class="form-label">Data de Início</label>
                        <input type="date" class="form-control" id="data_inicio" name="data_inicio" 
                               value="{{ $data_inicio ?? '' }}" required>
                    </div>
                    <div class="col-md-5 mb-3">
                        <label for="data_fim" class="form-label">Data de Fim</label>
                        <input type="date" class="form-control" id="data_fim" name="data_fim" 
                               value="{{ $data_fim ?? '' }}" required>
                    </div>
                    <div class="col-md-2 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-1"></i> Gerar Relatório</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if ($relatorio)
    
        <div class="text-center mb-4">
            <h2 class="h4">Relatório Semestral de Atividades</h2>
            <p class="lead text-muted">Período: {{ $relatorio['periodo']['inicio'] }} a {{ $relatorio['periodo']['fim'] }}</p>
        </div>

        <hr>

        <div class="row mb-5">
            <h4 class="mb-3 text-primary"><i class="fas fa-balance-scale me-2"></i> Índices e Desempenho</h4>
            
            <div class="col-md-3 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Índice de Resolutividade
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $relatorio['indices']['resolutividade'] }}%
                        </div>
                        <small class="text-muted">Demandas respondidas / Total</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Tempo de Resposta (no Prazo)
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $relatorio['indices']['perc_prazo_ok'] }}%
                        </div>
                        <small class="text-muted">Respondidas em até 30 dias</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Índice de Satisfação
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $relatorio['indices']['satisfacao'] }}
                        </div>
                        <small class="text-muted">Requer pesquisa de satisfação</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card border-left-secondary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                            TOTAL DE DEMANDAS
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $relatorio['total'] }}
                        </div>
                        <small class="text-muted">Manifestações no período</small>
                    </div>
                </div>
            </div>
        </div>
        
        <hr>

        <div class="row mb-5">
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow">
                    <div class="card-header py-3 bg-light">
                        <h6 class="m-0 font-weight-bold text-primary">Distribuição por Situação (Status)</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach ($relatorio['por_status'] as $status => $total)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>{{ $status }}</strong>
                                <div>
                                    <span class="badge bg-primary rounded-pill me-2">{{ $total }}</span>
                                    ({{ $relatorio['total'] > 0 ? number_format(($total / $relatorio['total']) * 100, 2) : 0 }}%)
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6">
        <div class="card shadow">
            <div class="card-header py-3 bg-light">
                <h6 class="m-0 font-weight-bold text-primary">Canais Utilizados no Período</h6>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @forelse ($relatorio['por_canal'] as $canal => $total)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong>
                            {{ 
                                match ($canal) {
                                    'WEB' => 'Formulário Web',
                                    'EMAIL' => 'E-mail',
                                    'TELEFONE' => 'Telefone Fixo',
                                    'PRESENCIAL' => 'Presencial',
                                    'WHATSAPP' => 'WhatsApp',
                                    default => $canal, // Caso haja algum valor não mapeado
                                }
                            }}
                        </strong>
                        <div>
                            <span class="badge bg-primary rounded-pill me-2">{{ $total }}</span>
                            ({{ $relatorio['total'] > 0 ? number_format(($total / $relatorio['total']) * 100, 2) : 0 }}%)
                        </div>
                    </li>
                    @empty
                    <li class="list-group-item text-center text-muted">Nenhuma manifestação encontrada neste período.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow h-100">
            <div class="card-header py-3 bg-light">
                <h6 class="m-0 font-weight-bold text-secondary">A Importância do Registro Manual</h6>
            </div>
            <div class="card-body">
                <p>Para o cumprimento da LAI, o registro correto dos canais **Presencial, E-mail, Telefone e WhatsApp** é fundamental, pois garante que a contagem total de demandas e o cálculo do Índice de Resolutividade sejam precisos e reflitam a realidade da Ouvidoria.</p>
                <p class="mb-0">**Atenção:** Certifique-se de que sua interface de **criação de manifestação manual** na área administrativa permita a seleção correta de um desses canais, salvando o valor no campo `canal` da tabela `manifestacoes`.</p>
            </div>
        </div>
    </div>

        <div class="row mb-5">
            <h4 class="mb-3 text-primary"><i class="fas fa-phone-alt me-2"></i> Canais de Atendimento</h4>
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body">
                        <p class="text-muted">
                            **Nota:** A estatística **"Por Canal de Atendimento"** requer que você tenha um campo `canal` (ou similar) no seu Model `Manifestacao` para ser implementada a contagem. O modelo TCE-PA inclui esse dado.
                        </p>
                        <p>Exemplo de dados a incluir: E-mail, Telefone, Presencial, Formulário Web, etc.</p>
                        {{-- Implementação futura: Adicionar lógica no Controller para $por_canal e exibir aqui --}}
                    </div>
                </div>
            </div>
        </div>

    @else
        <div class="alert alert-info shadow-sm" role="alert">
            <h4 class="alert-heading">Relatório da Ouvidoria</h4>
            <p>Selecione a **Data de Início** e **Data de Fim** para gerar o relatório de atividades da ouvidoria, conforme a exigência da LAI. A maioria dos órgãos opta por relatórios trimestrais ou semestrais, como o seu.</p>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    /* Estilos de borda esquerda dos cards (copiados do dashboard) */
    .border-left-success { border-left: 4px solid #1cc88a !important; }
    .border-left-info { border-left: 4px solid #36b9cc !important; }
    .border-left-warning { border-left: 4px solid #f6c23e !important; }
    .border-left-secondary { border-left: 4px solid #858796 !important; }
</style>
@endpush