@extends('layouts.app')

@section('title', 'Formulário de Registro')

@section('content')
    <h1>Formulário de Registro de Demanda</h1>
    <p>Tipo de Assunto: <strong>{{ $tipo->nome }}</strong></p>

    <form action="{{ route('demanda.store') }}" method="POST">
        @csrf

        <input type="hidden" name="tipo_id" value="{{ $tipo->id }}">

        <div>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome">
        </div>
        <div>
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email">
        </div>
        <div>
            <label for="mensagem">Mensagem:</label>
            <textarea id="mensagem" name="mensagem" rows="5"></textarea>
        </div>

        <button type="submit">Enviar</button>
    </form>
@endsection