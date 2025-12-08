@extends('layouts.app')

@section('title', 'Editar Usuário')

@section('content')
<div class="container-fluid py-4">
    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-user-edit me-2"></i> Editar Usuário
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Usuários</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Editar</li>
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
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user-circle me-1"></i> Editar Informações
                    </h6>
                    <div>
                        <span class="badge bg-{{ $user->ativo ? 'success' : 'danger' }}">
                            {{ $user->ativo ? 'Ativo' : 'Inativo' }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Nome -->
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                Nome Completo <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   required>
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
                                   value="{{ old('email', $user->email) }}" 
                                   required>
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
                                    @foreach($roles as $key => $label)
                                        <option value="{{ $key }}" 
                                                {{ old('role', $user->role) == $key ? 'selected' : '' }}>
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
                                           {{ old('ativo', $user->ativo) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="ativo">
                                        Usuário ativo
                                    </label>
                                </div>
                                <small class="text-muted">Desative para bloquear o acesso.</small>
                            </div>
                        </div>

                        <!-- Alterar Senha (Opcional) -->
                        <div class="card border mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="fas fa-key me-1"></i> Alterar Senha
                                    <small class="text-muted">(Opcional)</small>
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label">Nova Senha</label>
                                        <input type="password" 
                                               class="form-control @error('password') is-invalid @enderror" 
                                               id="password" 
                                               name="password" 
                                               placeholder="Deixe em branco para manter">
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
                                        <input type="password" 
                                               class="form-control" 
                                               id="password_confirmation" 
                                               name="password_confirmation" 
                                               placeholder="Confirme a nova senha">
                                    </div>
                                </div>
                                <div class="alert alert-info small mb-0">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Preencha apenas se desejar alterar a senha. A senha deve ter no mínimo 8 caracteres.
                                </div>
                            </div>
                        </div>

                        <!-- Informações do Usuário -->
                        <div class="card border mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="fas fa-info-circle me-1"></i> Informações do Usuário
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row small text-muted">
                                    <div class="col-md-6 mb-2">
                                        <strong>ID:</strong> {{ $user->id }}
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <strong>Cadastrado em:</strong> {{ $user->created_at->format('d/m/Y H:i') }}
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <strong>Última atualização:</strong> {{ $user->updated_at->format('d/m/Y H:i') }}
                                    </div>
                                    @if($user->email_verified_at)
                                        <div class="col-md-6 mb-2">
                                            <strong>Email verificado em:</strong> {{ $user->email_verified_at->format('d/m/Y H:i') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Botões -->
                        <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                            <div>
                                @if($user->id !== auth()->id())
                                    <button type="button" 
                                            class="btn btn-outline-danger" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal">
                                        <i class="fas fa-trash me-1"></i> Excluir
                                    </button>
                                @endif
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Salvar Alterações
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Exclusão -->
@if($user->id !== auth()->id())
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja excluir o usuário <strong>{{ $user->name }}</strong>?</p>
                    
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Atenção!</strong> Esta ação não pode ser desfeita.
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="confirmDelete" required>
                        <label class="form-check-label" for="confirmDelete">
                            Eu entendo que esta ação é irreversível
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger" id="deleteButton" disabled>
                        Confirmar Exclusão
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Habilitar botão de exclusão apenas quando confirmado
        const confirmCheckbox = document.getElementById('confirmDelete');
        const deleteButton = document.getElementById('deleteButton');
        
        if (confirmCheckbox && deleteButton) {
            confirmCheckbox.addEventListener('change', function() {
                deleteButton.disabled = !this.checked;
            });
        }
        
        // Validação de senha
        const password = document.getElementById('password');
        const passwordConfirmation = document.getElementById('password_confirmation');
        
        function validatePassword() {
            if (password.value && password.value.length < 8) {
                password.classList.add('is-invalid');
                return false;
            } else {
                password.classList.remove('is-invalid');
            }
            
            if (password.value !== passwordConfirmation.value) {
                passwordConfirmation.classList.add('is-invalid');
                return false;
            } else {
                passwordConfirmation.classList.remove('is-invalid');
            }
            
            return true;
        }
        
        if (password && passwordConfirmation) {
            password.addEventListener('input', validatePassword);
            passwordConfirmation.addEventListener('input', validatePassword);
        }
    });
</script>
@endpush