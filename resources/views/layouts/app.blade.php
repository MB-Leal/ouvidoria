<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" 
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        :root {
            --faspm-blue: #1e3a8a;      /* Azul principal FASPM */
            --faspm-light-blue: #3b82f6; /* Azul claro */
            --faspm-white: #ffffff;      /* Branco */
            --faspm-gray: #f8f9fa;       /* Cinza claro */
        }
        
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: var(--faspm-gray);
        }
        
        /* Navbar FASPM */
        .navbar-faspm {
            background: linear-gradient(135deg, var(--faspm-blue) 0%, #2563eb 100%);
            box-shadow: 0 2px 10px rgba(30, 58, 138, 0.2);
        }
        
        /* Botões FASPM */
        .btn-faspm {
            background-color: var(--faspm-blue);
            color: white;
            border: none;
            transition: all 0.3s ease;
        }
        
        .btn-faspm:hover {
            background-color: var(--faspm-light-blue);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3);
        }
        
        /* Cards */
        .card-faspm {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }
        
        .card-faspm:hover {
            transform: translateY(-5px);
        }
        
        /* Footer */
        .footer-faspm {
            background-color: #1e293b;
            color: white;
            margin-top: auto;
        }
        
        /* Logo container */
        .logo-container {
            background: white;
            padding: 8px 15px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        /* Badges personalizados */
        .badge-faspm {
            background-color: var(--faspm-blue);
            color: white;
        }
        
        /* Links */
        a {
            color: var(--faspm-blue);
            text-decoration: none;
        }
        
        a:hover {
            color: var(--faspm-light-blue);
        }
        
        /* Alertas personalizados */
        .alert-faspm {
            border-left: 4px solid var(--faspm-blue);
            background-color: rgba(30, 58, 138, 0.05);
        }
        
        /* Estilo para a página inicial */
        .hero-section {
            background: linear-gradient(rgba(30, 58, 138, 0.9), rgba(37, 99, 235, 0.8)),
                        url('https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 80px 0;
            margin-bottom: 40px;
            border-radius: 0 0 20px 20px;
        }
        
        /* Ajuste para impressão */
        @media print {
            .no-print {
                display: none !important;
            }
        }
        
        /* Responsividade */
        @media (max-width: 768px) {
            .hero-section {
                padding: 40px 0;
                border-radius: 0 0 10px 10px;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-faspm shadow">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <div class="logo-container me-3">
                    @if(file_exists(public_path('images/logomarca_faspm.png')))
                    <img src="{{ asset('images/logomarca_faspm.png') }}" 
                         alt="FASPM/PA" 
                         height="45"
                         class="d-inline-block align-text-top">
                    @else
                    <div class="text-center">
                        <div class="fw-bold text-primary" style="font-size: 18px;">FASPM/PA</div>
                        <div class="text-muted small">Ouvidoria</div>
                    </div>
                    @endif
                </div>
                <div>
                    <span class="fw-bold text-white">Ouvidoria FASPM/PA</span>
                    <br>
                    <small class="text-light opacity-75">Sistema de Manifestações</small>
                </div>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('manifestacoes.create') ? 'active fw-bold' : '' }} text-white" 
                           href="{{ route('manifestacoes.create') }}">
                            <i class="bi bi-plus-circle me-1"></i> Nova Manifestação
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('manifestacoes.acompanhar') ? 'active fw-bold' : '' }} text-white" 
                           href="{{ route('manifestacoes.acompanhar') }}">
                            <i class="bi bi-search me-1"></i> Acompanhar
                        </a>
                    </li>
                    @auth
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
        <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
        <span class="badge bg-{{ Auth::user()->role == 'admin' ? 'danger' : (Auth::user()->role == 'ouvidor' ? 'warning' : 'info') }} ms-1">
            {{ Auth::user()->role_name }}
        </span>
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
        @if(Auth::user()->isAdmin() || Auth::user()->isOuvidor() || Auth::user()->isSecretario())
        <li>
            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-tachometer-alt me-2"></i> Painel Admin
            </a>
        </li>
        <li><hr class="dropdown-divider"></li>
        @endif
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item">
                    <i class="fas fa-sign-out-alt me-2"></i> Sair
                </button>
            </form>
        </li>
    </ul>
</li>
@else
<li class="nav-item">
    <a class="nav-link" href="{{ route('login') }}">
        <i class="fas fa-sign-in-alt me-1"></i> Acesso Admin
    </a>
</li>
@endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Conteúdo Principal -->
    <main class="flex-grow-1">
        <div class="container py-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-4"></i>
                    <div class="flex-grow-1">{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
                    <div class="flex-grow-1">{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h5 class="alert-heading">
                        <i class="bi bi-exclamation-octagon-fill me-2"></i>
                        Erros encontrados:
                    </h5>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer-faspm py-4 mt-5 no-print">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-geo-alt me-2"></i> Localização
                    </h5>
                    <p class="mb-2">
                        <i class="bi bi-building me-2"></i> 
                        Fundo de Assistência Social da Polícia Militar do Pará
                    </p>
                    <p class="mb-2">
                        <i class="bi bi-geo me-2"></i>
                        Tv. Nove de janeiro, 2600, Condor - Belém - Pará, Brasil
                    </p>
                </div>
                
                <div class="col-md-4 mb-3">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-telephone me-2"></i> Contato
                    </h5>
                    <p class="mb-2">
                        <i class="bi bi-envelope me-2"></i>
                        ouvidoria@faspmpa.com.br
                    </p>
                    <p class="mb-2">
                        <i class="bi bi-phone me-2"></i>
                        (91) 3251-3163
                    </p>
                </div>
                
                <div class="col-md-4 mb-3 text-md-end">
                    <div class="logo-container mb-3">
                        @if(file_exists(public_path('images/logomarca_faspm.png')))
                        <img src="{{ asset('images/logomarca_faspm.png') }}" 
                             alt="FASPM/PA" 
                             height="50">
                        @else
                        <div class="text-center text-dark">
                            <div class="fw-bold" style="font-size: 20px;">FASPM/PA</div>
                            <div class="small">Ouvidoria</div>
                        </div>
                        @endif
                    </div>
                    <p class="mb-1">
                        © {{ date('Y') }} - Ouvidoria FASPM/PA
                    </p>
                    <p class="small text-light opacity-75">
                        Sistema de manifestações e sugestões
                    </p>
                </div>
            </div>
            
            <div class="row mt-4 pt-3 border-top border-light border-opacity-25">
                <div class="col-12 text-center">
                    <p class="small mb-0">
                        <i class="bi bi-shield-check me-1"></i>
                        Este é um sistema oficial do FASPM/PA. Suas informações estão protegidas.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts personalizados -->
    <script>
        // Auto-dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
                alerts.forEach(function(alert) {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
        
        // Máscara para telefone
        function mascaraTelefone(telefone) {
            telefone.value = telefone.value.replace(/\D/g, '')
                .replace(/^(\d{2})(\d)/g, '($1) $2')
                .replace(/(\d)(\d{4})$/, '$1-$2');
        }
        
        // Formatar protocolo no input de busca
        document.addEventListener('DOMContentLoaded', function() {
            var protocoloInput = document.querySelector('input[name="protocolo"]');
            if (protocoloInput) {
                protocoloInput.addEventListener('input', function(e) {
                    var value = e.target.value.toUpperCase();
                    value = value.replace(/[^A-Z0-9\-]/g, '');
                    e.target.value = value;
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>