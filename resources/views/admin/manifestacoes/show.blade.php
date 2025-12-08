@extends('admin.layouts.app')

@section('title', 'Detalhes da Manifestação')

@section('content')
<div class="container-fluid py-4">
    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-file-alt me-2"></i> Manifestação #{{ $manifestacao->protocolo }}
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.manifestacoes.index') }}">Manifestações</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detalhes</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.manifestacoes.edit', $manifestacao) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> Editar
            </a>
            <a href="{{ route('admin.manifestacoes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Voltar
            </a>
        </div>
    </div>

    <!-- Mensagens de Sucesso/Erro -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Coluna Esquerda: Informações da Manifestação -->
        <div class="col-lg-8">
            <!-- Card Principal -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Informações da Manifestação</h6>
                    <div>
                        @php
                            $statusColors = [
                                'ABERTO' => 'warning',
                                'EM_ANALISE' => 'info',
                                'RESPONDIDO' => 'success',
                                'FINALIZADO' => 'secondary'
                            ];
                        @endphp
                        <span class="badge bg-{{ $statusColors[$manifestacao->status] ?? 'secondary' }} fs-6">
                            {{ $manifestacao->status }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted small mb-1">Protocolo</label>
                                <div class="fs-5">
                                    <strong class="text-primary">#{{ $manifestacao->protocolo }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted small mb-1">Data de Abertura</label>
                                <div class="fs-5">
                                    <strong>{{ $manifestacao->created_at->format('d/m/Y H:i') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted small mb-1">Título / Assunto</label>
                        <div class="fs-5">
                            <strong>{{ $manifestacao->titulo ?? 'Sem título' }}</strong>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted small mb-1">Descrição Completa</label>
                        <div class="border rounded p-3 bg-light">
                            {!! nl2br(e($manifestacao->descricao)) !!}
                        </div>
                    </div>

                    <!-- Anexo -->
                    @if($manifestacao->anexo_path)
                        <div class="mb-4">
                            <label class="form-label text-muted small mb-1">Anexo</label>
                            <div>
                                <a href="{{ asset('storage/' . $manifestacao->anexo_path) }}" 
                                   target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-paperclip me-1"></i> Visualizar Anexo
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Resposta (se houver) -->
                    @if($manifestacao->resposta)
                        <div class="mt-4 pt-4 border-top">
                            <label class="form-label text-muted small mb-1">Resposta da Ouvidoria</label>
                            <div class="border rounded p-3 bg-light">
                                {!! nl2br(e($manifestacao->resposta)) !!}
                            </div>
                            @if($manifestacao->respondido_em)
                                <div class="text-end mt-2 text-muted small">
                                    Respondido em: {{ $manifestacao->respondido_em->format('d/m/Y H:i') }}
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Coluna Direita: Metadados e Ações -->
        <div class="col-lg-4">
            <!-- Card de Status -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Status e Prioridade</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted small mb-1">Status Atual</label>
                        <div>
                            @php
                                $statusColors = [
                                    'ABERTO' => 'warning',
                                    'EM_ANALISE' => 'info',
                                    'RESPONDIDO' => 'success',
                                    'FINALIZADO' => 'secondary'
                                ];
                            @endphp
                            <span class="badge bg-{{ $statusColors[$manifestacao->status] ?? 'secondary' }} fs-6 px-3 py-2">
                                {{ $manifestacao->status }}
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small mb-1">Prioridade</label>
                        <div>
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
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small mb-1">Tipo</label>
                        <div>
                            <span class="badge" style="background-color: {{ $manifestacao->tipo->cor ?? '#6c757d' }}; color: white;">
                                {{ $manifestacao->tipo->nome ?? 'Não informado' }}
                            </span>
                        </div>
                    </div>

                    @if($manifestacao->data_limite_resposta)
                        <div class="mb-3">
                            <label class="form-label text-muted small mb-1">Prazo de Resposta</label>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar-alt me-2 text-muted"></i>
                                <strong class="{{ $manifestacao->data_limite_resposta < now() ? 'text-danger' : 'text-success' }}">
                                    {{ $manifestacao->data_limite_resposta->format('d/m/Y') }}
                                </strong>
                                @if($manifestacao->data_limite_resposta < now() && $manifestacao->status != 'RESPONDIDO')
                                    <span class="badge bg-danger ms-2">ATRASADO</span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Card de Responsáveis -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Responsáveis</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted small mb-1">Manifestante</label>
                        <div>
                            <i class="fas fa-user me-2 text-muted"></i>
                            <span>{{ $manifestacao->nome ?? 'Anônimo' }}</span>
                        </div>
                        @if($manifestacao->email)
                            <div class="text-muted small ms-4">
                                <i class="fas fa-envelope me-1"></i> {{ $manifestacao->email }}
                            </div>
                        @endif
                        @if($manifestacao->telefone)
                            <div class="text-muted small ms-4">
                                <i class="fas fa-phone me-1"></i> {{ $manifestacao->telefone }}
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small mb-1">Responsável Atual</label>
                        <div>
                            @if($manifestacao->responsavel)
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-check me-2 text-success"></i>
                                    <div>
                                        <strong>{{ $manifestacao->responsavel->name }}</strong>
                                        <div class="text-muted small">{{ $manifestacao->responsavel->role }}</div>
                                    </div>
                                </div>
                            @else
                                <div class="text-muted">
                                    <i class="fas fa-user-times me-2"></i> Não atribuído
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Ações Rápidas -->
                    @if($manifestacao->status != 'FINALIZADO')
                        <div class="mt-4 pt-3 border-top">
                            <label class="form-label text-muted small mb-2">Ações Rápidas</label>
                            <div class="d-grid gap-2">
                                <!-- Atribuir -->
                                @if(!$manifestacao->responsavel)
                                    <button type="button" class="btn btn-outline-primary btn-sm" 
                                            data-bs-toggle="modal" data-bs-target="#atribuirModal">
                                        <i class="fas fa-user-check me-1"></i> Atribuir Responsável
                                    </button>
                                @endif

                                <!-- Arquivar -->
                                @if(!$manifestacao->arquivado_em)
                                    <button type="button" class="btn btn-outline-danger btn-sm" 
                                            data-bs-toggle="modal" data-bs-target="#arquivarModal">
                                        <i class="fas fa-archive me-1"></i> Arquivar Manifestação
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Card de Informações Adicionais -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informações Adicionais</h6>
                </div>
                <div class="card-body">
                    @if($manifestacao->setor_responsavel)
                        <div class="mb-3">
                            <label class="form-label text-muted small mb-1">Setor Responsável</label>
                            <div>
                                <i class="fas fa-building me-2 text-muted"></i>
                                {{ $manifestacao->setor_responsavel }}
                            </div>
                        </div>
                    @endif

                    @if($manifestacao->canal)
                        <div class="mb-3">
                            <label class="form-label text-muted small mb-1">Canal de Entrada</label>
                            <div>
                                <i class="fas fa-sign-in-alt me-2 text-muted"></i>
                                {{ $manifestacao->canal }}
                            </div>
                        </div>
                    @endif

                    @if($manifestacao->observacao_interna)
                        <div class="mb-3">
                            <label class="form-label text-muted small mb-1">Observações Internas</label>
                            <div class="border rounded p-2 bg-light small">
                                {!! nl2br(e($manifestacao->observacao_interna)) !!}
                            </div>
                        </div>
                    @endif

                    @if($manifestacao->arquivado_em)
                        <div class="alert alert-warning small">
                            <i class="fas fa-archive me-1"></i>
                            <strong>Arquivada em:</strong> {{ $manifestacao->arquivado_em->format('d/m/Y H:i') }}
                            @if($manifestacao->motivo_arquivamento)
                                <div class="mt-1">
                                    <strong>Motivo:</strong> {{ $manifestacao->motivo_arquivamento }}
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Atribuir -->
<div class="modal fade" id="atribuirModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.manifestacoes.atribuir', $manifestacao) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Atribuir Responsável</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Atribuir manifestação <strong>#{{ $manifestacao->protocolo }}</strong> para:</p>
                    <select name="user_id" class="form-control" required>
                        <option value="">Selecione um responsável</option>
                        @php
                            $responsaveis = \App\Models\User::where('ativo', true)->get();
                        @endphp
                        @foreach($responsaveis as $responsavel)
                            <option value="{{ $responsavel->id }}">
                                {{ $responsavel->name }} ({{ $responsavel->role }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Atribuir</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Arquivar -->
<div class="modal fade" id="arquivarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.manifestacoes.arquivar', $manifestacao) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Arquivar Manifestação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja arquivar a manifestação <strong>#{{ $manifestacao->protocolo }}</strong>?</p>
                    <div class="mb-3">
                        <label for="motivo" class="form-label">Motivo do Arquivamento</label>
                        <textarea name="motivo_arquivamento" class="form-control" 
                                  rows="3" required placeholder="Informe o motivo..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Confirmar Arquivamento</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .breadcrumb {
        background-color: transparent;
        padding: 0;
        margin-bottom: 0;
    }
</style>
@endpush