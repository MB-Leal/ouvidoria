@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            {{-- 1. Card de Sucesso (Alerta visual temporário) --}}
            @if(session('success') && session('chave_acesso'))
                <div class="alert alert-success shadow-sm border-left-success mb-4 d-print-none">
                    <h4 class="alert-heading"><i class="bi bi-check-circle-fill me-2"></i>Protocolo Gerado com Sucesso!</h4>
                    <p class="mb-0">Sua manifestação foi recebida. Os dados de acesso estão fixados no quadro abaixo para sua conferência ou impressão.</p>
                </div>
            @endif

            {{-- 2. Cabeçalho Principal (Dados Fixos para Consulta e Impressão) --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <div class="row align-items-center">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <span class="text-muted small text-uppercase d-block">Status da Manifestação</span>
                            <span class="badge rounded-pill bg-{{ $manifestacao->status_cor }} fs-6">
                                {{ $manifestacao->status_formatado }}
                            </span>
                        </div>
                        
                        <div class="col-md-4 mb-3 mb-md-0 text-md-center">
                            <span class="text-muted small text-uppercase d-block">Protocolo</span>
                            <span class="fw-bold fs-5 text-dark">{{ $manifestacao->protocolo }}</span>
                        </div>

                        <div class="col-md-4 text-md-end">
                            @if(session('chave_acesso'))
                                <span class="text-muted small text-uppercase d-block">Chave de Acesso (Token)</span>
                                <span class="fw-bold fs-5 text-danger">{{ session('chave_acesso') }}</span>
                            @else
                                <span class="text-muted small text-uppercase d-block">Data de Consulta</span>
                                <span class="fw-bold">{{ now()->format('d/m/Y') }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- 3. Corpo Principal - Dados da Manifestação --}}
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-primary fw-bold border-bottom pb-2">
                                <i class="bi bi-info-circle me-1"></i> Informações Gerais
                            </h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td class="text-muted" style="width: 140px;">Assunto:</td>
                                    <td><strong>{{ $manifestacao->assunto }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Tipo:</td>
                                    <td>{{ $manifestacao->tipo->nome }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Data de Entrada:</td>
                                    <td>{{ $manifestacao->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Prazo Limite:</td>
                                    <td>
                                        <span class="text-{{ $manifestacao->dias_restantes < 0 ? 'danger' : 'success' }}">
                                            {{ $manifestacao->data_limite_resposta ? $manifestacao->data_limite_resposta->format('d/m/Y') : 'Em definição' }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary fw-bold border-bottom pb-2">
                                <i class="bi bi-person-check me-1"></i> Identificação
                            </h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td class="text-muted" style="width: 140px;">Manifestante:</td>
                                    <td>{{ $manifestacao->nome ?? 'Anônimo' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Sigilo de Dados:</td>
                                    <td>{{ $manifestacao->sigilo_dados ? 'Ativado (Dados Protegidos)' : 'Não solicitado' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-primary fw-bold">Descrição do Relato</h6>
                        <div class="p-3 bg-light rounded border">
                            {{ $manifestacao->descricao }}
                        </div>
                    </div>

                    @if($manifestacao->anexo_path)
                    <div class="mb-4 d-print-none">
                        <a href="{{ Storage::url($manifestacao->anexo_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-paperclip"></i> Visualizar Anexo Enviado
                        </a>
                    </div>
                    @endif

                    <hr class="my-4">

                    {{-- 4. Resposta da Ouvidoria --}}
                    <div class="mt-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-chat-dots me-2"></i>Resposta da Ouvidoria</h5>
                        
                        @if($manifestacao->resposta)
                            <div class="card border-primary bg-light">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="badge bg-primary">Resposta Oficial</span>
                                        <span class="text-muted small">Respondido em: {{ $manifestacao->data_resposta ? $manifestacao->data_resposta->format('d/m/Y H:i') : 'Data não registrada' }}</span>
                                    </div>
                                    <div class="text-dark">
                                        {!! nl2br(e($manifestacao->resposta)) !!}
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-secondary">
                                <i class="bi bi-clock-history me-2"></i> Esta manifestação ainda está em fase de análise. Assim que houver uma resposta oficial, ela aparecerá neste local.
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card-footer bg-white py-3 d-print-none">
                    <div class="d-flex justify-content-between">
                        <button onclick="window.print()" class="btn btn-outline-secondary">
                            <i class="bi bi-print me-1"></i> Imprimir Comprovante
                        </button>
                        <a href="{{ route('manifestacoes.acompanhar') }}" class="btn btn-primary">ir para Consulta</a>
                    </div>
                </div>
            </div>

            <p class="text-center text-muted small">
                Portal de Ouvidoria FASPM/PA - Em conformidade com a Lei 13.709/2018 (LGPD)<br>
                Documento gerado em {{ now()->format('d/m/Y H:i:s') }}
            </p>
        </div>
    </div>
</div>
<div class="d-none d-print-block print-footer">
    Documento emitido pelo Sistema de Ouvidoria FASPM/PA em {{ now()->format('d/m/Y H:i:s') }}.<br>
    A autenticidade pode ser verificada no portal com o protocolo e chave de acesso informados.
</div>
<style>
    @media print {
        .d-print-none { display: none !important; }
        .card { border: 1px solid #ddd !important; shadow: none !important; }
        body { background-color: white !important; }
    }

    /* Estilo para visualização na tela (mantido) */
    .border-left-success { border-left: 0.25rem solid #198754 !important; }
    
    @media print {
        /* Configurações da Página A4 */
        @page {
            size: A4;
            margin: 15mm;
        }

        /* Reset de cores para garantir que o azul e cinza apareçam */
        body {
            background-color: white !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        /* Esconder elementos desnecessários na impressão */
        .d-print-none, .btn, .alert, .navbar, footer, .breadcrumb {
            display: none !important;
        }

        /* Ajuste do Card para ocupar a folha toda sem sombras */
        .card {
            border: 1px solid #000 !important;
            box-shadow: none !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        .card-header {
            background-color: #f8f9fa !important;
            border-bottom: 1px solid #000 !important;
            display: block !important;
        }

        /* Forçar colunas do Bootstrap a funcionarem no papel */
        .row { display: flex !important; flex-wrap: wrap !important; }
        .col-md-4 { width: 33.333% !important; }
        .col-md-6 { width: 50% !important; }
        
        /* Garantir que textos em destaque (Protocolo/Token) fiquem visíveis */
        .text-primary { color: #004481 !important; }
        .text-danger { color: #dc3545 !important; }
        
        .card-body { padding: 20px !important; }
        
        /* Evitar que a resposta seja cortada entre duas páginas */
        .card, tr, .p-3 {
            page-break-inside: avoid;
        }
        
        /* Texto de rodapé fixo no fim da página impressa */
        .print-footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            border-top: 1px solid #ccc;
            padding-top: 5px;
        }
</style>
@endsection