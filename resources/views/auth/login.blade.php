@extends('layouts.auth')

@section('title', 'Login - Ouvidoria FASPM/PA')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <div class="auth-logo">
            <i class="fas fa-shield-alt"></i>
        </div>
        <h1 class="auth-title">Ouvidoria FASPM/PA</h1>
        <p class="auth-subtitle">Sistema de Manifestações</p>
    </div>
    
    <div class="auth-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong>Credenciais inválidas.</strong> Verifique seu email e senha.
            </div>
        @endif
        
        @if (session('status'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('status') }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="mb-4">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope me-1"></i> E-mail
                </label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-user"></i>
                    </span>
                    <input 
                        type="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder="seu.email@exemplo.com"
                        required 
                        autofocus
                        autocomplete="email">
                </div>
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-4">
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
                            placeholder="Digite sua senha"
                            required 
                            autocomplete="current-password">
                    </div>
                    <button type="button" class="password-toggle">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        Manter conectado
                    </label>
                </div>
                
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-decoration-none">
                    <small><i class="fas fa-question-circle me-1"></i> Esqueceu a senha?</small>
                </a>
                @endif
            </div>
            
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-faspm">
                    <i class="fas fa-sign-in-alt me-2"></i> Entrar no Sistema
                </button>
                
                <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-home me-2"></i> Voltar ao Site
                </a>
            </div>
        </form>
        
        <div class="auth-footer mt-4">
            <p class="mb-2">
                <i class="fas fa-info-circle me-1"></i>
                Acesso restrito aos colaboradores da FASPM/PA
            </p>
            <p class="mb-0">
                © {{ date('Y') }} - Fundação de Apoio à Saúde do Pará
            </p>
        </div>
    </div>
</div>

<script>
    // Adicionar validação em tempo real
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        
        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
        
        function updateValidation(input, isValid) {
            if (isValid) {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
            } else {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
            }
        }
        
        emailInput.addEventListener('blur', function() {
            updateValidation(this, validateEmail(this.value));
        });
        
        passwordInput.addEventListener('blur', function() {
            updateValidation(this, this.value.length >= 6);
        });
        
        form.addEventListener('submit', function(e) {
            if (!validateEmail(emailInput.value)) {
                e.preventDefault();
                emailInput.focus();
                updateValidation(emailInput, false);
                return false;
            }
            
            if (passwordInput.value.length < 6) {
                e.preventDefault();
                passwordInput.focus();
                updateValidation(passwordInput, false);
                return false;
            }
            
            // Mostrar loading
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Entrando...';
            submitBtn.disabled = true;
        });
    });
</script>
@endsection