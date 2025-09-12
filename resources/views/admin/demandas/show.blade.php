{{-- @extends('layouts.app') --}}

@extends('layouts.admin-layout')

@section('title', 'Detalhes da Demanda')

@section('content')
    <h1>Detalhes da Demanda</h1>
    <a href="{{ route('admin.demandas.index') }}" class="btn btn-secondary mb-3">Voltar para a lista</a>
    
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="card">
        <div class="card-header">
            Protocolo: {{ $demanda->protocolo }}
        </div>
        <div class="card-body">
            <p><strong>Tipo:</strong> {{ $demanda->tipo->nome }}</p>
            <p><strong>Status:</strong> {{ $demanda->status }}</p>
            <p><strong>Nome:</strong> {{ $demanda->nome ?? 'Anônimo' }}</p>
            <p><strong>E-mail:</strong> {{ $demanda->email ?? 'Não informado' }}</p>
            <p><strong>Mensagem:</strong> <br>{{ $demanda->mensagem }}</p>
        </div>
    </div>

    <hr>

    <div class="mt-4">
        <h2>Pareceres</h2>
        @foreach ($demanda->pareceres as $parecer)
            <div class="card mb-3">
                <div class="card-body">
                    <p>{{ $parecer->parecer }}</p>
                    <footer class="blockquote-footer">Adicionado por: {{ $parecer->usuario->name ?? 'Usuário Desconhecido' }} em {{ $parecer->created_at->format('d/m/Y H:i') }}</footer>
                </div>
            </div>
        @endforeach

        <h3>Adicionar Novo Parecer</h3>
        <form action="{{ route('admin.demandas.store_parecer', $demanda) }}" method="POST">
            @csrf
            <div class="mb-3">
                <textarea name="parecer" class="form-control" rows="5" placeholder="Digite seu parecer aqui..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Adicionar Parecer</button>
        </form>
    </div>
@endsection