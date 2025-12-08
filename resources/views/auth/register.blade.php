@extends('layouts.auth')

@section('title', 'Registro - Ouvidoria FASPM/PA')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <div class="auth-logo">
            <i class="fas fa-user-plus"></i>
        </div>
        <h1 class="auth-title">Criar Conta</h1>
        <p class="auth-subtitle">Ouvidoria FASPM/PA</p>
    </div>
    
    <div class="auth-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong>Erro no registro.</strong> Verifique os dados informados.
            </div>
        @endif
        
        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="mb-3">
                <label for="name" class="form-label">
                    <i class="fas fa-user me-1"></i> Nome Completo
                </label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-id-card"></i>
                    </span>
                    <input 
                        type="text" 
                        class="form-control @error('name') is-invalid @enderror" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}" 
                        placeholder="Seu nome completo"
                        required 
                        autofocus
                        autocomplete="name">
                </div>
                @error('name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
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
                        autocomplete="email">
                </div>
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">
                    <i class="fas fa-lock me-1"></i> Senha
                </label>
                <div class="position-relative">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-key"></i>
                        </span>
                        <input 
                            type="password" 
                            class="form-control @error('password') is-invalid @enderror" 
                            id="password" 
                            name="password" 
                            placeholder="Mínimo 8 caracteres"
                            required 
                            autocomplete="new-password">
                    </div>
                    <button type="button" class="password-toggle">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                <small class="text-muted">A senha deve ter pelo menos 8 caracteres.</small>
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="password_confirmation" class="form-label">
                    <i class="fas fa-lock me-1"></i> Confirmar Senha
                </label>
                <div class="position-relative">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-key"></i>
                        </span>
                        <input 
                            type="password" 
                            class="form-control" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            placeholder="Digite a senha novamente"
                            required 
                            autocomplete="new-password">
                    </div>
                    <button type="button" class="password-toggle">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
            
            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="terms" required>
                    <label class="form-check-label" for="terms">
                        Concordo com os <a href="#" class="text-decoration-none">Termos de Uso</a> e 
                        <a href="#" class="text-decoration-none">Política de Privacidade</a>
                    </label>
                </div>
            </div>
            
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-faspm">
                    <i class="fas fa-user-plus me-2"></i> Criar Conta
                </button>
                
                <a href="{{ route('login') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-sign-in-alt me-2"></i> Já tenho uma conta
                </a>
                
                <a href="{{ route('home') }}" class="btn btn-outline-dark">
                    <i class="fas fa-home me-2"></i> Voltar ao Site
                </a>
            </div>
        </form>
        
        <div class="auth-footer mt-4">
            <p class="mb-2">
                <i class="fas fa-shield-alt me-1"></i>
                Suas informações estão protegidas
            </p>
            <p class="mb-0">
                © {{ date('Y') }} - FASPM/PA • Todos os direitos reservados
            </p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');
        
        function validatePassword() {
            if (password.value.length < 8) {
                password.classList.add('is-invalid');
                return false;
            }
            
            if (password.value !== confirmPassword.value) {
                confirmPassword.classList.add('is-invalid');
                return false;
            }
            
            password.classList.remove('is-invalid');
            confirmPassword.classList.remove('is-invalid');
            return true;
        }
        
        password.addEventListener('input', validatePassword);
        confirmPassword.addEventListener('input', validatePassword);
        
        form.addEventListener('submit', function(e) {
            if (!validatePassword() || !document.getElementById('terms').checked) {
                e.preventDefault();
                return false;
            }
        });
    });
</script>
@endsection