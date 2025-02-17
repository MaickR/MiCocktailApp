<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenido - Mi Cocktail App</title>

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #7c3aed;
            --dark-color: #1e293b;
            --light-color: #f8fafc;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(45deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--dark-color) !important;
            letter-spacing: -0.5px;
        }

        .navbar-brand span {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .hero-section {
            flex: 1;
            position: relative;
            overflow: hidden;
            padding: 120px 0;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(37, 99, 235, 0.1), rgba(124, 58, 237, 0.05));
            opacity: 0.5;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.2;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 1.5rem;
            animation: float 3s ease-in-out infinite;
        }

        .lead-text {
            font-size: 1.25rem;
            color: var(--dark-color);
            max-width: 600px;
            margin: 0 auto 2rem;
            opacity: 0.9;
        }

        .cta-button {
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .cta-button-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            color: white !important;
        }

        .cta-button-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 2rem;
            margin: 1rem;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .feature-icon i {
            color: white;
            font-size: 1.5rem;
        }

        footer {
            background: var(--dark-color);
            color: var(--light-color);
            margin-top: auto;
            padding: 2rem 0;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .lead-text {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <span>MiCocktail</span> App
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="{{ url('/dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="{{ route('login') }}">
                                    Iniciar Sesión
                                </a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link text-dark" href="{{ route('register') }}">
                                        Registro
                                    </a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="hero-section">
        <div class="hero-bg"></div>
        <div class="container">
            <div class="hero-content text-center">
                <h1 class="hero-title mb-4">
                    Descubre el Mundo de los Cócteles
                </h1>
                <p class="lead-text">
                    Explora, crea y comparte tus recetas favoritas con una comunidad apasionada por la mixología moderna.
                </p>
                <div class="d-flex gap-3 justify-content-center">
                    @guest
                        <a href="{{ route('login') }}" class="cta-button cta-button-primary">
                            Comenzar Ahora
                        </a>
                        <a href="{{ route('register') }}" class="cta-button btn-outline-dark">
                            Registro Gratis
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section class="py-5">
        <div class="container">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <div class="col">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-bookmarks"></i>
                        </div>
                        <h3>Recetas Exclusivas</h3>
                        <p class="text-muted">Accede a cientos de recetas profesionales y técnicas de preparación.</p>
                    </div>
                </div>
                <div class="col">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-share"></i>
                        </div>
                        <h3>Comparte Tus Creaciones</h3>
                        <p class="text-muted">Publica y comparte tus propias recetas con la comunidad.</p>
                    </div>
                </div>
                <div class="col">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-star"></i>
                        </div>
                        <h3>Aprendizaje Continuo</h3>
                        <p class="text-muted">Cursos interactivos y tutoriales para todos los niveles.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer>
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} MiCocktail App. Todos los derechos reservados.</p>
        </div>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>