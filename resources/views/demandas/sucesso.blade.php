@extends('layouts.app')

@section('title', 'Demanda Registrada com Sucesso!')

@section('content')
    <div class="alert alert-success text-center">
        <h2>Demanda Registrada com Sucesso!</h2>
        <p>Sua manifestação foi enviada para a Ouvidoria.</p>
        <p>Seu número de registro é: <strong>{{ session('protocolo') }}</strong></p>
        <p>Uma cópia deste registro foi enviada para o e-mail: <strong>{{ session('email') }}</strong></p>
        <hr>
        <a href="{{ route('home') }}" class="btn btn-primary">Voltar para a Página Inicial</a>
    </div>
@endsection