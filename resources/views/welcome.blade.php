@extends('layouts.app')

@section('title', 'Ouvidoria FASPM/PA - Manifestações e Sugestões')

@section('content')
<div class="hero-section">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-4">
                    <i class="bi bi-megaphone-fill me-2"></i>
                    Ouvidoria FASPM/PA
                </h1>
                <p class="lead mb-4">
                    Seu canal direto com o Fundo de Assistência Social da Polícia Militar do Pará.
                    Aqui você pode registrar reclamações, elogios, sugestões e denúncias.
                </p>
                <div class="d-flex flex-column flex-md-row justify-content-center gap-3">
                    <a href="{{ route('manifestacoes.create') }}" class="btn btn-light btn-lg px-4 py-3">
                        <i class="bi bi-plus-circle me-2"></i> Nova Manifestação
                    </a>
                    <a href="{{ route('manifestacoes.acompanhar') }}" class="btn btn-outline-light btn-lg px-4 py-3">
                        <i class="bi bi-search me-2"></i> Acompanhar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Abaixo da Hero Section e acima dos Cards Informativos --}}
<div class="container my-5">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <ul class="nav nav-pills nav-justified mb-4" id="ouvidoriaTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold" id="sobre-tab" data-bs-toggle="tab" data-bs-target="#sobre" type="button" role="tab">
                        <i class="bi bi-info-circle me-2"></i>Sobre a Ouvidoria
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold" id="missao-tab" data-bs-toggle="tab" data-bs-target="#missao" type="button" role="tab">
                        <i class="bi bi-target me-2"></i>Missão e Visão
                    </button>
                </li>
                <li class="nav-item" role="presentation">
    <button class="nav-link fw-bold" id="carta-tab" data-bs-toggle="tab" data-bs-target="#carta" type="button" role="tab">
        <i class="bi bi-file-earmark-pdf me-2"></i>Carta de Serviços
    </button>
