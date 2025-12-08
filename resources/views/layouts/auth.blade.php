<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Acesso - Ouvidoria FASPM/PA')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --faspm-blue: #1e3a8a;
            --faspm-light-blue: #3b82f6;
            --faspm-dark: #1e293b;
            --faspm-gray: #f8f9fa;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .auth-container {
            max-width: 450px;
            width: 100%;
        }
        
        .auth-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background: white;
        }
        
        .auth-header {
            background: linear-gradient(135deg, var(--faspm-blue) 0%, var(--faspm-light-blue) 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .auth-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: white;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .auth-logo i {
            font-size: 36px;
            color: var(--faspm-blue);
        }
        
        .auth-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .auth-subtitle {
            opacity: 0.9;
            font-size: 14px;
        }
        
        .auth-body {
            padding: 40px;
        }
        
        .form-control {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 15px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--faspm-light-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .form-label {
            font-weight: 500;
            color: var(--faspm-dark);
            margin-bottom: 8px;
        }
        
        .btn-faspm {
            background: linear-gradient(135deg, var(--faspm-blue) 0%, var(--faspm-light-blue) 100%);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-faspm:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.3);
            color: white;
        }
        
        .auth-footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            margin-top: 30px;
            color: #64748b;
            font-size: 14px;
        }
        
        .auth-footer a {
            color: var(--faspm-blue);
            text-decoration: none;
        }
        
        .auth-footer a:hover {
            color: var(--faspm-light-blue);
            text-decoration: underline;
        }
        
        .alert {
            border-radius: 8px;
            border: none;
            padding: 15px 20px;
        }
        
        .input-group-text {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-right: none;
        }
        
        .input-group .form-control {
            border-left: none;
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
        }
        
        .password-toggle:hover {
            color: var(--faspm-blue);
        }
        
        /* Responsivo */
        @media (max-width: 576px) {
            .auth-body {
                padding: 30px 20px;
            }
            
            .auth-header {
                padding: 20px;
            }
        }
        
        /* Animações */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .auth-card {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center py-5">
        <div class="auth-container">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts personalizados -->
    <script>
        // Toggle de senha
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButtons = document.querySelectorAll('.password-toggle');
            
            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.previousElementSibling;
                    const icon = this.querySelector('i');
                    
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('bi-eye');
                        icon.classList.add('bi-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('bi-eye-slash');
                        icon.classList.add('bi-eye');
                    }
                });
            });
            
            // Auto-foco no primeiro campo
            const firstInput = document.querySelector('input[type="email"], input[type="text"]');
            if (firstInput) {
                firstInput.focus();
            }
        });
    </script>
    
    @stack('scripts')
    
</body>
</html>