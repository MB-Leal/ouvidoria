@extends('layouts.app')

@section('title', 'Gerenciar Usuários')

@section('content')
<div class="container-fluid py-4">
    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-users me-2"></i> Gerenciar Usuários
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Usuários</li>
                </ol>
            </nav>
        </div>
        <div>
            @can('create', App\Models\User::class)
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> 
                <span class="d-none d-sm-inline">Novo Usuário</span>
            </a>
            @endcan
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <div class="card border-left-primary shadow mb-4">
    <div class="card-body py-3">
        <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    Gerenciamento de Usuários
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ $users->total() }} usuários cadastrados
                </div>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-circle btn-lg">
                    <i class="fas fa-user-plus fa-2x"></i>
                </a>
            </div>
        </div>
    </div>
</div>

    <!-- Card de Listagem -->
    <div class="card shadow">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list me-1"></i> Lista de Usuários
            </h6>
            <div class="text-muted small">
                Total: {{ $users->total() }} usuários
            </div>
        </div>
        <div class="card-body">
            @if($users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th class="d-none d-md-table-cell">Email</th>
                                <th>Função</th>
                                <th class="d-none d-sm-table-cell">Status</th>
                                <th class="d-none d-lg-table-cell">Cadastro</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px;">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <strong>{{ $user->name }}</strong>
                                                <div class="text-muted small d-block d-md-none">
                                                    {{ $user->email }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        <div class="text-truncate" style="max-width: 200px;">
                                            {{ $user->email }}
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $roleColors = [
                                                'admin' => 'danger',
                                                'ouvidor' => 'warning',
                                                'secretario' => 'info',
                                                'cidadao' => 'secondary'
                                            ];
                                            $roleLabels = [
                                                'admin' => 'Administrador',
                                                'ouvidor' => 'Ouvidor',
                                                'secretario' => 'Secretário',
                                                'cidadao' => 'Cidadão'
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $roleColors[$user->role] ?? 'secondary' }}">
                                            {{ $roleLabels[$user->role] ?? ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="d-none d-sm-table-cell">
                                        @if($user->ativo)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>
                                                <span class="d-none d-md-inline">Ativo</span>
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times-circle me-1"></i>
                                                <span class="d-none d-md-inline">Inativo</span>
                                            </span>
                                        @endif
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        <div class="text-muted small">
                                            {{ $user->created_at->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
        <!-- Botão Editar -->
        <a href="{{ route('admin.users.edit', $user) }}" 
           class="btn btn-warning" 
           title="Editar usuário">
            <i class="fas fa-edit"></i>
            <span class="d-none d-lg-inline ms-1">Editar</span>
        </a>
        
        <!-- Botão Excluir (não mostrar para o próprio usuário logado) -->
        @if($user->id !== auth()->id())
            <button type="button" 
                    class="btn btn-danger" 
                    title="Excluir usuário"
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteModal{{ $user->id }}">
                <i class="fas fa-trash"></i>
                <span class="d-none d-lg-inline ms-1">Excluir</span>
            </button>
        @endif
    </div>

    <!-- Modal de Confirmação de Exclusão -->
    @if($user->id !== auth()->id())
    <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                            Confirmar Exclusão
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Tem certeza que deseja excluir o usuário <strong>{{ $user->name }}</strong>?</p>
                        <div class="alert alert-warning small">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Atenção:</strong> Esta ação não pode ser desfeita.
                        </div>
                        <div class="form-check mt-3">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="confirmDelete{{ $user->id }}" 
                                   required>
                            <label class="form-check-label" for="confirmDelete{{ $user->id }}">
                                Confirmo que desejo excluir este usuário permanentemente
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-danger" id="deleteButton{{ $user->id }}" disabled>
                            <i class="fas fa-trash me-1"></i> Excluir Usuário
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginação -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Mostrando {{ $users->firstItem() }} a {{ $users->lastItem() }} de {{ $users->total() }}
                    </div>
                    <div>
                        {{ $users->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">Nenhum usuário cadastrado</h4>
                    <p class="text-muted mb-4">Comece cadastrando o primeiro usuário do sistema.</p>
                    @can('create', App\Models\User::class)
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Cadastrar Primeiro Usuário
                    </a>
                    @endcan
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-dismiss alerts
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });

     document.addEventListener('DOMContentLoaded', function() {
        // Ativar tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Auto-dismiss alerts
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
        
        // Validação para checkboxes dos modais
        document.querySelectorAll('[id^="confirmDelete"]').forEach(function(checkbox) {
            var modalId = checkbox.id.replace('confirmDelete', '');
            var deleteButton = document.getElementById('deleteButton' + modalId);
            
            if (checkbox && deleteButton) {
                checkbox.addEventListener('change', function() {
                    deleteButton.disabled = !this.checked;
                });
            }
        });
    });
</script>
@endpush