</li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold" id="relatorios-tab" data-bs-toggle="tab" data-bs-target="#relatorios" type="button" role="tab">
                        <i class="bi bi-graph-up me-2"></i>Relatórios Anuais
                    </button>
                </li>
            </ul>

            <div class="tab-content border p-4 rounded bg-light" id="ouvidoriaTabContent">

                <div class="tab-pane fade show active" id="sobre" role="tabpanel">
                    <h4 class="text-primary mb-3">Seja bem-vindo!</h4>
                    <p class="text-dark" style="text-align: justify;">
                        A Ouvidoria é o canal de representação da família policial militar e bombeiro militar junto ao <strong>Fundo de Assistência Social da Polícia Militar do Pará (FASPM/PA)</strong>.
                        Sua atuação é voltada para garantir a qualidade dos serviços prestados e assegurar que as demandas da nossa classe sejam ouvidas e processadas com ética e agilidade.
                    </p>
                    <p class="text-dark" style="text-align: justify;">
                        Utilizando este recurso, é possível encaminhar elogios, sugestões, críticas ou reclamações, pedidos de acesso à informação e solicitar esclarecimentos sobre a assistência social militar.
                        As demandas recebidas contribuem diretamente para o aperfeiçoamento da nossa gestão e para o fortalecimento do suporte oferecido aos nossos bravos policiais e seus dependentes.
                    </p>
                </div>

                <div class="tab-pane fade" id="missao" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h5 class="text-primary fw-bold"><i class="bi bi-flag me-2"></i>Nossa Missão</h5>
                            <p>Promover assistência social e suporte de excelência aos policiais e bombeiros militares do Estado do Pará e seus dependentes, gerindo recursos com transparência e responsabilidade.</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h5 class="text-primary fw-bold"><i class="bi bi-eye me-2"></i>Nossa Visão</h5>
                            <p>Ser referência na prestação de serviço social aos policiais e pombeiros, no Estado do Pará, destacando-se pela eficiência no atendimento e pelo impacto positivo na qualidade de vida da tropa.</p>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade text-center" id="carta" role="tabpanel">
                    <div class="py-4">
                        <i class="bi bi-file-earmark-pdf text-danger display-4 mb-3"></i>
                        <h5>Carta de Serviços ao Usuário</h5>
                        <p class="text-muted">Consulte detalhadamente todos os serviços oferecidos pelo FASPM/PA e os prazos de atendimento.</p>
                        <a href="{{ asset('arquivos/CARTA DE SERVIÇOS AO CIDADÃO.pdf') }}" target="_blank" class="btn btn-outline-danger px-4">
                            <i class="bi bi-download me-2"></i>Visualizar Carta de Serviços (PDF)
                        </a>
                    </div>
                </div>

                <div class="tab-pane fade text-center" id="relatorios" role="tabpanel">
                    <div class="py-4">
                        <i class="bi bi-bar-chart-line text-primary display-4 mb-3"></i>
                        <h5>Transparência de Gestão</h5>
                        <p class="text-muted">Acesse o relatório consolidado de demandas e atendimentos realizados pela Ouvidoria no ano de 2025.</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ asset('files/relatorio_anual_2025.pdf') }}" target="_blank" class="btn btn-primary px-4">
                                <i class="bi bi-file-pdf me-2"></i>Relatório 2025 (PDF)
                            </a>
                            <a href="#" class="btn btn-outline-secondary px-4 disabled">
                                <i class="bi bi-archive me-2"></i>Anos Anteriores
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <!-- Cards informativos -->
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card card-faspm h-100 text-center p-4">
                <div class="mb-3">
                    <i class="bi bi-chat-left-text fs-1 text-primary"></i>
                </div>
                <h4 class="card-title mb-3">Registro Fácil</h4>
                <p class="card-text">
                    Registre sua manifestação de forma rápida e simples.
                    Preencha o formulário e receba um protocolo para acompanhamento.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-faspm h-100 text-center p-4">
                <div class="mb-3">
                    <i class="bi bi-shield-check fs-1 text-success"></i>
                </div>
                <h4 class="card-title mb-3">Sigilo Garantido</h4>
                <p class="card-text">
                    Suas informações são mantidas em sigilo.
                    Processamos todas as manifestações com ética e responsabilidade.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-faspm h-100 text-center p-4">
                <div class="mb-3">
                    <i class="bi bi-clock-history fs-1 text-warning"></i>
                </div>
                <h4 class="card-title mb-3">Acompanhamento</h4>
                <p class="card-text">
                    Acompanhe o status da sua manifestação a qualquer momento
                    utilizando o número de protocolo fornecido.
                </p>
            </div>
        </div>
    </div>

    <!-- Tipos de manifestação -->
    <div class="row mt-5">
        <div class="col-12">
            <h2 class="text-center mb-4 text-primary">Tipos de Manifestação</h2>
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>Tipo</th>
                            <th>Descrição</th>
                            <th>Prazo para Resposta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\TipoManifestacao::where('ativo', true)->get() as $tipo)
                        <tr>
                            <td>
                                <span class="badge" style="background-color: {{ $tipo->cor }}; color: white">
                                    {{ $tipo->nome }}
                                </span>
                            </td>
                            <td>
                                @switch($tipo->nome)
                                @case('Reclamação')
                                Manifestação sobre serviço prestado ou atendimento
                                @break
                                @case('Elogio')
                                Reconhecimento pelo bom serviço ou atendimento
                                @break
                                @case('Sugestão')
                                Proposta de melhoria para serviços ou processos
                                @break
                                @case('Denúncia')
                                Comunicação de irregularidades ou ilícitos
                                @break
                                @case('Solicitação de Informação')
                                Pedido de informações ou esclarecimentos
                                @break
                                @default
                                Outro tipo de manifestação
                                @endswitch
                            </td>
                            <td>{{ $tipo->prazo_dias }} dias úteis</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Chamada para ação -->
    <div class="row mt-5">
        <div class="col-12 text-center">
            <div class="alert alert-faspm p-4">
                <h3 class="mb-3">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    Importante
                </h3>
                <p class="mb-3">
                    Todas as manifestações são analisadas pela equipe da Ouvidoria da FASPM/PA.
                    Você receberá resposta dentro do prazo estabelecido para cada tipo de manifestação.
                </p>
                <a href="{{ route('manifestacoes.create') }}" class="btn btn-faspm btn-lg px-5">
                    <i class="bi bi-pencil-square me-2"></i> Registrar Agora
                </a>
            </div>
        </div>
    </div>
</div>
@endsection