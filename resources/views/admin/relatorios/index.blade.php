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
                <div class="row align-items-end">
                    <div class="col-md-5">
                        <label class="form-label small fw-bold">Data de Início</label>
                        <input type="date" class="form-control" name="data_inicio" value="{{ $data_inicio }}" required>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small fw-bold">Data de Fim</label>
                        <input type="date" class="form-control" name="data_fim" value="{{ $data_fim }}" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100 mt-3">Gerar Relatório</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if ($relatorio)
        <div class="text-center mb-4">
            <h2 class="h4">Relatório de Atividades da Ouvidoria</h2>
            <p class="lead text-muted">Período: {{ $relatorio['periodo']['inicio'] }} a {{ $relatorio['periodo']['fim'] }}</p>
        </div>

        <div class="row mb-4">
            <div class="col-md-3 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Índice Resolutividade</div>
                        <div class="h5 mb-0 font-weight-bold">{{ $relatorio['indices']['resolutividade'] }}%</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">No Prazo (LAI)</div>
                        <div class="h5 mb-0 font-weight-bold">{{ $relatorio['indices']['perc_prazo_ok'] }}%</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card border-left-secondary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Total de Demandas</div>
                        <div class="h5 mb-0 font-weight-bold">{{ $relatorio['total'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Situação das Demandas</h6></div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach ($relatorio['por_status'] as $status => $total)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $status }}</span>
                                <span class="badge bg-primary rounded-pill">{{ $total }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Canais de Atendimento</h6></div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @forelse ($relatorio['por_canal'] as $canal => $total)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $canal == 'WEB' ? 'Formulário Site' : $canal }}</span>
                                <span class="badge bg-info rounded-pill">{{ $total }}</span>
                            </li>
                            @empty
                            <li class="list-group-item text-center">Sem dados de canais.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-8 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3 bg-white">
                        <h6 class="m-0 font-weight-bold text-primary">Eficiência de Resposta por Tipo (Prazos SQL)</h6>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-3">Tipo</th>
                                    <th class="text-center">Respondidas</th>
                                    <th class="text-center">No Prazo</th>
                                    <th class="text-center">Atrasadas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($relatorio['prazos_por_tipo'] as $item)
                                <tr>
                                    <td class="ps-3">{{ $item->tipo_nome }}</td>
                                    <td class="text-center">{{ $item->total_respondidas }}</td>
                                    <td class="text-center text-success fw-bold">{{ $item->dentro_prazo }}</td>
                                    <td class="text-center text-danger fw-bold">{{ $item->fora_prazo }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3 bg-white">
                        <h6 class="m-0 font-weight-bold text-primary">Identificação</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted">Pública</small>
                            <div class="d-flex justify-content-between">
                                <span class="h5">{{ $relatorio['identificacao']['nao_sigilosa'] }}</span>
                                <i class="fas fa-user text-success"></i>
                            </div>
                        </div>
                        <div class="mb-3 border-top pt-2">
                            <small class="text-muted">Sigilosa</small>
                            <div class="d-flex justify-content-between">
                                <span class="h5">{{ $relatorio['identificacao']['sigilosa'] }}</span>
                                <i class="fas fa-user-shield text-warning"></i>
                            </div>
                        </div>
                        <div class="border-top pt-2">
                            <small class="text-muted">Anônima</small>
                            <div class="d-flex justify-content-between">
                                <span class="h5">{{ $relatorio['identificacao']['anonima'] }}</span>
                                <i class="fas fa-user-secret text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end mb-5">
            <button onclick="window.print()" class="btn btn-dark"><i class="fas fa-print me-1"></i> Imprimir</button>
        </div>

    @else
        <div class="alert alert-info border-0 shadow-sm">
            <h4 class="alert-heading">Relatório Gerencial</h4>
            <p class="mb-0">Escolha um período para analisar a performance da Ouvidoria FASPM/PA.</p>
        </div>
    @endif
</div>
@endsection