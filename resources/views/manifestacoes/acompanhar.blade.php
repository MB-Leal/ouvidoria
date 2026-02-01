@extends('layouts.app')

@section('title', 'Acompanhar Manifestação - Ouvidoria FASPM/PA')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card card-faspm shadow">
            <div class="card-header bg-faspm text-white">
                <h4 class="mb-0">
                    <i class="bi bi-search me-2"></i>
                    Acompanhar Manifestação
                </h4>
            </div>
            <div class="card-body p-4">
                <div class="alert alert-info border-0 shadow-sm mb-4">
                    <div class="d-flex">
                        <i class="bi bi-shield-lock-fill fs-4 me-3"></i>
                        <div>
                            <strong>Consulta Segura (LGPD)</strong><br>
                            Para sua segurança, além do protocolo, é necessário informar a chave de acesso (token) gerada no momento do registro.
                        </div>
                    </div>
                </div>

                <form action="{{ route('manifestacoes.buscar') }}" method="POST" id="form-acompanhar">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="protocolo" class="form-label fw-bold text-primary">
                            <i class="bi bi-hash me-1"></i> Número do Protocolo *
                        </label>
                        <input type="text" 
                               class="form-control form-control-lg @error('protocolo') is-invalid @enderror" 
                               id="protocolo" 
                               name="protocolo" 
                               placeholder="Ex: FASPM.2025.0001"
                               value="{{ old('protocolo') }}" 
                               required>
                        <small class="text-muted">Informe o protocolo completo recebido.</small>
                    </div>

                    <div class="mb-4">
                        <label for="chave" class="form-label fw-bold text-primary">
                            <i class="bi bi-key me-1"></i> Chave de Acesso (Token) *
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                            <input type="text" 
                                   class="form-control form-control-lg @error('protocolo') is-invalid @enderror" 
                                   id="chave" 
                                   name="chave" 
                                   placeholder="TOKEN de 7 caracteres"
                                   style="text-transform: uppercase; letter-spacing: 2px; font-weight: bold;"
                                   maxlength="7"
                                   required>
                        </div>
                        @error('protocolo')
                            <div class="invalid-feedback d-block mt-2">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 mt-5">
                        <button type="submit" class="btn btn-faspm btn-lg py-3 fw-bold">
                            <i class="bi bi-search me-2"></i> CONSULTAR ANDAMENTO
                        </button>
                        
                        <div class="d-flex justify-content-between mt-3">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Voltar
                            </a>
                            <a href="{{ route('manifestacoes.create') }}" class="btn btn-link text-decoration-none">
                                Não tem uma manifestação? <i class="bi bi-plus-circle ms-1"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer bg-light py-3 border-0">
                <p class="text-center text-muted mb-0 small">
                    <i class="bi bi-info-circle me-1"></i>
                    Em caso de perda da chave de acesso, entre em contato presencialmente com a Ouvidoria.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection