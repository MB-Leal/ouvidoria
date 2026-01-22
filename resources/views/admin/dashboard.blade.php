@extends('admin.layouts.app')

@section('title', 'Dashboard - Ouvidoria FASPM/PA')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </h1>
            <p class="mb-0">Bem-vindo, {{ auth()->user()->name }}! 
                <span class="badge bg-{{ auth()->user()->role == 'admin' ? 'danger' : (auth()->user()->role == 'ouvidor' ? 'warning' : 'info') }}">
                    {{ auth()->user()->role_name }}
                </span>
            </p>
        </div>
        <div>
            <span class="text-muted">
                <i class="fas fa-calendar me-1"></i> {{ now()->format('d/m/Y H:i') }}
            </span>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Manifestações</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Em Aberto</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['abertas'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Em Análise</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['em_analise'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-search fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Respondidas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['respondidas'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-history me-2"></i> Manifestações Recentes
                    </h6>
                    <a href="{{ route('admin.manifestacoes.index') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-list me-1"></i> Ver Todas
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>Protocolo</th>
                                    <th>Tipo</th>
                                    <th>Status</th>
                                    <th>Prazo</th> {{-- Nova Coluna --}}
                                    <th>Última Ação</th> {{-- Coluna Corrigida --}}
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentes as $manifestacao)
                                <tr>
                                    <td><strong>{{ $manifestacao->protocolo }}</strong></td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $manifestacao->tipo->cor }}">
                                            {{ $manifestacao->tipo->nome }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $manifestacao->status_cor }}">
                                            {{ $manifestacao->status_formatado }}
                                        </span>
                                    </td>
                                    <td>
                                        @if(in_array($manifestacao->status, ['RESPONDIDO', 'FINALIZADO']))
                                            <span class="text-muted small"><i class="fas fa-check-double"></i> Concluído</span>
                                        @elseif($manifestacao->dias_restantes !== null)
                                            @if($manifestacao->dias_restantes < 0)
                                                <span class="badge bg-danger">Atrasado {{ abs($manifestacao->dias_restantes) }}d</span>
                                            @elseif($manifestacao->dias_restantes == 0)
                                                <span class="badge bg-warning text-dark">Vence hoje</span>
                                            @else
                                                <span class="badge bg-success">Faltam {{ $manifestacao->dias_restantes }}d</span>
                                            @endif
                                        @else
                                            <span class="text-muted small">Sem prazo</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($manifestacao->editor)
                                            <small class="text-dark fw-bold">
                                                <i class="fas fa-user-edit text-primary"></i> {{ explode(' ', $manifestacao->editor->name)[0] }}
                                            </small>
                                        @elseif($manifestacao->responsavel)
                                            <small class="text-muted">
                                                <i class="fas fa-user-plus"></i> {{ explode(' ', $manifestacao->responsavel->name)[0] }}
                                            </small>
                                        @else
                                            <small class="text-muted italic">Pendente</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.manifestacoes.show', $manifestacao) }}"
                                                class="btn btn-sm btn-info" title="Visualizar">
                                                <i class="fas fa-eye text-white"></i>
                                            </a>
                                            <a href="{{ route('admin.manifestacoes.edit', $manifestacao) }}"
                                                class="btn btn-sm btn-warning" title="Editar">
                                                <i class="fas fa-edit text-white"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Nenhuma manifestação encontrada.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- O bloco de atrasadas agora serve como um resumo crítico --}}
            @if(isset($atrasadas) && $atrasadas->count() > 0)
            <div class="card shadow border-left-danger mb-4">
                <div class="card-header py-2 bg-danger text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-fire me-2"></i> URGENTE: Prazos Expirados
                    </h6>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        @foreach($atrasadas->take(5) as $m)
                        <tr>
                            <td class="ps-3"><strong>{{ $m->protocolo }}</strong></td>
                            <td class="text-danger">Atraso de {{ abs($m->dias_restantes) }} dias</td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.manifestacoes.edit', $m) }}" class="btn btn-xs btn-danger">Tratar</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            @endif
        </div>

        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card border-left-primary shadow mb-4 py-2">
                <div class="card-body">
                    <div class="h5 mb-0 font-weight-bold text-gray-800">Relatórios Gerenciais</div>
                    <a href="{{ route('admin.relatorios.index') }}" class="btn btn-primary btn-sm mt-3 w-100">
                        Gerar Documentos <i class="fas fa-file-pdf ms-1"></i>
                    </a>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-chart-pie me-2"></i> Por Tipo</h6>
                </div>
                <div class="card-body">
                    @foreach($porTipo as $item)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1 small">
                            <span>{{ $item->tipo->nome }}</span>
                            <span class="fw-bold">{{ $item->total }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar" style="width: {{ $stats['total'] > 0 ? ($item->total / $stats['total'] * 100) : 0 }}%; background-color: {{ $item->tipo->cor }}"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-exclamation-circle me-2"></i> Prioridade</h6>
                </div>
                <div class="card-body">
                    @foreach($porPrioridade as $item)
                        @php $cores = ['urgente' => 'danger', 'alta' => 'warning', 'media' => 'info', 'baixa' => 'success']; @endphp
                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-grow-1">
                                <span class="small text-capitalize">{{ $item->prioridade }}</span>
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar bg-{{ $cores[$item->prioridade] ?? 'secondary' }}" style="width: {{ $stats['total'] > 0 ? ($item->total / $stats['total'] * 100) : 0 }}%"></div>
                                </div>
                            </div>
                            <span class="badge bg-light text-dark ms-2">{{ $item->total }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .border-left-primary { border-left: 4px solid #4e73df !important; }
    .border-left-danger { border-left: 4px solid #e74a3b !important; }
    .btn-xs { padding: 0.1rem 0.5rem; font-size: 0.7rem; }
    .table thead th { font-size: 0.75rem; text-transform: uppercase; color: #555; }
    .italic { font-style: italic; }
</style>
@endsection