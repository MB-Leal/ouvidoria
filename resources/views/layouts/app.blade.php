<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Ouvidoria') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header>
    {{-- Barra superior com acessibilidade, redes sociais e transparência --}}
    <div class="top-bar py-2" style="background-color: #f1f1f1;">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            {{-- Ferramentas de Acessibilidade --}}
            <div class="accessibility-tools">
                <button class="btn btn-sm btn-light" id="increaseFont" title="Aumentar Fonte">A+</button>
                <button class="btn btn-sm btn-light" id="decreaseFont" title="Diminuir Fonte">A-</button>
                <button class="btn btn-sm btn-light" id="toggleContrast" title="Alto Contraste">Contraste</button>
            </div>

            {{-- Links de Redes Sociais e Transparência --}}
            <div class="social-links-search d-flex align-items-center">
                <a href="https://transparencia.pa.gov.br/" target="_blank" class="text-secondary me-3" title="Portal da Transparência Pará">
                    <i class="fa-solid fa-file-invoice"></i> Portal da Transparência
                </a>
                <a href="#" class="me-2 text-secondary"><i class="fa-brands fa-facebook-f" title="Facebook"></i></a>
                <a href="#" class="me-2 text-secondary"><i class="fa-brands fa-twitter" title="Twitter"></i></a>
                <a href="#" class="me-2 text-secondary"><i class="fa-brands fa-instagram" title="Instagram"></i></a>
                
                {{-- Campo de Busca --}}
                <form action="{{ route('buscar') }}" method="GET" class="d-flex ms-3">
                    <input class="form-control form-control-sm me-2" type="search" name="q" placeholder="Buscar..." aria-label="Search">
                    <button class="btn btn-sm btn-outline-secondary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
        </div>
    </div>
    
    {{-- Navbar principal --}}
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('assets/imgs/logo.png') }}" alt="Logo Ouvidoria" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('fale-conosco.create') }}">Fale Conosco</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"  href="{{ route('demanda.create', ['tipo' => 'reclamacao']) }}">Registrar Reclamação</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('demanda.create', ['tipo' => 'sugestao']) }}">Registrar Sugestão</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('demanda.consultar') }}">Consultar Demanda</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto navbar-right-links">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
    
    <div class="container mt-4">
        @yield('content')
    </div>

     @include('layouts._footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</html>