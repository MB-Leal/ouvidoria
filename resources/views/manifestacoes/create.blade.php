@extends('layouts.app')

@section('title', 'Nova Manifestação - Ouvidoria FASPM/PA')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card card-faspm">
            <div class="card-header bg-faspm text-white">
                <h4 class="mb-0">
                    <i class="bi bi-chat-left-text me-2"></i> 
                    Nova Manifestação
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('manifestacoes.store') }}" method="POST" enctype="multipart/form-data" id="form-manifestacao">
                    @csrf
                    
                    <div class="row">
                        <!-- Coluna esquerda -->
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label fw-bold text-primary">
                                    <i class="bi bi-tag me-1"></i> Tipo de Manifestação *
                                </label>
                                <select class="form-select @error('tipo_manifestacao_id') is-invalid @enderror" 
                                        name="tipo_manifestacao_id" required>
                                    <option value="">Selecione o tipo...</option>
                                    @foreach($tipos as $tipo)
                                    <option value="{{ $tipo->id }}" 
                                            {{ old('tipo_manifestacao_id') == $tipo->id ? 'selected' : '' }}
                                            data-cor="{{ $tipo->cor }}"
                                            data-prazo="{{ $tipo->prazo_dias }}">
                                        {{ $tipo->nome }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('tipo_manifestacao_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Escolha o tipo de manifestação mais adequado</small>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-primary">
                                    <i class="bi bi-person me-1"></i> Dados Pessoais
                                </label>
                                
                                <div class="mb-3">
                                    <input type="text" 
                                           class="form-control @error('nome') is-invalid @enderror" 
                                           name="nome" 
                                           value="{{ old('nome') }}"
                                           placeholder="Nome completo *" 
                                           required>
                                    @error('nome')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           name="email" 
                                           value="{{ old('email') }}"
                                           placeholder="E-mail *" 
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <input type="text" 
                                           class="form-control @error('telefone') is-invalid @enderror" 
                                           name="telefone" 
                                           value="{{ old('telefone') }}"
                                           placeholder="Telefone (opcional)"
                                           oninput="mascaraTelefone(this)">
                                    @error('telefone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Formato: (91) 99999-9999</small>
                                </div>
                            </div>
                        </div>

                        <!-- Coluna direita -->
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label fw-bold text-primary">
                                    <i class="bi bi-chat-square-text me-1"></i> Descrição da Manifestação *
                                </label>
                                <textarea class="form-control @error('descricao') is-invalid @enderror" 
                                          name="descricao" 
                                          rows="8" 
                                          placeholder="Descreva sua manifestação de forma clara e objetiva. Seja específico sobre fatos, datas, pessoas envolvidas e o que você espera como resultado."
                                          required>{{ old('descricao') }}</textarea>
                                @error('descricao')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="mt-2 text-end">
                                    <small class="text-muted">Mínimo 10 caracteres</small>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-primary">
                                    <i class="bi bi-paperclip me-1"></i> Anexos (Opcional)
                                </label>
                                <input type="file" 
                                       class="form-control @error('anexo') is-invalid @enderror" 
                                       name="anexo" 
                                       accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                @error('anexo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Formatos aceitos: PDF, JPG, PNG, DOC, DOCX (máx. 5MB)
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informações importantes -->
                    <div class="alert alert-info alert-faspm mt-4">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="bi bi-info-circle-fill fs-4"></i>
                            </div>
                            <div>
                                <h5 class="alert-heading mb-2">Informações importantes</h5>
                                <ul class="mb-2">
                                    <li>Após o envio, você receberá um número de <strong>protocolo único</strong> por e-mail</li>
                                    <li>Guarde este número para acompanhar o andamento da sua manifestação</li>
                                    <li>O prazo para resposta depende do tipo de manifestação selecionado</li>
                                    <li>Todas as informações serão tratadas com <strong>sigilo</strong></li>
                                </ul>
                                <div id="info-prazo" class="mt-2" style="display: none;">
                                    <strong>Prazo estimado para resposta:</strong> 
                                    <span id="prazo-dias" class="badge bg-primary"></span> dias úteis
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botões -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-between mt-4">
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i> Voltar
                        </a>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-primary" onclick="limparFormulario()">
                                <i class="bi bi-eraser me-2"></i> Limpar
                            </button>
                            <button type="submit" class="btn btn-faspm px-5">
                                <i class="bi bi-send me-2"></i> Enviar Manifestação
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Atualizar informações do tipo selecionado
    document.querySelector('select[name="tipo_manifestacao_id"]').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const prazo = selectedOption.getAttribute('data-prazo');
        const infoPrazo = document.getElementById('info-prazo');
        const prazoDias = document.getElementById('prazo-dias');
        
        if (prazo) {
            prazoDias.textContent = prazo;
            infoPrazo.style.display = 'block';
        } else {
            infoPrazo.style.display = 'none';
        }
    });

    // Máscara para telefone
    function mascaraTelefone(input) {
        let value = input.value.replace(/\D/g, '');
        
        if (value.length > 11) {
            value = value.substring(0, 11);
        }
        
        if (value.length > 10) {
            value = value.replace(/^(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
        } else if (value.length > 6) {
            value = value.replace(/^(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
        } else if (value.length > 2) {
            value = value.replace(/^(\d{2})(\d{0,5})/, '($1) $2');
        } else if (value.length > 0) {
            value = value.replace(/^(\d*)/, '($1');
        }
        
        input.value = value;
    }

    // Limpar formulário
    function limparFormulario() {
        if (confirm('Tem certeza que deseja limpar todos os campos?')) {
            document.getElementById('form-manifestacao').reset();
            document.getElementById('info-prazo').style.display = 'none';
        }
    }

    // Validação de caracteres mínimos
    document.querySelector('textarea[name="descricao"]').addEventListener('input', function() {
        const minLength = 10;
        const currentLength = this.value.length;
        const feedback = document.querySelector('.text-muted:last-of-type');
        
        if (feedback) {
            if (currentLength < minLength) {
                feedback.innerHTML = `<span class="text-danger">Faltam ${minLength - currentLength} caracteres</span>`;
            } else {
                feedback.innerHTML = `<span class="text-success">${currentLength} caracteres (mínimo atingido)</span>`;
            }
        }
    });
</script>
@endsection