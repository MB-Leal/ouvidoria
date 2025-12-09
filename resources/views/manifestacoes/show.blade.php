@extends('layouts.app')

@section('title', 'Manifestação ' . $manifestacao->protocolo . ' - Ouvidoria FASPM/PA')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Cabeçalho com protocolo -->
        <div class="card card-faspm mb-4">
            <div class="card-header bg-success text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">
                            <i class="bi bi-file-text me-2"></i>
                            Manifestação Registrada
                        </h4>
                    </div>
                    <div class="text-end">
                        <div class="fs-5 fw-bold">{{ $manifestacao->protocolo }}</div>
                        <small class="opacity-75">Guarde este número</small>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-success d-flex align-items-center mb-0">
                    <div class="me-3">
                        <i class="bi bi-check-circle-fill fs-2"></i>
                    </div>
                    <div>
                        <h5 class="alert-heading mb-1">Manifestação registrada com sucesso!</h5>
                        <p class="mb-0">Sua manifestação foi recebida e está em análise pela nossa equipe.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informações da manifestação -->
        <div class="row">
            <!-- Coluna esquerda - Dados principais -->
            <div class="col-md-6 mb-4">
                <div class="card card-faspm h-100">
                    <div class="card-header bg-primary bg-opacity-10 border-bottom">
                        <h5 class="mb-0 text-primary">
                            <i class="bi bi-info-circle me-2"></i>
                            Informações da Manifestação
                        </h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold text-muted" width="40%">Tipo:</td>
                                <td>
                                    <span class="badge px-3 py-2"
                                        style="background-color: {{ $manifestacao->tipo->cor }}; color: white">
                                        <i class="bi bi-tag me-1"></i>
                                        {{ $manifestacao->tipo->nome }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Status:</td>
                                <td>
                                    <span class="badge bg-{{ $manifestacao->status_cor }} px-3 py-2">
                                        <i class="bi bi-{{ $manifestacao->status == 'ABERTO' ? 'clock' : 
                                                          ($manifestacao->status == 'EM_ANALISE' ? 'search' : 
                                                          ($manifestacao->status == 'RESPONDIDO' ? 'check-circle' : 'archive')) }} me-1"></i>
                                        {{ $manifestacao->status_formatado }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Data/Hora:</td>
                                <td>
                                    <i class="bi bi-calendar-event me-1"></i>
                                    {{ $manifestacao->created_at->format('d/m/Y') }}
                                    <i class="bi bi-clock ms-3 me-1"></i>
                                    {{ $manifestacao->created_at->format('H:i') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Canal:</td>
                                <td>
                                    <i class="bi bi-{{ $manifestacao->canal == 'WEB' ? 'globe' : 
                                                      ($manifestacao->canal == 'EMAIL' ? 'envelope' : 
                                                      ($manifestacao->canal == 'TELEFONE' ? 'telephone' : 'person')) }} me-1"></i>
                                    {{ $manifestacao->canal }}
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Prazo Estimado:</td>
                                <td>
                                    <i class="bi bi-calendar-check me-1"></i>
                                    {{ $manifestacao->tipo->prazo_dias }} dias úteis
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Coluna direita - Dados do solicitante -->
            <div class="col-md-6 mb-4">
                <div class="card card-faspm h-100">
                    <div class="card-header bg-primary bg-opacity-10 border-bottom">
                        <h5 class="mb-0 text-primary">
                            <i class="bi bi-person-circle me-2"></i>
                            Dados do Solicitante
                        </h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold text-muted" width="40%">Nome:</td>
                                <td>
                                    <i class="bi bi-person me-1"></i>
                                    {{ $manifestacao->nome }}
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">E-mail:</td>
                                <td>
                                    <i class="bi bi-envelope me-1"></i>
                                    <a href="mailto:{{ $manifestacao->email }}">{{ $manifestacao->email }}</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Telefone:</td>
                                <td>
                                    @if($manifestacao->telefone)
                                    <i class="bi bi-telephone me-1"></i>
                                    {{ $manifestacao->telefone }}
                                    @else
                                    <span class="text-muted">Não informado</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Descrição -->
        <div class="card card-faspm mb-4">
            <div class="card-header bg-primary bg-opacity-10 border-bottom">
                <h5 class="mb-0 text-primary">
                    <i class="bi bi-chat-square-text me-2"></i>
                    Descrição da Manifestação
                </h5>
            </div>
            <div class="card-body">
                <div class="p-4 bg-light rounded">
                    {!! nl2br(e($manifestacao->descricao)) !!}
                </div>
            </div>
        </div>

        <!-- Anexo -->
        @if($manifestacao->anexo_path)
        <div class="card card-faspm mb-4">
            <div class="card-header bg-primary bg-opacity-10 border-bottom">
                <h5 class="mb-0 text-primary">
                    <i class="bi bi-paperclip me-2"></i>
                    Anexo
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="bi bi-file-earmark-text fs-1 text-primary"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6>Arquivo anexado</h6>
                        <p class="text-muted mb-2">Documento enviado com a manifestação</p>
                        <a href="{{ Storage::url($manifestacao->anexo_path) }}"
                            target="_blank"
                            class="btn btn-outline-primary">
                            <i class="bi bi-eye me-1"></i> Visualizar Anexo
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Resposta da Ouvidoria -->
        @if($manifestacao->resposta)
        <div class="card card-faspm mb-4 border-success">
            <div class="card-header bg-success bg-opacity-10 border-success">
                <h5 class="mb-0 text-success">
                    <i class="bi bi-check-circle me-2"></i>
                    Resposta da Ouvidoria
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <span class="badge bg-success">
                            Respondido em: {{ $manifestacao->data_resposta?->format('d/m/Y') ?? 'Data não disponível' }}
                        </span>
                    </div>
                </div>
                <div class="p-4 bg-success bg-opacity-10 border-start border-3 border-success rounded">
                    {!! nl2br(e($manifestacao->resposta)) !!}
                </div>
            </div>
        </div>
        @endif

        <!-- Instruções de acompanhamento -->
        <div class="card card-faspm mb-4">
            <div class="card-header bg-warning bg-opacity-10 border-warning">
                <h5 class="mb-0 text-warning">
                    <i class="bi bi-info-circle me-2"></i>
                    Como acompanhar esta manifestação
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="text-center p-3">
                            <div class="mb-3">
                                <i class="bi bi-journal-check fs-1 text-primary"></i>
                            </div>
                            <h6>1. Anote o protocolo</h6>
                            <p class="small text-muted mb-0">Guarde ou imprima seu número de protocolo</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="text-center p-3">
                            <div class="mb-3">
                                <i class="bi bi-search fs-1 text-primary"></i>
                            </div>
                            <h6>2. Consulte quando quiser</h6>
                            <p class="small text-muted mb-0">Volte à página de acompanhamento e digite o protocolo</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="text-center p-3">
                            <div class="mb-3">
                                <i class="bi bi-bell fs-1 text-primary"></i>
                            </div>
                            <h6>3. Receba atualizações</h6>
                            <p class="small text-muted mb-0">Você será notificado por e-mail sobre mudanças</p>
                        </div>
                    </div>
                </div>

                <div class="alert alert-light mt-3">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="bi bi-shield-check text-primary fs-4"></i>
                        </div>
                        <div>
                            <p class="mb-0">
                                <strong>Protocolo para acompanhamento:</strong>
                                <br>
                                <code class="fs-5 text-dark">{{ $manifestacao->protocolo }}</code>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botões de ação -->
        <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
            <a href="{{ route('manifestacoes.acompanhar') }}" class="btn btn-primary px-4">
                <i class="bi bi-search me-2"></i> Nova Consulta
            </a>
            <a href="{{ route('manifestacoes.create') }}" class="btn btn-success px-4">
                <i class="bi bi-plus-circle me-2"></i> Nova Manifestação
            </a>
            <button onclick="window.print()" class="btn btn-outline-secondary px-4">
                <i class="bi bi-printer me-2"></i> Imprimir
            </button>
            <a href="{{ route('home') }}" class="btn btn-outline-dark px-4">
                <i class="bi bi-house me-2"></i> Página Inicial
            </a>
        </div>
    </div>
</div>

<style>
    @media print {
        .no-print {
            display: none !important;
        }

        .card {
            border: 1px solid #dee2e6 !important;
            box-shadow: none !important;
        }

        .btn {
            display: none !important;
        }

        body {
            font-size: 12pt;
        }
    }
</style>

<script>
    // Adicionar classe no-print nos botões
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('button, a.btn');
        buttons.forEach(btn => {
            btn.classList.add('no-print');
        });
    });
</script>
@endsection