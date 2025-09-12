{{-- @extends('layouts.app') --}}
@extends('layouts.admin-layout')

@section('title', 'Adicionar Usuário')

@section('content')
    <h1>Adicionar Novo Usuário</h1>
    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary mb-3">Voltar para a lista</a>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.usuarios.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirme a Senha</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
                <div class="mb-3">
                    <label for="perfil_id" class="form-label">Perfil</label>
                    <select class="form-select" id="perfil_id" name="perfil_id" required>
                        <option value="">Selecione um perfil</option>
                        @foreach ($perfis as $perfil)
                            <option value="{{ $perfil->id }}">{{ $perfil->nome }}</option>
                        @endforeach
                    </select>
                    @error('perfil_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Salvar Usuário</button>
            </form>
        </div>
    </div>
@endsection