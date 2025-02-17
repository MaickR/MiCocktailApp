<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Cócteles</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    @yield('styles')

    <style>
        /* ===== NAVBAR ===== */
.navbar-glass {
    background: rgba(26, 26, 46, 0.85) !important;
    backdrop-filter: blur(15px);
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    padding: 0.8rem 0;
}

.navbar-brand.gradient-text {
    background: linear-gradient(45deg, #7a9eee, #aa7df8);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    font-weight: 700;
    letter-spacing: 0.5px;
    font-size: 1.5rem;
    animation: float 3s ease-in-out infinite;
}

.nav-link {
    color: rgba(255, 255, 255, 0.8) !important;
    font-weight: 500;
    position: relative;
    padding: 0.5rem 1rem !important;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.nav-link.hover-glow:hover {
    color: white !important;
    background: rgba(255, 255, 255, 0.05);
    transform: translateY(-2px);
}

.nav-link i {
    width: 24px;
    text-align: center;
}

.btn-logout {
    background: rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.8) !important;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    padding: 0.5rem 1.5rem;
    transition: all 0.3s ease;
}

.btn-logout:hover {
    background: rgba(255, 255, 255, 0.2);
    color: white !important;
    transform: translateY(-2px);
}

/* ===== MAIN CONTENT ===== */
.main-content {
    padding-top: 100px;
    min-height: calc(100vh - 100px);
}

.glass-alert {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    padding: 1rem 1.5rem;
    margin: 1.5rem 0;
}

.glass-alert.alert-success {
    color: #4ade80;
    border-left: 4px solid #4ade80;
}

.glass-alert.alert-danger {
    color: #f87171;
    border-left: 4px solid #f87171;
}

/* ===== ANIMACIONES ===== */
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}

/* ===== RESPONSIVIDAD ===== */
@media (max-width: 992px) {
    .navbar-collapse {
        background: rgba(26, 26, 46, 0.95);
        padding: 1rem;
        margin-top: 1rem;
        border-radius: 12px;
    }
    
    .nav-item {
        margin: 0.5rem 0;
    }
    
    .btn-logout {
        width: 100%;
        margin-top: 1rem;
    }
}
    </style>
</head>
<body>
    <!-- Menú de navegación -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-glass">
        <div class="container">
            <a class="navbar-brand gradient-text" href="{{ route('home') }}">
                <i class="bi bi-cup-straw me-2"></i>MiCocktail App
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item mx-2">
                        <a class="nav-link hover-glow" href="{{ route('home') }}">
                            <i class="bi bi-house-door me-1"></i>Inicio
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link hover-glow" href="{{ route('search') }}">
                            <i class="bi bi-search me-1"></i>Explorar
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link hover-glow" href="{{ route('cocktails.index') }}">
                            <i class="bi bi-bar-chart-line me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link hover-glow" href="{{ route('profile.edit') }}">
                            <i class="bi bi-gear me-1"></i>Ajustes
                        </a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-logout">
                            <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <main class="main-content">
        <div class="container">
            <!-- Alertas estilizadas -->
            @if(session('success'))
            <div class="glass-alert alert-success">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            </div>
            @endif
            
            @if(session('error'))
            <div class="glass-alert alert-danger">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            </div>
            @endif
    
            @yield('content')
        </div>
    </main>

   
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
    @yield('scripts')
    
</body>
</html>
