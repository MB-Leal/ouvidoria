{{-- @extends('layouts.app') --}}
@extends('layouts.admin-layout')

@section('title', 'Gerenciar Usuários')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gerenciar Usuários</h1>
        <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary">Adicionar Novo Usuário</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Perfil</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>
                                @foreach ($usuario->perfis as $perfil)
                                    <span class="badge bg-primary">{{ $perfil->nome }}</span>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('admin.usuarios.edit', $usuario) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('admin.usuarios.destroy', $usuario) }}" method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $usuarios->links() }}
        </div>
    </div>
@endsection