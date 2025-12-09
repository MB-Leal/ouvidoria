@extends('admin.layouts.app')

@section('title', 'Cadastrar Novo Tipo de Manifestação')

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('admin.tipos.index') }}">Tipos</a></li>
    <li class="breadcrumb-item active" aria-current="page">Novo</li>
@endsection

@section('page-title')
    <i class="fas fa-plus-circle me-2"></i> Cadastrar Novo Tipo
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
                    <i class="fas fa-tag me-1"></i> Informações do Tipo
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.tipos.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nome" class="form-label">
                            Nome do Tipo <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('nome') is-invalid @enderror" 
                               id="nome" 
                               name="nome" 
                               value="{{ old('nome') }}" 
                               required
                               placeholder="Ex: Reclamação, Elogio, Sugestão">
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Nome descritivo do tipo de manifestação.</small>
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
                                   value="{{ old('cor', '#007bff') }}"
                                   title="Selecione uma cor"
                                   required>
                            <input type="text" 
                                   class="form-control @error('cor') is-invalid @enderror" 
                                   value="{{ old('cor', '#007bff') }}"
                                   id="cor_hex"
                                   placeholder="#007bff"
                                   maxlength="7">
                        </div>
                        @error('cor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Cor que será usada para identificar este tipo no sistema.</small>
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
                                   value="{{ old('prazo_dias', 30) }}" 
                                   min="1" 
                                   max="365"
                                   required>
                            @error('prazo_dias')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Prazo padrão em dias para responder este tipo de manifestação.</small>
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
                                       {{ old('ativo', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="ativo">
                                    Tipo ativo
                                </label>
                            </div>
                            <small class="text-muted">Tipos inativos não aparecem nas listas de seleção.</small>
                        </div>
                    </div>

                    <!-- Botões -->
                    <div class="d-flex justify-content-between border-top pt-4">
                        <a href="{{ route('admin.tipos.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-admin-primary">
                            <i class="fas fa-save me-1"></i> Salvar Tipo
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Card de Ajuda -->
        <div class="card-admin mt-4">
            <div class="card-header-admin">
                <h6 class="m-0 font-weight-bold text-info">
                    <i class="fas fa-info-circle me-1"></i> Sobre os Tipos de Manifestação
                </h6>
            </div>
            <div class="card-body">
                <h6 class="text-primary mb-3">Tipos Recomendados:</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <div class="me-2" style="width: 20px; height: 20px; background-color: #dc3545; border-radius: 3px;"></div>
                            <strong>Reclamação</strong>
                        </div>
                        <p class="small text-muted mb-0">Para relatar problemas, insatisfações ou irregularidades.</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <div class="me-2" style="width: 20px; height: 20px; background-color: #28a745; border-radius: 3px;"></div>
                            <strong>Elogio</strong>
                        </div>
                        <p class="small text-muted mb-0">Para reconhecer e valorizar serviços bem prestados.</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <div class="me-2" style="width: 20px; height: 20px; background-color: #17a2b8; border-radius: 3px;"></div>
                            <strong>Sugestão</strong>
                        </div>
                        <p class="small text-muted mb-0">Para propor melhorias ou novas ideias.</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <div class="me-2" style="width: 20px; height: 20px; background-color: #ffc107; border-radius: 3px;"></div>
                            <strong>Denúncia</strong>
                        </div>
                        <p class="small text-muted mb-0">Para reportar condutas irregulares ou ilegais.</p>
                    </div>
                </div>
                
                <div class="alert alert-info small mt-3 mb-0">
                    <i class="fas fa-lightbulb me-2"></i>
                    <strong>Dica:</strong> Use cores distintas para facilitar a identificação visual dos tipos no sistema.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sincronizar input color com input text
        const colorInput = document.getElementById('cor');
        const hexInput = document.getElementById('cor_hex');
        
        if (colorInput && hexInput) {
            // Quando mudar o color picker
            colorInput.addEventListener('input', function() {
                hexInput.value = this.value;
            });
            
            // Quando mudar o input de texto
            hexInput.addEventListener('input', function() {
                const value = this.value;
                // Verificar se é uma cor hexadecimal válida
                if (/^#[0-9A-F]{6}$/i.test(value)) {
                    colorInput.value = value;
                }
            });
            
            // Validar cor hexadecimal ao sair do campo
            hexInput.addEventListener('blur', function() {
                let value = this.value;
                if (!value.startsWith('#')) {
                    value = '#' + value;
                }
                
                // Verificar formato hexadecimal
                if (/^#[0-9A-F]{6}$/i.test(value)) {
                    this.value = value.toUpperCase();
                    colorInput.value = value.toUpperCase();
                } else {
                    // Cor padrão se inválida
                    this.value = '#007bff';
                    colorInput.value = '#007bff';
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

@push('styles')
<style>
    .form-control-color {
        height: 45px;
        width: 70px;
        padding: 5px;
    }
    
    /* Estilo para visualização de cores */
    .color-preview {
        width: 30px;
        height: 30px;
        border-radius: 4px;
        display: inline-block;
        margin-right: 10px;
        border: 1px solid #dee2e6;
    }
</style>
@endpush