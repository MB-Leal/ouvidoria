@extends('layouts.app')

@section('title', 'Acompanhar Manifestação - Ouvidoria FASPM/PA')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-faspm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="bi bi-search me-2"></i> 
                    Acompanhar Manifestação
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('manifestacoes.buscar') }}" method="POST" id="form-acompanhar">
                    @csrf
                    
                    <div class="text-center mb-5">
                        <div class="mb-4">
                            <i class="bi bi-search-heart fs-1 text-primary"></i>
                        </div>
                        <h3 class="text-primary">Consulte o andamento da sua manifestação</h3>
                        <p class="text-muted">Digite o número do protocolo fornecido no momento do registro</p>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-primary">
                            <i class="bi bi-key me-1"></i> Número do Protocolo *
                        </label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-file-text text-primary"></i>
                            </span>
                            <input type="text" 
                                   class="form-control @error('protocolo') is-invalid @enderror border-start-0" 
                                   name="protocolo" 
                                   value="{{ old('protocolo') }}"
                                   placeholder="Ex: FASPM-2024-000001"
                                   required
                                   style="font-family: 'Courier New', monospace; font-weight: bold;">
                            @error('protocolo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted mt-2 d-block">
                            <i class="bi bi-info-circle me-1"></i>
                            O protocolo foi enviado para o e-mail informado no momento do registro
                        </small>
                    </div>

                    <!-- Exemplo de protocolo -->
                    <div class="alert alert-light border mt-4">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="bi bi-question-circle text-primary fs-4"></i>
                            </div>
                            <div>
                                <h6 class="mb-2">Não lembra o formato do protocolo?</h6>
                                <p class="mb-2">O protocolo segue o formato: <code class="text-primary">FASPM-ANO-NÚMERO</code></p>
                                <p class="mb-0">
                                    <strong>Exemplo:</strong> 
                                    <span class="badge bg-dark">FASPM-{{ date('Y') }}-000001</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Informações -->
                    <div class="alert alert-info alert-faspm mt-4">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="bi bi-shield-check fs-4"></i>
                            </div>
                            <div>
                                <h5 class="alert-heading mb-2">Sobre o acompanhamento</h5>
                                <ul class="mb-0">
                                    <li>Consulte o status atual da sua manifestação</li>
                                    <li>Veja se já existe uma resposta da ouvidoria</li>
                                    <li>Acompanhe prazos e próximos passos</li>
                                    <li>Suas informações estão protegidas por sigilo</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Botões -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-between mt-5">
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-house me-2"></i> Página Inicial
                        </a>
                        <div class="d-flex gap-2">
                            <a href="{{ route('manifestacoes.create') }}" class="btn btn-outline-primary">
                                <i class="bi bi-plus-circle me-2"></i> Nova Manifestação
                            </a>
                            <button type="submit" class="btn btn-faspm px-5">
                                <i class="bi bi-search me-2"></i> Buscar Manifestação
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Seção de ajuda -->
        <div class="card card-faspm mt-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-question-circle me-2"></i>
                    Precisa de ajuda?
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="bi bi-envelope text-primary fs-4"></i>
                            </div>
                            <div>
                                <h6>Não recebeu o protocolo?</h6>
                                <p class="small mb-0">
                                    Verifique sua caixa de spam ou entre em contato conosco:
                                    <br>
                                    <strong>ouvidoria@faspmpa.com.br</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="bi bi-telephone text-primary fs-4"></i>
                            </div>
                            <div>
                                <h6>Dúvidas ou problemas?</h6>
                                <p class="small mb-0">
                                    Entre em contato com nossa equipe:
                                    <br>
                                    <strong>(91) 3219-3200</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Formatar entrada do protocolo
    document.querySelector('input[name="protocolo"]').addEventListener('input', function(e) {
        let value = e.target.value.toUpperCase();
        // Mantém apenas letras, números e hífen
        value = value.replace(/[^A-Z0-9\-]/g, '');
        // Limita o comprimento
        if (value.length > 20) {
            value = value.substring(0, 20);
        }
        e.target.value = value;
    });

    // Auto-focar no campo
    document.addEventListener('DOMContentLoaded', function() {
        const protocoloInput = document.querySelector('input[name="protocolo"]');
        if (protocoloInput) {
            protocoloInput.focus();
            protocoloInput.select();
        }
    });
</script>
@endsection