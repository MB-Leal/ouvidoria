{{-- @extends('layouts.app') --}}
@extends('layouts.admin-layout')

@section('title', 'Editar Usuário')

@section('content')
    <h1>Editar Usuário</h1>
    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary mb-3">Voltar para a lista</a>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.usuarios.update', $usuario) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $usuario->name }}" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $usuario->email }}" required>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="perfil_id" class="form-label">Perfil</label>
                    <select class="form-select" id="perfil_id" name="perfil_id" required>
                        <option value="">Selecione um perfil</option>
                        @foreach ($perfis as $perfil)
                            <option value="{{ $perfil->id }}" {{ $usuario->perfis->first()->id == $perfil->id ? 'selected' : '' }}>{{ $perfil->nome }}</option>
                        @endforeach
                    </select>
                    @error('perfil_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Atualizar Usuário</button>
            </form>
        </div>
    </div>
@endsection