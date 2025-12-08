@extends('layouts.app')

@section('title', 'Gestão de Tipos de Manifestação')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-tags me-2"></i> Tipos de Manifestação
        </h1>
        <a href="{{ route('admin.tipos.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-1"></i> Novo Tipo
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de Tipos</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Cor de Destaque</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tipos as $tipo)
                        <tr>
                            <td>{{ $tipo->id }}</td>
                            <td>{{ $tipo->nome }}</td>
                            <td>
                                <span class="badge" style="background-color: {{ $tipo->cor }}; color: #FFF; padding: 5px 10px;">
                                    {{ $tipo->cor }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.tipos.edit', $tipo) }}" class="btn btn-sm btn-info" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.tipos.destroy', $tipo) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este tipo?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Nenhum tipo de manifestação cadastrado.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                {{ $tipos->links() }}
            </div>
        </div>
    </div>
</div>
@endsection