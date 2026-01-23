@extends('admin.layouts.app')

@section('title', 'Editar Manifestação')

@section('content')
<div class="container-fluid py-4">
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

    <div class="row">
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
                            <label for="user_id" class="form-label">Responsável (Técnico)</label>
                            <select name="user_id" id="user_id" class="form-control select2">
                                <option value="">Selecione um responsável</option>
                                @foreach($responsaveis as $responsavel)
                                <option value="{{ $responsavel->id }}"
                                    {{ old('user_id', $manifestacao->user_id) == $responsavel->id ? 'selected' : '' }}>
                                    {{ $responsavel->name }} ({{ $responsavel->role }})
                                </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- NOVO CAMPO DE SETOR COM DROPDOWN E PESQUISA --}}
                        <div class="mb-3">
                            <label for="setor_responsavel" class="form-label">Setor Responsável</label>
                            <select name="setor_responsavel" id="setor_responsavel" class="form-control select2">
                                <option value="">Selecione o setor...</option>
                                @php
                                    $setores = [
                                        'Diretoria', 'Subdiretoria', 'Adm. Financeira', 'Orç. e Exec. Financeira',
                                        'CCC', 'Desenvolvimento', 'T.I.', 'Contratos', 'Jurídico Interno',
                                        'Jurídico Externo', 'Serv. Social', 'Secretaria', 'Transporte',
                                        'Arma Legal', 'Cadastro e Cob.', 'Almoxarifado', 'Controle Interno',
                                        'Ouvidoria', 'Farmafas', 'Fardafas', 'Casa de Apoio', 'Representações', 'Outros'
                                    ];
                                @endphp
                                @foreach($setores as $setor)
                                    <option value="{{ $setor }}" {{ old('setor_responsavel', $manifestacao->setor_responsavel) == $setor ? 'selected' : '' }}>
                                        {{ $setor }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="data_limite_resposta" class="form-label">Data Limite para Resposta conclusiva</label>
                            <input type="date" name="data_limite_resposta" id="data_limite_resposta"
                                class="form-control"
                                value="{{ old('data_limite_resposta', $manifestacao->data_limite_resposta ? $manifestacao->data_limite_resposta->format('Y-m-d') : '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="data_resposta" class="form-label">Data da Resposta</label>
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
                            Ao salvar, o sistema registrará o seu usuário ({{ auth()->user()->name }}) como o último editor deste protocolo.
                        </div>

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

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Resumo da Demanda</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted small mb-1">Protocolo</label>
                        <div class="fs-5 text-primary fw-bold">#{{ $manifestacao->protocolo }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small mb-1">Manifestante</label>
                        <div>
                            <strong>{{ $manifestacao->nome ?? 'Anônimo' }}</strong>
                            <div class="text-muted small">{{ $manifestacao->email }}</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small mb-1">Assunto Original</label>
                        <div class="fw-bold">{{ $manifestacao->assunto }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small mb-1">Descrição</label>
                        <div class="p-2 bg-light border rounded small" style="max-height: 200px; overflow-y: auto;">
                            {{ $manifestacao->descricao }}
                        </div>
                    </div>

                    @if($manifestacao->anexo_path)
                    <div class="mt-3">
                        <a href="{{ asset('storage/' . $manifestacao->anexo_path) }}" target="_blank" class="btn btn-sm btn-outline-primary w-100">
                            <i class="fas fa-paperclip me-1"></i> Ver Anexo Enviado
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

<style>
    .select2-container--bootstrap-5 .select2-selection {
        border-radius: 0.375rem;
        min-height: 38px;
    }
    .card.shadow { position: relative; z-index: 10; }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: 'Pesquisar...',
            language: {
                noResults: function() { return "Nenhum resultado encontrado"; }
            }
        });
    });
</script>
@endpush