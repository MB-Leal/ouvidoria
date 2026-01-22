@extends('admin.layouts.app')

@section('title', 'Editar Manifestação')

@section('content')
<div class="container-fluid py-4">
    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-edit me-2"></i> Editar Manifestação #{{ $manifestacao->protocolo }}
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.manifestacoes.index') }}">Manifestações</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.manifestacoes.show', $manifestacao) }}">#{{ $manifestacao->protocolo }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Editar</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.manifestacoes.show', $manifestacao) }}" class="btn btn-secondary">
                <i class="fas fa-times me-1"></i> Cancelar
            </a>
        </div>
    </div>

    <!-- Mensagens de Sucesso/Erro -->
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        <!-- Coluna Esquerda: Formulário -->
        <div class="col-lg-8">
            <div class="card shadow mb-4" style="position: relative; z-index: 1050;">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Editar Informações</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.manifestacoes.update', $manifestacao) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <select name="status" class="form-select" required>
                                    @foreach($statuses as $value => $label)
                                    <option value="{{ $value }}" {{ $manifestacao->status == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="prioridade" class="form-label">Prioridade *</label>
                                <select name="prioridade" id="prioridade" class="form-control" required>
                                    @foreach($prioridades as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ old('prioridade', $manifestacao->prioridade) == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="user_id" class="form-label">Responsável</label>
                            <select name="user_id" id="user_id" class="form-control">
                                <option value="">Selecione um responsável</option>
                                @foreach($responsaveis as $responsavel)
                                <option value="{{ $responsavel->id }}"
                                    {{ old('user_id', $manifestacao->user_id) == $responsavel->id ? 'selected' : '' }}>
                                    {{ $responsavel->name }} ({{ $responsavel->role }})
                                </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Deixe em branco para não atribuir</small>
                        </div>

                        <div class="mb-3">
                            <label for="setor_responsavel" class="form-label">Setor Responsável</label>
                            <input type="text" name="setor_responsavel" id="setor_responsavel"
                                class="form-control"
                                value="{{ old('setor_responsavel', $manifestacao->setor_responsavel) }}"
                                placeholder="Ex: Departamento de Atendimento">
                        </div>

                        <div class="mb-3">
                            <label for="data_limite_resposta" class="form-label">Data Limite para Resposta conclusiva</label>
                            <input type="date" name="data_limite_resposta" id="data_limite_resposta"
                                class="form-control"
                                value="{{ old('data_limite_resposta', $manifestacao->data_limite_resposta ? $manifestacao->data_limite_resposta->format('Y-m-d') : '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="data_limite_resposta" class="form-label">Data da Resposta</label>
                            <input type="date" name="data_resposta" id="data_resposta"
                                class="form-control"
                                value="{{ old('data_resposta', $manifestacao->data_resposta ? $manifestacao->data_resposta->format('Y-m-d') : '') }}">
                        </div>

                        <div class="mb-3">
                            <label for="resposta" class="form-label">Resposta da Ouvidoria</label>
                            <textarea name="resposta" id="resposta"
                                class="form-control"
                                rows="5"
                                placeholder="Digite a resposta para o manifestante...">{{ old('resposta', $manifestacao->resposta) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="observacao_interna" class="form-label">Observação Interna</label>
                            <textarea name="observacao_interna" id="observacao_interna"
                                class="form-control"
                                rows="3"
                                placeholder="Observações para uso interno da equipe...">{{ old('observacao_interna', $manifestacao->observacao_interna) }}</textarea>
                        </div>

                        <div class="alert alert-light border small mt-3">
        <i class="fas fa-info-circle me-1"></i> 
        Ao guardar, o sistema registará o seu utilizador ({{ auth()->user()->name }}) como o último editor deste protocolo.
    </div>

                        <!-- Botões -->
                        <div class="d-flex justify-content-between border-top pt-4">
                            <a href="{{ route('admin.manifestacoes.show', $manifestacao) }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Salvar Alterações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Coluna Direita: Informações da Manifestação -->
        <div class="col-lg-4">
            <div class="card shadow mb-4" style="position: relative; z-index: 1050;">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informações da Manifestação</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted small mb-1">Protocolo</label>
                        <div class="fs-5">
                            <strong class="text-primary">#{{ $manifestacao->protocolo }}</strong>
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
                            <span class="badge bg-{{ $statusColors[$manifestacao->status] ?? 'secondary' }}">
                                {{ $manifestacao->status }}
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small mb-1">Prioridade Atual</label>
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
                        <label class="form-label text-muted small mb-1">Canal</label>
                        <div>
                            <span class="badge bg-info">
                                {{ $manifestacao->canal }}
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small mb-1">Assunto</label>
                        <div>
                            <strong>{{ $manifestacao->assunto ?? 'Sem assunto' }}</strong>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small mb-1">Descrição</label>
                        <div class="border rounded p-2 bg-light small">
                            {{ Str::limit($manifestacao->descricao, 150) }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small mb-1">Manifestante</label>
                        <div>
                            <strong>{{ $manifestacao->nome ?? 'Anônimo' }}</strong>
                            @if($manifestacao->email)
                            <div class="text-muted small">{{ $manifestacao->email }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small mb-1">Data de Entrada</label>
                        <div>
                            <strong>{{ $manifestacao->data_entrada ? $manifestacao->data_entrada->format('d/m/Y H:i') : $manifestacao->created_at->format('d/m/Y H:i') }}</strong>
                        </div>
                    </div>

                    @if($manifestacao->sigilo_dados)
                    <div class="alert alert-info small mb-0">
                        <i class="fas fa-shield-alt me-2"></i>
                        <strong>Sigilo Solicitado:</strong> O manifestante solicitou sigilo dos dados pessoais.
                    </div>
                    @endif

                    @if($manifestacao->anexo_path)
                    <div class="mb-3">
                        <label class="form-label text-muted small mb-1">Anexo</label>
                        <div>
                            <a href="{{ asset('storage/' . $manifestacao->anexo_path) }}"
                                target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-paperclip me-1"></i> Visualizar Anexo
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Corrigir sobreposição do menu lateral */
    .main-content-admin {
        position: relative;
        z-index: 1;
    }

    /* Garantir que o conteúdo da página fique acima */
    .container-fluid.py-4 {
        position: relative;
        z-index: 2;
    }

    /* Cards com z-index alto */
    .card.shadow {
        position: relative;
        z-index: 1050 !important;
    }

    /* Garantir que selects apareçam corretamente */
    .form-control,
    .form-select {
        position: relative;
        z-index: 1060 !important;
    }

    /* Dropdowns acima de tudo */
    .dropdown-menu {
        z-index: 1100 !important;
    }

    /* Modais acima de tudo */
    .modal {
        z-index: 1200 !important;
    }
</style>
@endpush