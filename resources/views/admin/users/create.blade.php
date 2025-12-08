@extends('layouts.app')

@section('title', 'Cadastrar Novo Usuário')

@section('content')
<div class="container-fluid py-4">
    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-user-plus me-2"></i> Cadastrar Novo Usuário
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Usuários</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Novo</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> 
                <span class="d-none d-sm-inline">Voltar</span>
            </a>
        </div>
    </div>

    <!-- Card do Formulário -->
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user-circle me-1"></i> Informações do Usuário
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf

                        <!-- Nome -->
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                Nome Completo <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required
                                   placeholder="Digite o nome completo">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                E-mail <span class="text-danger">*</span>
                            </label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required
                                   placeholder="exemplo@dominio.com">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Função -->
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label">
                                    Função <span class="text-danger">*</span>
                                </label>
                                <select class="form-control @error('role') is-invalid @enderror" 
                                        id="role" 
                                        name="role" 
                                        required>
                                    <option value="">Selecione uma função</option>
                                    @foreach($roles as $key => $label)
                                        <option value="{{ $key }}" {{ old('role') == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-3">
                                <label for="ativo" class="form-label">Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           role="switch" 
                                           id="ativo" 
                                           name="ativo" 
                                           value="1" 
                                           {{ old('ativo', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="ativo">
                                        Usuário ativo
                                    </label>
                                </div>
                                <small class="text-muted">Usuários inativos não conseguem acessar o sistema.</small>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Senha -->
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">
                                    Senha <span class="text-danger">*</span>
                                </label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       required
                                       placeholder="Mínimo 8 caracteres">
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Confirmação de Senha -->
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">
                                    Confirmar Senha <span class="text-danger">*</span>
                                </label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       required
                                       placeholder="Digite a senha novamente">
                            </div>
                        </div>

                        <!-- Botões -->
                        <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Cadastrar Usuário
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Card de Ajuda -->
            <div class="card shadow mt-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-info-circle me-1"></i> Sobre as Funções
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-primary">
                                <span class="badge bg-danger me-2">Admin</span> Administrador
                            </h6>
                            <p class="small text-muted mb-0">
                                Acesso completo ao sistema, incluindo gerenciamento de usuários e todas as funcionalidades.
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-primary">
                                <span class="badge bg-warning me-2">Ouvidor</span> Ouvidor
                            </h6>
                            <p class="small text-muted mb-0">
                                Pode visualizar, responder e gerenciar manifestações, mas não pode gerenciar usuários.
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-primary">
                                <span class="badge bg-info me-2">Secretário</span> Secretário
                            </h6>
                            <p class="small text-muted mb-0">
                                Acesso limitado para visualização e acompanhamento de manifestações atribuídas.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-switch .form-check-input {
        width: 3em;
        height: 1.5em;
    }
</style>
@endpush