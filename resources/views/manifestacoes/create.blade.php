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
                                <select class="form-select @error('tipo_manifestacao_id') is-invalid @enderror" name="tipo_manifestacao_id" required>
                                    <option value="">Selecione o tipo...</option>
                                    @foreach($tipos as $tipo)
                                    <option value="{{ $tipo->id }}" {{ old('tipo_manifestacao_id') == $tipo->id ? 'selected' : '' }} data-prazo="{{ $tipo->prazo_dias }}">
                                        {{ $tipo->nome }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="alert alert-light border-0 pb-0 small text-muted">
                                <i class="bi bi-shield-check me-1"></i>
                                “Seus dados serão utilizados exclusivamente para fins de comunicação e acompanhamento da manifestação, em conformidade com a Lei Geral de Proteção de Dados (Lei nº 13.709/2018).”
                            </div>

                            <div class="card border-warning mb-3">
                                <div class="card-body py-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_anonymous" name="is_anonymous" value="1" onchange="togglePersonalData(this.checked)">
                                        <label class="form-check-label fw-bold" for="is_anonymous">
                                            Desejo realizar uma manifestação ANÔNIMA
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div id="personal_data_fields" class="mb-4">
                                <div class="mb-3">
                                    <label class="form-label">E-mail * <small>(Obrigatório para identificados)</small></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nome <small>(Opcional)</small></label>
                                    <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Telefone <small>(Opcional)</small></label>
                                    <input type="text" class="form-control" id="telefone" name="telefone" value="{{ old('telefone') }}" oninput="mascaraTelefone(this)">
                                </div>
                            </div>

                            <div id="anonymous_warning" class="alert alert-warning d-none">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                Ao optar pelo anonimato, você <strong>não</strong> receberá e-mails.
                                <strong>Anote o Protocolo e o Token</strong> que serão gerados ao final para consulta.
                            </div>

                            <div class="card border mb-4">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0"><i class="bi bi-incognito me-2"></i> Sigilo dos Dados Pessoais</h6>
                                </div>
                                <div class="card-body">
                                    <p class="small text-muted mb-2">Seus dados são protegidos pela LAI (Lei 12.527/2011). Marcar "Sim" impede a divulgação do seu nome em relatórios públicos.</p>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="sigilo_dados" id="sigilo_sim" value="1" {{ old('sigilo_dados') == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sigilo_sim">Sim, quero sigilo</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="sigilo_dados" id="sigilo_nao" value="0" {{ old('sigilo_dados', '0') == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sigilo_nao">Não preciso de sigilo</label>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-header bg-light py-1"><strong>Termo de Privacidade</strong></div>
                                <div class="card-body p-2" style="height: 120px; overflow-y: scroll; font-size: 0.75rem; background-color: #f8f9fa;">
                                    <h6>TERMO DE PRIVACIDADE DA OUVIDORIA - FASPM</h6>                                    
                                        <strong>Fundo de Assistência Social da Polícia Militar do Pará – FASPM</strong>
                                    </p>

                                    <p>O <strong>Fundo de Assistência Social da Polícia Militar do Pará – FASPM</strong>, por meio de sua Ouvidoria, reafirma o compromisso com a proteção dos dados pessoais dos cidadãos, em conformidade com a <strong>Lei Geral de Proteção de Dados Pessoais – LGPD (Lei nº 13.709/2018)</strong>.</p>

                                    <p>Este Termo tem como objetivo informar, de forma clara e transparente, como os dados pessoais são coletados, utilizados, armazenados e protegidos no âmbito da Ouvidoria.</p>

                                    <p><strong>1. Finalidade do tratamento dos dados</strong><br>
                                        Os dados pessoais coletados pela Ouvidoria do FASPM têm como finalidade exclusiva:</p>
                                    <ul>
                                        <li>Registrar manifestações dos cidadãos;</li>
                                        <li>Permitir o acompanhamento do andamento da manifestação;</li>
                                        <li>Encaminhar respostas e comunicações relacionadas à demanda apresentada;</li>
                                        <li>Garantir a adequada prestação do serviço público de ouvidoria.</li>
                                    </ul>
                                    <p>Os dados <u>não serão utilizados para finalidades diversas</u> daquelas relacionadas ao tratamento da manifestação.</p>

                                    <p><strong>2. Dados pessoais coletados</strong></p>
                                    <p><strong>2.1 Manifestações identificadas</strong><br>
                                        No caso de manifestações identificadas, poderão ser coletados os seguintes dados:</p>
                                    <ul>
                                        <li><strong>E-mail (obrigatório)</strong> – utilizado para envio do número de protocolo, comunicações e resposta da manifestação;</li>
                                        <li><strong>Nome (opcional)</strong> – utilizado apenas para fins de identificação do manifestante;</li>
                                        <li><strong>Telefone (opcional)</strong> – utilizado exclusivamente para contato, se necessário.</li>
                                    </ul>

                                    <p><strong>2.2 Manifestações anônimas</strong><br>
                                        A Ouvidoria do FASPM permite o registro de manifestações anônimas, hipótese em que nenhum dado pessoal identificável é coletado. Nesses casos, o acompanhamento será realizado <strong>exclusivamente por meio de protocolo e código de acesso (token)</strong>.</p>

                                    <p><strong>3. Base legal para o tratamento</strong><br>
                                        O tratamento fundamenta-se:</p>
                                    <ul>
                                        <li>No cumprimento de obrigação legal e regulatória;</li>
                                        <li>Na execução de políticas públicas (Art. 7º, incisos II e III, da LGPD).</li>
                                    </ul>

                                    <p><strong>4. Acesso às informações</strong><br>
                                        O acesso ao conteúdo é restrito aos servidores autorizados e ao próprio manifestante mediante credenciais. O FASPM não disponibiliza informações a terceiros não autorizados.</p>

                                    <p><strong>5. Segurança da informação</strong><br>
                                        Adotamos medidas técnicas para proteger os dados contra acessos não autorizados, incluindo controle de acesso, logs de registro e uso de código individual para consulta.</p>

                                    <p><strong>6. Compartilhamento de dados</strong><br>
                                        Os dados não são compartilhados, salvo por cumprimento de obrigação legal ou determinação de órgãos de controle.</p>

                                    <p><strong>7. Prazo de armazenamento</strong><br>
                                        Os dados serão armazenados pelo período necessário ao cumprimento das finalidades legais aplicáveis à administração pública.</p>

                                    <p><strong>8. Direitos do titular dos dados</strong><br>
                                        O titular pode solicitar: confirmação da existência de tratamento, acesso, correção de dados incompletos ou informações sobre o tratamento realizado.</p>

                                    <p><strong>9. Disposições finais</strong><br>
                                        Ao registrar uma manifestação, o cidadão declara estar <strong>ciente e de acordo</strong> com este Termo. Este documento poderá ser atualizado a qualquer tempo para aprimorar a conformidade legal.</p>

                                    <p class="text-center mt-3"><strong>Fundo de Assistência Social da Polícia Militar do Pará – FASPM Ouvidoria</strong></p>
                                </div>
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="accept_terms" required>
                                <label class="form-check-label small" for="accept_terms">
                                    Li e estou de acordo com o Termo de Privacidade. *
                                </label>
                            </div>
                        </div>

                        <!-- Coluna direita -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="assunto" class="form-label">
                                    Assunto da Manifestação <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="form-control @error('assunto') is-invalid @enderror"
                                    id="assunto"
                                    name="assunto"
                                    value="{{ old('assunto') }}"
                                    required
                                    placeholder="Resumo do que se trata a manifestação">
                                @error('assunto')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Descreva brevemente o assunto (ex: "Problema com atendimento", "Elogio ao servidor", etc.)</small>
                            </div>
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

    function togglePersonalData(isAnonymous) {
        const fields = ['email', 'nome', 'telefone'];
        const container = document.getElementById('personal_data_fields');
        const warning = document.getElementById('anonymous_warning');
        const sigiloSim = document.getElementById('sigilo_sim');

        if (isAnonymous) {
            container.classList.add('d-none'); // Melhor esconder para evitar confusão
            warning.classList.remove('d-none');
            fields.forEach(f => {
                const el = document.getElementById(f);
                el.value = '';
                el.disabled = true;
                el.required = false;
            });
            sigiloSim.checked = true; // Anônimo implica sigilo total
        } else {
            container.classList.remove('d-none');
            warning.classList.add('d-none');
            fields.forEach(f => document.getElementById(f).disabled = false);
            document.getElementById('email').required = true;
        }
    }

    // Impedir envio se o termo não for aceito (validação nativa HTML5 'required' já ajuda)
    document.getElementById('form-manifestacao').onsubmit = function() {
        if (!document.getElementById('accept_terms').checked) {
            alert("Você deve aceitar o Termo de Privacidade para continuar.");
            return false;
        }
    };
</script>
@endsection