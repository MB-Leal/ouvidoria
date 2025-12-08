@extends('admin.layouts.app')

@section('title', 'Dashboard - Ouvidoria FASPM/PA')

@section('content')
<div class="container-fluid py-4">
    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </h1>
            <p class="mb-0">Bem-vindo, {{ auth()->user()->name }}! <span class="badge bg-{{ auth()->user()->role == 'admin' ? 'danger' : (auth()->user()->role == 'ouvidor' ? 'warning' : 'info') }}">{{ auth()->user()->role_name }}</span></p>
        </div>
        <div>
            <span class="text-muted">
                <i class="fas fa-calendar me-1"></i> {{ now()->format('d/m/Y H:i') }}
            </span>
        </div>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Manifestações
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['total'] }}
                            </div>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Em Aberto
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['abertas'] }}
                            </div>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Em Análise
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['em_analise'] }}
                            </div>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Respondidas
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['respondidas'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">                    
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        Relatórios
                    </div>
                </div>
                <div class="col-auto">
                    {{-- Ícone para Relatórios --}}
                    <i class="fas fa-chart-line fa-2x text-gray-300"></i> 
                </div>
            </div>
            
            {{-- O botão que direciona para a página de relatórios --}}
            <a href="{{ route('admin.relatorios.index') }}" class="btn btn-primary btn-sm mt-3 w-100">
                Acessar Relatórios <i class="fas fa-arrow-circle-right ms-1"></i>
            </a>

        </div>
    </div>
</div>
    </div>

    <!-- Linha com Gráficos e Listas -->
    <div class="row">
        <!-- Manifestações Recentes -->
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
                                    <th>Solicitante</th>
                                    <th>Data</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentes as $manifestacao)
                                <tr>
                                    <td>
                                        <strong>{{ $manifestacao->protocolo }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $manifestacao->tipo->cor }}">
                                            {{ $manifestacao->tipo->nome }}
                                        </span>
                                    </td>
                                    <td>{{ Str::limit($manifestacao->nome, 20) }}</td>
                                    <td>{{ $manifestacao->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $manifestacao->status_cor }}">
                                            {{ $manifestacao->status_formatado }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.manifestacoes.show', $manifestacao) }}"
                                            class="btn btn-sm btn-info" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
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
            <!-- Manifestações Atrasadas -->
            @if(isset($atrasadas) && $atrasadas->count() > 0)
            <div class="card shadow border-left-danger mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i> Manifestações Atrasadas
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Protocolo</th>
                                    <th>Tipo</th>
                                    <th>Responsável</th>
                                    <th>Data Limite</th>
                                    <th>Atraso</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($atrasadas as $manifestacao)
                                <tr>
                                    <td>{{ $manifestacao->protocolo }}</td>
                                    <td>{{ $manifestacao->tipo->nome }}</td>
                                    <td>
                                        @if($manifestacao->responsavel)
                                        {{ $manifestacao->responsavel->name }}
                                        @else
                                        <span class="text-danger">Não atribuído</span>
                                        @endif
                                    </td>
                                    <td>{{ $manifestacao->data_limite_resposta?->format('d/m/Y') ?? 'Não definida' }}</td>
                                    <td>
                                        @if($manifestacao->dias_restantes < 0)
                                            <span class="badge bg-danger">
                                            {{ abs($manifestacao->dias_restantes) }} dias
                                            </span>
                                            @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar com Estatísticas -->
        <div class="col-xl-4 col-lg-5 mb-4">
            <!-- Distribuição por Tipo -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-pie me-2"></i> Por Tipo
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        @foreach($porTipo as $item)
                        <div class="mb-2">
                            <div class="d-flex justify-content-between mb-1">
                                <span>{{ $item->tipo->nome }}</span>
                                <span class="fw-bold">{{ $item->total }}</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar"
                                    role="progressbar"
                                    style="width: {{ $stats['total'] > 0 ? ($item->total / $stats['total'] * 100) : 0 }}%; background-color: {{ $item->tipo->cor }}"
                                    aria-valuenow="{{ $item->total }}"
                                    aria-valuemin="0"
                                    aria-valuemax="{{ $stats['total'] }}">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Distribuição por Prioridade -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-exclamation-circle me-2"></i> Por Prioridade
                    </h6>
                </div>
                <div class="card-body">
                    @foreach($porPrioridade as $item)
                    <div class="d-flex align-items-center mb-3">
                        @php
                        $cores = [
                        'urgente' => 'danger',
                        'alta' => 'warning',
                        'media' => 'info',
                        'baixa' => 'success'
                        ];
                        $nomes = [
                        'urgente' => 'Urgente',
                        'alta' => 'Alta',
                        'media' => 'Média',
                        'baixa' => 'Baixa'
                        ];
                        @endphp
                        <div class="me-3">
                            <i class="fas fa-flag fa-2x text-{{ $cores[$item->prioridade] ?? 'secondary' }}"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold">{{ $nomes[$item->prioridade] ?? $item->prioridade }}</span>
                                <span class="badge bg-{{ $cores[$item->prioridade] ?? 'secondary' }}">{{ $item->total }}</span>
                            </div>
                            <div class="progress mt-1" style="height: 8px;">
                                <div class="progress-bar bg-{{ $cores[$item->prioridade] ?? 'secondary' }}"
                                    style="width: {{ $stats['total'] > 0 ? ($item->total / $stats['total'] * 100) : 0 }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Top Responsáveis (apenas para admin) -->
            @if(auth()->user()->isAdmin() && $topResponsaveis->count() > 0)
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-users me-2"></i> Top Responsáveis
                    </h6>
                </div>
                <div class="card-body">
                    @foreach($topResponsaveis as $user)
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px;">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold">{{ $user->name }}</span>
                                <span class="badge bg-primary">{{ $user->manifestacoes_atribuidas_count }}</span>
                            </div>
                            <small class="text-muted">{{ $user->role_name }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Ações Rápidas -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bolt me-2"></i> Ações Rápidas
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.manifestacoes.index') }}"
                                class="btn btn-primary w-100">
                                <i class="fas fa-list me-2"></i> Ver Todas
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.manifestacoes.index', ['status' => 'ABERTO']) }}"
                                class="btn btn-warning w-100">
                                <i class="fas fa-clock me-2"></i> Em Aberto
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.manifestacoes.index', ['status' => 'EM_ANALISE']) }}"
                                class="btn btn-info w-100">
                                <i class="fas fa-search me-2"></i> Em Análise
                            </a>
                        </div>
                        @if(auth()->user()->isAdmin())
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.tipos.index') }}"
                                class="btn btn-secondary w-100">
                                <i class="fas fa-tags me-2"></i> Tipos
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.users.index') }}"
                                class="btn btn-dark w-100">
                                <i class="fas fa-users me-2"></i> Usuários
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .avatar {
        font-weight: bold;
        font-size: 16px;
    }

    .border-left-primary {
        border-left: 4px solid #4e73df !important;
    }

    .border-left-success {
        border-left: 4px solid #1cc88a !important;
    }

    .border-left-info {
        border-left: 4px solid #36b9cc !important;
    }

    .border-left-warning {
        border-left: 4px solid #f6c23e !important;
    }

    .border-left-danger {
        border-left: 4px solid #e74a3b !important;
    }

    .progress {
        border-radius: 10px;
    }

    .progress-bar {
        border-radius: 10px;
    }
</style>
@endsection