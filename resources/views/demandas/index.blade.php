@extends('layouts.app')

@section('title', 'Registrar Demanda')

@section('content')
    <h1>Selecione o Tipo de Demanda</h1>

    @if($tipos->count() > 0)
        <div class="cards-container">
            @foreach ($tipos as $tipo)
                <a href="{{ route('demanda.create', $tipo->id) }}">
                    <div class="card">
                        <h3>{{ $tipo->nome }}</h3>
                        <p>{{ $tipo->descricao }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <p>Nenhum tipo de demanda disponível no momento.</p>
    @endif
@endsection