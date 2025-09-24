@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white text-center">
                <h1 class="card-title mb-0">Consultar Demanda</h1>
            </div>
            <div class="card-body">
                <p class="text-center text-muted">Digite o protocolo e e-mail para consultar o status da sua demanda.</p>
                <form action="{{ route('demanda.show') }}" method="GET">
                    @csrf
                    <div class="mb-3">
                        <label for="protocolo" class="form-label">Número de Protocolo</label>
                        <input type="text" class="form-control" id="protocolo" name="protocolo" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Endereço de E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Consultar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection