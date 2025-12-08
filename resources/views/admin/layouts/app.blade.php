<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Sistema de Ouvidoria')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" 
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Styles -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f8f9fc;
        }
        
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        
        .sidebar {
            min-height: calc(100vh - 73px);
            background: #fff;
            box-shadow: 0 0 15px rgba(0,0,0,.1);
        }
        
        .sidebar .nav-link {
            color: #6e707e;
            font-weight: 500;
            padding: 0.75rem 1rem;
            border-left: 3px solid transparent;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover {
            color: #4e73df;
            background-color: #f8f9fc;
        }
        
        .sidebar .nav-link.active {
            color: #4e73df;
            background-color: #f8f9fc;
            border-left-color: #4e73df;
        }
        
        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
            margin-right: 10px;
        }
        
        .card {
            border: none;
            box-shadow: 0 0 15px rgba(0,0,0,.08);
            border-radius: 10px;
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #e3e6f0;
            padding: 1rem 1.35rem;
            border-radius: 10px 10px 0 0 !important;
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            color: #6e707e;
            background-color: #f8f9fc;
        }
        
        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
        }
        
        .btn {
            border-radius: 0.375rem;
            font-weight: 500;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,.15);
        }
        
        .alert {
            border: none;
            border-radius: 10px;
        }
        
        .pagination .page-link {
            color: #4e73df;
            border: 1px solid #e3e6f0;
        }
        
        .pagination .page-item.active .page-link {
            background-color: #4e73df;
            border-color: #4e73df;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-comments me-2"></i> Ouvidoria
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name ?? 'Usuário' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Meu Perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
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
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block sidebar collapse py-3">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                               href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.manifestacoes*') ? 'active' : '' }}" 
                               href="{{ route('admin.manifestacoes.index') }}">
                                <i class="fas fa-comments"></i> Manifestações
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.tipos*') ? 'active' : '' }}" 
                               href="{{ route('admin.tipos.index') }}">
                                <i class="fas fa-tags"></i> Tipos
                            </a>
                        </li>
                        
                        @if(Auth::user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" 
                               href="{{ route('admin.users.index') }}">
                                <i class="fas fa-users"></i> Usuários
                            </a>
                        </li>
                        @endif
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.relatorios*') ? 'active' : '' }}" 
                               href="{{ route('admin.relatorios.index') }}">
                                <i class="fas fa-chart-line"></i> Relatórios
                            </a>
                        </li>
                    </ul>
                    
                    <!-- Filtros Rápidos (apenas na página de manifestações) -->
                    @if(request()->routeIs('admin.manifestacoes.index'))
                    <div class="mt-4 pt-3 border-top">
                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-2 mb-1 text-muted">
                            <span>Filtros Rápidos</span>
                        </h6>
                        <ul class="nav flex-column small">
                            <li class="nav-item">
                                <a class="nav-link text-danger" href="{{ route('admin.manifestacoes.index', ['status' => 'ABERTO']) }}">
                                    <i class="fas fa-clock"></i> Em Aberto
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-info" href="{{ route('admin.manifestacoes.index', ['status' => 'EM_ANALISE']) }}">
                                    <i class="fas fa-search"></i> Em Análise
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-success" href="{{ route('admin.manifestacoes.index', ['status' => 'RESPONDIDO']) }}">
                                    <i class="fas fa-check-circle"></i> Respondidas
                                </a>
                            </li>
                        </ul>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Conteúdo Principal -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer mt-auto py-3 bg-white border-top">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted">
                        <i class="fas fa-copyright"></i> {{ date('Y') }} Sistema de Ouvidoria
                    </span>
                </div>
                <div class="text-muted">
                    <small>Versão 1.0.0</small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle com Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts Gerais -->
    <script>
        // Ativar tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
            
            // Auto-dismiss alerts após 5 segundos
            setTimeout(function() {
                var alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
                alerts.forEach(function(alert) {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
            
            // Toggle sidebar em mobile
            document.querySelector('.navbar-toggler').addEventListener('click', function() {
                document.querySelector('.sidebar').classList.toggle('show');
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>