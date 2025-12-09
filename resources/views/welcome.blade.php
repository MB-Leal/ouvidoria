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