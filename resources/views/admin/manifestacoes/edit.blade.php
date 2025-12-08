@extends('layouts.app')

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
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Erros encontrados:</strong>
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
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Editar Informações</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.manifestacoes.update', $manifestacao) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status *</label>
                                <select name="status" id="status" class="form-control" required>
                                    @foreach($statuses as $key => $value)
                                        <option value="{{ $key }}" 
                                                {{ old('status', $manifestacao->status) == $key ? 'selected' : '' }}>
                                            {{ $value }}
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
                                   value="{{ old('setor_responsavel', $manifestacao->setor_responsavel)