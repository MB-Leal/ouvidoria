{{--@extends('layouts.app') --}}

@extends('layouts.admin-layout')

@section('title', 'Gerenciar Demandas')

@section('content')
    <h1>Gerenciar Demandas</h1>

    <div class="card mb-4">
        <div class="card-header">Filtros</div>
        <div class="card-body">
            {{-- Formulário de filtro viria aqui --}}
        </div>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Protocolo</th>
                <th>Tipo</th>
                <th>Status</th>
                <th>Mensagem</th>
                <th>Data</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($demandas as $demanda)
                <tr>
                    <td>{{ $demanda->protocolo }}</td>
                    <td>{{ $demanda->tipo->nome }}</td>
                    <td>{{ $demanda->status }}</td>
                    <td>{{ Str::limit($demanda->mensagem, 50) }}</td>
                    <td>{{ $demanda->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('admin.demandas.show', $demanda) }}" class="btn btn-sm btn-info">Ver</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Paginação --}}
    {{ $demandas->links() }}
@endsection