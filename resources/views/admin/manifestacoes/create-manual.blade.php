@extends('admin.layouts.app')

@section('title', 'Cadastrar Manifestação Manual')

@section('content')
<div class="container-fluid py-4">
    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-plus-circle me-2"></i> Cadastrar Manifestação Manual
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.manifestacoes.index') }}">Manifestações</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cadastro Manual</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.manifestacoes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Voltar
            </a>
        </div>
    </div>

    <!-- Formulário -->
    <div class="row">
        <div class="col-lg-10 col-xl-8 mx-auto">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-file-alt me-1"></i> Informações da Manifestação
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.manifestacoes.store.manual') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <!-- Tipo de Manifestação -->
                            <div class="col-md-6 mb-3">
                                <label for="tipo_manifestacao_id" class="form-label">
                                    Tipo de Manifestação <span class="text-danger">*</span>
                                </label>
                                <select name="tipo_manifestacao_id" id="tipo_manifestacao_id"
                                    class="form-control @error('tipo_manifestacao_id') is-invalid @enderror" required>
                                    <option value="">Selecione o tipo</option>
                                    @foreach($tipos as $tipo)
                                    <option value="{{ $tipo->id }}"
                                        {{ old('tipo_manifestacao_id') == $tipo->id ? 'selected' : '' }}
                                        data-cor="{{ $tipo->cor }}">
                                        {{ $tipo->nome }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('tipo_manifestacao_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="assunto" class="form-label">
                                    Assunto da Manifestação <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    name="assunto"
                                    id="assunto"
                                    class="form-control @error('assunto') is-invalid @enderror"
                                    value="{{ old('assunto') }}"
                                    required
                                    placeholder="Resumo da manifestação">
                                @error('assunto')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Sigilo dos Dados</label>
                                <div class="form-check">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        id="sigilo_dados"
                                        name="sigilo_dados"
                                        value="1"
                                        {{ old('sigilo_dados') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="sigilo_dados">
                                        <strong>Manifestante solicitou sigilo dos dados pessoais</strong>
                                    </label>
                                </div>
                                <small class="text-muted">Se marcado, os dados pessoais não serão divulgados publicamente.</small>
                            </div>

                            <!-- Canal de Entrada -->
                            <div class="col-md-6 mb-3">
                                <label for="canal" class="form-label">
                                    Canal do Atendimento <span class="text-danger">*</span>
                                </label>
                                <select name="canal" id="canal"
                                    class="form-control @error('canal') is-invalid @enderror" required>
                                    <option value="">Selecione o canal</option>
                                    @foreach($canais as $key => $label)
                                    <option value="{{ $key }}" {{ old('canal') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('canal')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Status e Prioridade -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">
                                    Status <span class="text-danger">*</span>
                                </label>
                                <select name="status" id="status"
                                    class="form-control @error('status') is-invalid @enderror" required>
                                    @foreach($statuses as $key => $label)
                                    <option value="{{ $key }}" {{ old('status') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="prioridade" class="form-label">
                                    Prioridade <span class="text-danger">*</span>
                                </label>
                                <select name="prioridade" id="prioridade"
                                    class="form-control @error('prioridade') is-invalid @enderror" required>
                                    <option value="baixa" {{ old('prioridade') == 'baixa' ? 'selected' : '' }}>Baixa</option>
                                    <option value="media" {{ old('prioridade', 'media') == 'media' ? 'selected' : '' }}>Média</option>
                                    <option value="alta" {{ old('prioridade') == 'alta' ? 'selected' : '' }}>Alta</option>
                                    <option value="urgente" {{ old('prioridade') == 'urgente' ? 'selected' : '' }}>Urgente</option>
                                </select>
                                @error('prioridade')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Dados do Manifestante -->
                        <div class="card border mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="fas fa-user me-1"></i> Dados do Manifestante
                                </h6>
                            </div>
                            <div class="card-body">
                                <!-- Checkbox Anônimo -->
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="anonimo" name="anonimo" value="1"
                                            {{ old('anonimo') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="anonimo">
                                            <strong>Manifestação Anônima</strong>
                                        </label>
                                    </div>
                                    <small class="text-muted">Se marcado, os dados pessoais serão ocultados.</small>
                                </div>

                                <!-- Campos que aparecem apenas se NÃO for anônimo -->
                                <div id="dados-pessoais" style="{{ old('anonimo') ? 'display: none;' : '' }}">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="nome" class="form-label">
                                                Nome Completo <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="nome" id="nome"
                                                class="form-control @error('nome') is-invalid @enderror"
                                                value="{{ old('nome') }}"
                                                placeholder="Digite o nome completo">
                                            @error('nome')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">E-mail</label>
                                            <input type="email" name="email" id="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email') }}"
                                                placeholder="exemplo@dominio.com">
                                            @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="telefone" class="form-label">Telefone</label>
                                            <input type="text" name="telefone" id="telefone"
                                                class="form-control @error('telefone') is-invalid @enderror"
                                                value="{{ old('telefone') }}"
                                                placeholder="(00) 00000-0000">
                                            @error('telefone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
    <div class="col-md-6 mb-3">
        <label for="data_entrada" class="form-label">
            <i class="fas fa-calendar-alt me-1"></i> Data de Entrada da Manifestação
        </label>
        <input type="datetime-local" 
               name="data_entrada" 
               id="data_entrada"
               class="form-control @error('data_entrada') is-invalid @enderror"
               value="{{ old('data_entrada', now()->format('Y-m-d\TH:i')) }}">
        @error('data_entrada')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <small class="text-muted">
            Data em que a manifestação realmente chegou (ex: data do e-mail, data do atendimento presencial).
        </small>
    </div>

    <div class="col-md-6 mb-3">
        <label for="data_registro_sistema" class="form-label">
            <i class="fas fa-database me-1"></i> Data de Registro no Sistema
        </label>
        <input type="datetime-local" 
               name="data_registro_sistema" 
               id="data_registro_sistema"
               class="form-control @error('data_registro_sistema') is-invalid @enderror"
               value="{{ old('data_registro_sistema', now()->format('Y-m-d\TH:i')) }}"
               readonly
               style="background-color: #f8f9fa;">
        @error('data_registro_sistema')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <small class="text-muted">
            Data atual (preenchida automaticamente).
        </small>
    </div>
</div>

                        <!-- Descrição da Manifestação -->
                        <div class="mb-4">
                            <label for="descricao" class="form-label">
                                Descrição da Manifestação <span class="text-danger">*</span>
                            </label>
                            <textarea name="descricao" id="descricao"
                                class="form-control @error('descricao') is-invalid @enderror"
                                rows="6" required
                                placeholder="Descreva detalhadamente a manifestação...">{{ old('descricao') }}</textarea>
                            @error('descricao')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Mínimo 10 caracteres.</small>
                        </div>

                        <!-- Anexo -->
                        <div class="mb-4">
                            <label for="anexo" class="form-label">
                                <i class="fas fa-paperclip me-1"></i> Anexo (Opcional)
                            </label>
                            <input type="file" name="anexo" id="anexo"
                                class="form-control @error('anexo') is-invalid @enderror"
                                accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                            @error('anexo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                Formatos permitidos: PDF, JPG, JPEG, PNG, DOC, DOCX. Tamanho máximo: 5MB.
                            </small>
                        </div>

                        <!-- Observação Interna -->
                        <div class="mb-4">
                            <label for="observacao_interna" class="form-label">
                                <i class="fas fa-sticky-note me-1"></i> Observação Interna (Opcional)
                            </label>
                            <textarea name="observacao_interna" id="observacao_interna"
                                class="form-control @error('observacao_interna') is-invalid @enderror"
                                rows="3"
                                placeholder="Observações para uso interno da equipe...">{{ old('observacao_interna') }}</textarea>
                            @error('observacao_interna')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Botões -->
                        <div class="d-flex justify-content-between border-top pt-4">
                            <a href="{{ route('admin.manifestacoes.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Cadastrar Manifestação
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Card de Ajuda -->
            <div class="card shadow mt-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-info-circle me-1"></i> Como usar o cadastro manual
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Para manifestações presenciais:</strong> Selecione "Presencial" no canal
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Para manifestações por e-mail:</strong> Selecione "E-mail" no canal
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Para manifestações por telefone/whatsapp:</strong> Selecione "Telefone/WhatsApp"
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Manifestações anônimas:</strong> Marque a opção "Manifestação Anônima"
                        </li>
                        <li>
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Protocolo:</strong> Será gerado automaticamente após o cadastro
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {        

        // Máscara de telefone
        const telefoneInput = document.getElementById('telefone');
        if (telefoneInput) {
            telefoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');

                if (value.length > 11) {
                    value = value.substring(0, 11);
                }

                if (value.length > 10) {
                    // Formato: (00) 00000-0000
                    value = value.replace(/^(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
                } else if (value.length > 6) {
                    // Formato: (00) 0000-0000
                    value = value.replace(/^(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
                } else if (value.length > 2) {
                    // Formato: (00) 0000
                    value = value.replace(/^(\d{2})(\d{0,4})/, '($1) $2');
                } else if (value.length > 0) {
                    value = '(' + value;
                }

                e.target.value = value;
            });
        }

        // Preview do tipo selecionado
        const tipoSelect = document.getElementById('tipo_manifestacao_id');
        if (tipoSelect) {
            tipoSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const cor = selectedOption.getAttribute('data-cor');
                if (cor) {
                    this.style.borderColor = cor;
                }
            });
        }

        // Validação de tamanho de arquivo
        const anexoInput = document.getElementById('anexo');
        if (anexoInput) {
            anexoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                const maxSize = 5 * 1024 * 1024; // 5MB

                if (file && file.size > maxSize) {
                    alert('O arquivo é muito grande. O tamanho máximo é 5MB.');
                    e.target.value = '';
                }
            });
        }
    });
</script>

@push('styles')
<style>
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .card-header.bg-light {
        background-color: #f8f9fa !important;
    }

    #tipo_manifestacao_id {
        transition: border-color 0.3s ease;
    }
</style>
@endpush