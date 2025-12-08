@extends('admin.layouts.app')

@section('title', 'Gerenciar Manifestações')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-comments me-2"></i> Manifestações
        </h1>
    </div>
    <div class="d-flex justify-content-end mb-4">
    <a href="{{ route('admin.manifestacoes.create.manual') }}" class="btn btn-primary">
        <i class="fas fa-plus-circle me-2"></i>
        <span class="d-none d-sm-inline">Cadastrar Manualmente</span>
        <span class="d-inline d-sm-none">Manual</span>
    </a>
</div>

    <!-- Filtros -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter me-1"></i> Filtros
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.manifestacoes.index') }}">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="protocolo" class="form-label">Protocolo</label>
                        <input type="text" class="form-control" id="protocolo" name="protocolo"
                            value="{{ request('protocolo') }}" placeholder="Buscar por protocolo...">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="">Todos os Status</option>
                            @foreach($statuses as $key => $value)
                            <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="prioridade" class="form-label">Prioridade</label>
                        <select class="form-control" id="prioridade" name="prioridade">
                            <option value="">Todas as Prioridades</option>
                            @foreach($prioridades as $key => $value)
                            <option value="{{ $key }}" {{ request('prioridade') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="responsavel" class="form-label">Responsável</label>
                        <select class="form-control" id="responsavel" name="responsavel">
                            <option value="">Todos os Responsáveis</option>
                            @foreach($responsaveis as $responsavel)
                            <option value="{{ $responsavel->id }}" {{ request('responsavel') == $responsavel->id ? 'selected' : '' }}>
                                {{ $responsavel->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i> Filtrar
                    </button>
                    <a href="{{ route('admin.manifestacoes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-redo me-1"></i> Limpar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Botões de Status Rápidos -->
    <div class="mb-4">
        <div class="btn-group" role="group">
            <a href="{{ route('admin.manifestacoes.index') }}"
                class="btn {{ !request('status') ? 'btn-primary' : 'btn-outline-primary' }}">
                <i class="fas fa-list me-1"></i> Todas ({{ $manifestacoes->total() }})
            </a>
            <a href="{{ route('admin.manifestacoes.index', ['status' => 'ABERTO']) }}"
                class="btn {{ request('status') == 'ABERTO' ? 'btn-primary' : 'btn-outline-primary' }}">
                <i class="fas fa-clock me-1"></i> Em Aberto
            </a>
            <a href="{{ route('admin.manifestacoes.index', ['status' => 'EM_ANALISE']) }}"
                class="btn {{ request('status') == 'EM_ANALISE' ? 'btn-primary' : 'btn-outline-primary' }}">
                <i class="fas fa-search me-1"></i> Em Análise
            </a>
            <a href="{{ route('admin.manifestacoes.index', ['status' => 'RESPONDIDO']) }}"
                class="btn {{ request('status') == 'RESPONDIDO' ? 'btn-primary' : 'btn-outline-primary' }}">
                <i class="fas fa-check-circle me-1"></i> Respondidas
            </a>
            <a href="{{ route('admin.manifestacoes.index', ['status' => 'FINALIZADO']) }}"
                class="btn {{ request('status') == 'FINALIZADO' ? 'btn-primary' : 'btn-outline-primary' }}">
                <i class="fas fa-archive me-1"></i> Finalizadas
            </a>
        </div>
    </div>

    <!-- Tabela de Manifestações -->
    <div class="card shadow">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table me-1"></i> Lista de Manifestações
            </h6>
            <div class="text-muted">
                Mostrando {{ $manifestacoes->firstItem() }} a {{ $manifestacoes->lastItem() }} de {{ $manifestacoes->total() }}
            </div>
        </div>
        <div class="card-body">
            @if($manifestacoes->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-sm" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="d-none d-md-table-cell">Protocolo</th>
                            <th>Título</th>
                            <th class="d-none d-md-table-cell">Tipo</th>
                            <th>Status</th>
                            <th class="d-none d-sm-table-cell">Prioridade</th>
                            <th class="d-none d-lg-table-cell">Responsável</th>
                            <th class="d-none d-md-table-cell">Data</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($manifestacoes as $manifestacao)
                        <tr>
                            <td class="d-none d-md-table-cell">
                                <strong class="text-primary">#{{ $manifestacao->protocolo }}</strong>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <strong class="text-dark text-truncate" style="max-width: 200px;">
                                        {{ Str::limit($manifestacao->titulo ?? 'Sem título', 30) }}
                                    </strong>
                                    <small class="text-muted d-none d-sm-block">
                                        {{ Str::limit($manifestacao->descricao, 40) }}
                                    </small>
                                    <small class="text-muted d-block d-sm-none">
                                        #{{ $manifestacao->protocolo }}
                                    </small>
                                </div>
                            </td>
                            <td class="d-none d-md-table-cell">
                                <span class="badge d-none-mobile"
                                    style="background-color: {{ $manifestacao->tipo->cor ?? '#6c757d' }}; color: white;">
                                    {{ $manifestacao->tipo->nome ?? 'Não informado' }}
                                </span>
                            </td>
                            <td>
                                @php
                                $statusColors = [
                                'ABERTO' => 'warning',
                                'EM_ANALISE' => 'info',
                                'RESPONDIDO' => 'success',
                                'FINALIZADO' => 'secondary'
                                ];
                                @endphp
                                <span class="badge bg-{{ $statusColors[$manifestacao->status] ?? 'secondary' }}">
                                    <span class="d-none d-sm-inline">{{ $manifestacao->status }}</span>
                                    <span class="d-inline d-sm-none">
                                        @if($manifestacao->status == 'ABERTO') <i class="fas fa-clock"></i>
                                        @elseif($manifestacao->status == 'EM_ANALISE') <i class="fas fa-search"></i>
                                        @elseif($manifestacao->status == 'RESPONDIDO') <i class="fas fa-check"></i>
                                        @else <i class="fas fa-archive"></i>
                                        @endif
                                    </span>
                                </span>
                            </td>
                            <td class="d-none d-sm-table-cell">
                                @php
                                $prioridadeColors = [
                                'baixa' => 'success',
                                'media' => 'info',
                                'alta' => 'warning',
                                'urgente' => 'danger'
                                ];
                                @endphp
                                <span class="badge bg-{{ $prioridadeColors[$manifestacao->prioridade] ?? 'secondary' }}">
                                    {{ ucfirst($manifestacao->prioridade) }}
                                </span>
                            </td>
                            <td class="d-none d-lg-table-cell">
                                @if($manifestacao->responsavel)
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-circle me-2 text-muted d-none d-xl-inline"></i>
                                    <span class="text-truncate" style="max-width: 120px;">
                                        {{ $manifestacao->responsavel->name }}
                                    </span>
                                </div>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="d-none d-md-table-cell">
                                <div class="d-flex flex-column">
                                    <small>{{ $manifestacao->created_at->format('d/m/Y') }}</small>
                                    <small class="text-muted">{{ $manifestacao->created_at->format('H:i') }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.manifestacoes.show', $manifestacao) }}"
                                        class="btn btn-info" title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                        <span class="d-none d-lg-inline ms-1">Ver</span>
                                    </a>
                                    <a href="{{ route('admin.manifestacoes.edit', $manifestacao) }}"
                                        class="btn btn-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                        <span class="d-none d-lg-inline ms-1">Editar</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginação -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
                Mostrando {{ $manifestacoes->firstItem() }} a {{ $manifestacoes->lastItem() }} de {{ $manifestacoes->total() }}
            </div>
            <div>
                {{ $manifestacoes->links() }}
            </div>
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">Nenhuma manifestação encontrada</h4>
            <p class="text-muted">Tente ajustar os filtros ou cadastre uma nova manifestação.</p>
        </div>
        @endif
    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-submit ao alterar filtros
    document.addEventListener('DOMContentLoaded', function() {
        const filtros = document.querySelectorAll('#status, #prioridade, #responsavel');
        filtros.forEach(filtro => {
            filtro.addEventListener('change', function() {
                this.form.submit();
            });
        });
    });
</script>
@endpush