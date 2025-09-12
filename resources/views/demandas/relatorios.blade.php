@extends('layouts.app')

@section('title', 'Relatórios Públicos')

@section('content')
    <div class="text-center">
        <h1>Relatórios de Desempenho da Ouvidoria</h1>
    </div>

    <div class="row mt-4">
        <div class="col-md-6 mb-3">
            <div class="card text-center bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Demandas Recebidas</h5>
                    <h2>{{ $totalDemandas }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card text-center bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Demandas Solucionadas</h5>
                    <h2>{{ $demandasSolucionadas }}</h2>
                </div>
            </div>
        </div>
    </div>

    <h2 class="mt-5">Elogios em Destaque</h2>
    @forelse ($elogios as $elogio)
        <div class="card mb-3">
            <div class="card-body">
                <p class="card-text">"{{ $elogio->mensagem }}"</p>
                <footer class="blockquote-footer">Por <cite title="Source Title">{{ $elogio->nome ?? 'Anônimo' }}</cite></footer>
            </div>
        </div>
    @empty
        <p>Ainda não há elogios para serem exibidos.</p>
    @endforelse
@endsection