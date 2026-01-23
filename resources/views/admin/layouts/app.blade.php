<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!-- 
        ====================================================
        Assinatura do Desenvolvedor
        Projeto: Ouvidoria
        Autor: Marcos Barroso Leal
        Data: 09/12/2025
        E-mail: marcosbleal26@gmail.com
        Copyright (c) 2025
        ====================================================
    -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin - Sistema de Ouvidoria')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles Admin -->
    <style>
        :root {
            --sidebar-width: 250px;
            --navbar-height: 60px;
            --primary-color: #4e73df;
            --secondary-color: #858796;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fc;
        }

        /* Navbar Admin */
        .navbar-admin {
            background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
            box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
            height: var(--navbar-height);
        }

        .navbar-admin .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
        }

        /* Sidebar Admin */
        .sidebar-admin {
            width: var(--sidebar-width);
            min-height: calc(100vh - var(--navbar-height));
            background: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, .1);
            position: fixed;
            top: var(--navbar-height);
            left: 0;
            z-index: 100;
            transition: transform 0.3s ease;
            overflow-y: auto;
        }

        /* Menu Sidebar */
        .sidebar-admin .nav-item {
            margin-bottom: 0.25rem;
        }

        .sidebar-admin .nav-link {
            color: #6e707e;
            font-weight: 500;
            padding: 0.75rem 1rem;
            border-left: 3px solid transparent;
            transition: all 0.3s;
        }

        .sidebar-admin .nav-link:hover {
            color: var(--primary-color);
            background-color: #f8f9fc;
        }

        .sidebar-admin .nav-link.active {
            color: var(--primary-color);
            background-color: #f8f9fc;
            border-left-color: var(--primary-color);
        }

        .sidebar-admin .nav-link i {
            width: 20px;
            text-align: center;
            margin-right: 10px;
            font-size: 0.9rem;
        }

        /* Conteúdo Principal */
        .main-content-admin {
            margin-left: var(--sidebar-width);
            padding: 1.5rem;
            min-height: calc(100vh - var(--navbar-height));
            transition: margin-left 0.3s ease;
        }

        /* Responsividade */
        @media (max-width: 991.98px) {
            .sidebar-admin {
                transform: translateX(-100%);
            }

            .sidebar-admin.show {
                transform: translateX(0);
            }

            .main-content-admin {
                margin-left: 0;
                padding: 1rem;
            }

            /* Overlay para mobile */
            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 99;
                display: none;
            }

            .sidebar-overlay.show {
                display: block;
            }
        }

        /* Cards Admin */
        .card-admin {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border-radius: 0.35rem;
            margin-bottom: 1.5rem;
        }

        .card-header-admin {
            background-color: #fff;
            border-bottom: 1px solid #e3e6f0;
            padding: 1rem 1.35rem;
            border-radius: 0.35rem 0.35rem 0 0 !important;
        }

        /* Botões Admin */
        .btn-admin-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
            border: none;
            color: white;
            font-weight: 500;
        }

        .btn-admin-primary:hover {
            background: linear-gradient(135deg, #4263d1 0%, #1a3da3 100%);
            color: white;
        }

        /* Breadcrumb Admin */
        .breadcrumb-admin {
            background-color: transparent;
            padding: 0.75rem 0;
            margin-bottom: 1rem;
        }

        .breadcrumb-admin .breadcrumb-item.active {
            color: var(--primary-color);
            font-weight: 500;
        }

        /* Tabelas Admin */
        .table-admin th {
            border-top: none;
            font-weight: 600;
            color: #6e707e;
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
        }

        .table-admin td {
            vertical-align: middle;
        }

        /* Badges Admin */
        .badge-admin {
            font-weight: 500;
            padding: 0.35em 0.65em;
            font-size: 0.75em;
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Navbar Admin -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-admin">
        <div class="container-fluid">
            <!-- Botão para toggle da sidebar em mobile -->
            <button class="btn btn-link text-white sidebar-toggle d-lg-none me-2" id="sidebarToggle">
                <i class="fas fa-bars fa-lg"></i>
            </button>

            <!-- Logo/Marca -->
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-comments me-2"></i>
                <span class="d-none d-sm-inline">Ouvidoria Admin</span>
            </a>

            <!-- Menu do Usuário -->
            <div class="d-flex align-items-center ms-auto">
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-1"></i>
                        <span class="d-none d-sm-inline">{{ Auth::user()->name ?? 'Admin' }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('home') }}" target="_blank">
                                <i class="fas fa-external-link-alt me-2"></i> Site Público
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i> Sair
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Overlay para mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar Admin -->
    <div class="sidebar-admin" id="sidebarAdmin">
        <div class="sidebar-inner py-3">
            <!-- Menu de Navegação -->
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                        href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>

                <!-- Menu Manifestações com Submenu -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.manifestacoes*') ? 'active' : '' }}"
                        data-bs-toggle="collapse" href="#collapseManifestacoes" role="button">
                        <i class="fas fa-comments"></i> Manifestações
                        <i class="fas fa-chevron-down float-end mt-1"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('admin.manifestacoes*') ? 'show' : '' }}"
                        id="collapseManifestacoes">
                        <ul class="nav flex-column ms-4">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.manifestacoes.index') ? 'active' : '' }}"
                                    href="{{ route('admin.manifestacoes.index') }}">
                                    <i class="fas fa-list"></i> Listar Todas
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.manifestacoes.create.manual') ? 'active' : '' }}"
                                    href="{{ route('admin.manifestacoes.create.manual') }}">
                                    <i class="fas fa-plus-circle"></i> Nova Manual
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.manifestacoes.index', ['status' => 'ABERTO']) }}">
                                    <i class="fas fa-clock text-warning"></i> Em Aberto
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.manifestacoes.index', ['status' => 'EM_ANALISE']) }}">
                                    <i class="fas fa-search text-info"></i> Em Análise
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.tipos*') ? 'active' : '' }}"
                        href="{{ route('admin.tipos.index') }}">
                        <i class="fas fa-tags"></i> Tipos
                    </a>
                </li>

                @if(Auth::check() && Auth::user()->isAdmin())
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
        </div>
    </div>

    <!-- Conteúdo Principal -->
    <main class="main-content-admin" id="mainContentAdmin">
        @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
        @endif

        @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif
        <!-- Breadcrumb -->
        @hasSection('breadcrumb')
        @yield('breadcrumb')
        @else
        <nav aria-label="breadcrumb" class="breadcrumb-admin">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i></a></li>
                @yield('breadcrumb-items')
            </ol>
        </nav>
        @endif

        <!-- Título da Página -->
        @hasSection('page-header')
        @yield('page-header')
        @else
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                @yield('page-title')
            </h1>
            @hasSection('page-actions')
            @yield('page-actions')
            @endif
        </div>
        @endif

        <!-- Conteúdo -->
        @yield('content')
    </main>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Scripts Admin -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebarAdmin');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            // Toggle da Sidebar
            function toggleSidebar() {
                sidebar.classList.toggle('show');
                sidebarOverlay.classList.toggle('show');
                document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
            }

            // Event Listeners
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', toggleSidebar);
            }

            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', toggleSidebar);
            }

            // Fechar sidebar ao clicar em um link (mobile)
            const sidebarLinks = sidebar.querySelectorAll('.nav-link');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Não fechar se for um toggle de collapse
                    if (!this.hasAttribute('data-bs-toggle') || this.getAttribute('data-bs-toggle') !== 'collapse') {
                        if (window.innerWidth < 992) {
                            toggleSidebar();
                        }
                    }
                });
            });

            // Auto-dismiss alerts
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
                alerts.forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

            // Ativar tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

    @stack('scripts')
</body>

</html>