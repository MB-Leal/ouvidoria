@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            {{-- 1. Card de Sucesso (Exibido apenas após o cadastro) --}}
            @if(session('success') && session('chave_acesso'))
                <div class="alert alert-success shadow-sm border-left-success mb-4">
                    <h4 class="alert-heading"><i class="bi bi-check-circle-fill me-2"></i>Protocolo Gerado com Sucesso!</h4>
                    <p>Sua manifestação foi recebida. <strong>Anote os dados abaixo para consultas futuras:</strong></p>
                    <div class="d-flex gap-4 mt-2">
                        <div><small class="text-uppercase d-block">Protocolo</small> <strong>{{ $manifestacao->protocolo }}</strong></div>
                        <div><small class="text-uppercase d-block">Chave de Acesso (Token)</small> <strong class="text-danger">{{ session('chave_acesso') }}</strong></div>
                    </div>
                </div>
            @endif

            {{-- 2. Cabeçalho de Status --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <div>
                        <span class="text-muted small text-uppercase d-block">Status da Manifestação</span>
                        <span class="badge rounded-pill bg-{{ $manifestacao->status_cor }} fs-6">
                            {{ $manifestacao->status_formatado }}
                        </span>
                    </div>
                    <div class="text-end">
                        <span class="text-muted small text-uppercase d-block">Protocolo</span>
                        <span class="fw-bold">{{ $manifestacao->protocolo }}</span>
                    </div>
                </div>

                {{-- 3. Corpo Principal - Dados da Manifestação --}}
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-primary fw-bold"><i class="bi bi-info-circle me-1"></i> Informações Gerais</h6>
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
                                    <td>{{ $manifestacao->data_entrada->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Prazo Limite:</td>
                                    <td><span class="text-{{ $manifestacao->dias_restantes < 0 ? 'danger' : 'success' }}">
                                        {{ $manifestacao->data_limite_resposta ? $manifestacao->data_limite_resposta->format('d/m/Y') : 'Em definição' }}
                                    </span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary fw-bold"><i class="bi bi-person-check me-1"></i> Identificação</h6>
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
                        <div class="p-3 bg-light rounded border italic">
                            {{ $manifestacao->descricao }}
                        </div>
                    </div>

                    @if($manifestacao->anexo_path)
                    <div class="mb-4">
                        <a href="{{ Storage::url($manifestacao->anexo_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-paperclip"></i> Visualizar Anexo Enviado
                        </a>
                    </div>
                    @endif

                    <hr>

                    {{-- 4. Resposta da Ouvidoria (A parte mais importante para o manifestante) --}}
                    <div class="mt-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-chat-dots me-2"></i>Resposta da Ouvidoria</h5>
                        
                        @if($manifestacao->resposta)
                            <div class="card border-primary bg-light">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="badge bg-primary">Resposta Oficial</span>
                                        <span class="text-muted small">Respondido em: {{ $manifestacao->respondido_em ? $manifestacao->respondido_em->format('d/m/Y H:i') : 'Data não registrada' }}</span>
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

                <div class="card-footer bg-white py-3">
                    <div class="d-flex justify-content-between">
                        <button onclick="window.print()" class="btn btn-outline-secondary">
                            <i class="bi bi-print me-1"></i> Imprimir
                        </button>
                        <a href="{{ route('manifestacoes.acompanhar') }}" class="btn btn-primary">Nova Consulta</a>
                    </div>
                </div>
            </div>

            <p class="text-center text-muted small">
                Portal de Ouvidoria FASPM/PA - Em conformidade com a Lei 13.709/2018 (LGPD)
            </p>
        </div>
    </div>
</div>
@endsection