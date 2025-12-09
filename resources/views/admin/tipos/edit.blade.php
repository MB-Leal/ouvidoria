@extends('admin.layouts.app')

@section('title', 'Editar Tipo de Manifestação')

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('admin.tipos.index') }}">Tipos</a></li>
    <li class="breadcrumb-item active" aria-current="page">Editar</li>
@endsection

@section('page-title')
    <i class="fas fa-edit me-2"></i> Editar Tipo: {{ $tipo->nome }}
@endsection

@section('page-actions')
    <a href="{{ route('admin.tipos.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Voltar
    </a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-admin">
            <div class="card-header-admin">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-tag me-1"></i> Editar Informações
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.tipos.update', $tipo) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nome" class="form-label">
                            Nome do Tipo <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('nome') is-invalid @enderror" 
                               id="nome" 
                               name="nome" 
                               value="{{ old('nome', $tipo->nome) }}" 
                               required>
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cor" class="form-label">
                            Cor de Destaque <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="color" 
                                   class="form-control form-control-color @error('cor') is-invalid @enderror" 
                                   id="cor" 
                                   name="cor" 
                                   value="{{ old('cor', $tipo->cor) }}"
                                   title="Selecione uma cor"
                                   required>
                            <input type="text" 
                                   class="form-control @error('cor') is-invalid @enderror" 
                                   value="{{ old('cor', $tipo->cor) }}"
                                   id="cor_hex"
                                   placeholder="#007bff"
                                   maxlength="7">
                        </div>
                        @error('cor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="mt-2">
                            <span class="badge" style="background-color: {{ $tipo->cor }}; color: #FFF; padding: 5px 15px;">
                                Cor atual: {{ $tipo->cor }}
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="prazo_dias" class="form-label">
                                Prazo para Resposta (dias) <span class="text-danger">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control @error('prazo_dias') is-invalid @enderror" 
                                   id="prazo_dias" 
                                   name="prazo_dias" 
                                   value="{{ old('prazo_dias', $tipo->prazo_dias) }}" 
                                   min="1" 
                                   max="365"
                                   required>
                            @error('prazo_dias')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="ativo" class="form-label">Status</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       role="switch" 
                                       id="ativo" 
                                       name="ativo" 
                                       value="1" 
                                       {{ old('ativo', $tipo->ativo) ? 'checked' : '' }}>
                                <label class="form-check-label" for="ativo">
                                    Tipo ativo
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Informações do Tipo -->
                    <div class="card border mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fas fa-info-circle me-1"></i> Informações do Tipo
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row small text-muted">
                                <div class="col-md-6 mb-2">
                                    <strong>ID:</strong> {{ $tipo->id }}
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>Criado em:</strong> {{ $tipo->created_at->format('d/m/Y H:i') }}
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>Atualizado em:</strong> {{ $tipo->updated_at->format('d/m/Y H:i') }}
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong>Manifestações:</strong> {{ $tipo->manifestacoes_count ?? $tipo->manifestacoes()->count() }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botões -->
                    <div class="d-flex justify-content-between border-top pt-4">
                        <div>
                            @if($tipo->manifestacoes()->count() === 0)
                                <button type="button" 
                                        class="btn btn-outline-danger" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal">
                                    <i class="fas fa-trash me-1"></i> Excluir
                                </button>
                            @endif
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.tipos.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-admin-primary">
                                <i class="fas fa-save me-1"></i> Salvar Alterações
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Exclusão -->
@if($tipo->manifestacoes()->count() === 0)
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.tipos.destroy', $tipo) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja excluir o tipo <strong>"{{ $tipo->nome }}"</strong>?</p>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Esta ação não pode ser desfeita.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Excluir Tipo</button>
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
        // Sincronizar input color com input text (mesmo código do create)
        const colorInput = document.getElementById('cor');
        const hexInput = document.getElementById('cor_hex');
        
        if (colorInput && hexInput) {
            colorInput.addEventListener('input', function() {
                hexInput.value = this.value;
            });
            
            hexInput.addEventListener('input', function() {
                const value = this.value;
                if (/^#[0-9A-F]{6}$/i.test(value)) {
                    colorInput.value = value;
                }
            });
            
            hexInput.addEventListener('blur', function() {
                let value = this.value;
                if (!value.startsWith('#')) {
                    value = '#' + value;
                }
                
                if (/^#[0-9A-F]{6}$/i.test(value)) {
                    this.value = value.toUpperCase();
                    colorInput.value = value.toUpperCase();
                } else {
                    this.value = '{{ $tipo->cor }}';
                    colorInput.value = '{{ $tipo->cor }}';
                }
            });
        }
        
        // Validação de prazo
        const prazoInput = document.getElementById('prazo_dias');
        if (prazoInput) {
            prazoInput.addEventListener('change', function() {
                if (this.value < 1) {
                    this.value = 1;
                } else if (this.value > 365) {
                    this.value = 365;
                }
            });
        }
        
        // Focar no primeiro campo
        setTimeout(function() {
            document.getElementById('nome').focus();
        }, 100);
    });
</script>
@endpush