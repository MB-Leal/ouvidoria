@extends('layouts.auth')

@section('title', 'Recuperar Senha - Ouvidoria FASPM/PA')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <div class="auth-logo">
            <i class="fas fa-key"></i>
        </div>
        <h1 class="auth-title">Recuperar Senha</h1>
        <p class="auth-subtitle">Ouvidoria FASPM/PA</p>
    </div>
    
    <div class="auth-body">
        @if (session('status'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('status') }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            
            <div class="mb-4">
                <p class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    Digite seu e-mail institucional para receber um link de redefinição de senha.
                </p>
            </div>
            
            <div class="mb-4">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope me-1"></i> E-mail Institucional
                </label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-at"></i>
                    </span>
                    <input 
                        type="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder="seu.nome@faspmpa.com.br"
                        required 
                        autofocus
                        autocomplete="email">
                </div>
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-faspm">
                    <i class="fas fa-paper-plane me-2"></i> Enviar Link de Recuperação
                </button>
                
                <a href="{{ route('login') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Voltar para o Login
                </a>
            </div>
        </form>
        
        <div class="auth-footer mt-4">
            <p class="mb-0">
                <i class="fas fa-headset me-1"></i>
                Dúvidas? Entre em contato com o suporte técnico.
            </p>
        </div>
    </div>
</div>
@endsection