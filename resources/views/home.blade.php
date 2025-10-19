<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Waste To Product - Valorisation des Déchets</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        header {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: white;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .nav-links a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .btn-login, .btn-register {
            padding: 0.6rem 1.2rem;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-login {
            color: #667eea;
        }

        .btn-login:hover {
            background: #f0f0f0;
            transform: translateY(-2px);
        }

        .btn-register {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid white;
        }

        .btn-register:hover {
            background: white;
            color: #667eea;
            transform: translateY(-2px);
        }

        .hero {
            padding: 120px 0 80px;
            text-align: center;
            color: white;
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .hero p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .cta-btn {
            padding: 1rem 2rem;
            font-size: 1.1rem;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .cta-primary {
            background: white;
            color: #667eea;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .cta-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }

        .cta-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid white;
        }

        .cta-secondary:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-3px);
        }

        .auth-section {
            background: white;
            margin: 2rem auto;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            max-width: 800px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .auth-form {
            padding: 1rem;
        }

        .auth-form h2 {
            margin-bottom: 1.5rem;
            color: #333;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #555;
        }

        .form-group input {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
        }

        .btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .features {
            padding: 4rem 0;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .feature-card h3 {
            margin-bottom: 1rem;
            color: #333;
        }

        .feature-card p {
            color: #666;
        }

        footer {
            background: rgba(0, 0, 0, 0.8);
            color: white;
            text-align: center;
            padding: 2rem 0;
        }

        .alert {
            position: fixed;
            top: 80px;
            right: 20px;
            padding: 1rem 1.5rem;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
            z-index: 999;
            animation: slideIn 0.5s ease;
        }

        .alert-success {
            background: white;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .auth-section {
                grid-template-columns: 1fr;
                margin: 1rem;
            }
            
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .nav-links {
                display: none;
            }
        }
    </style>
</head>
<body>
    @if(session('success'))
        <div class="alert alert-success">
            ✅ {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                document.querySelector('.alert').style.display = 'none';
            }, 5000);
        </script>
    @endif

    <header>
        <nav class="container">
            <div class="logo">🔄 Waste To Product</div>
            <div class="nav-links">
                <a href="{{ route('home') }}">Accueil</a>
                <a href="{{ route('catalog.public') }}">Catalogue</a>
                <a href="{{ route('partners.public') }}">Partenaires</a>
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    @endif
                    <span style="color: white; padding: 0.5rem 1rem;">
                        👤 {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                    </span>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline; margin: 0;">
                        @csrf
                        <button type="submit" style="background: rgba(255, 255, 255, 0.2); color: white; border: 2px solid white; padding: 0.5rem 1rem; border-radius: 25px; cursor: pointer; font-weight: 600; transition: all 0.3s;">
                            🚪 Déconnexion
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-login">Connexion</a>
                    <a href="{{ route('register') }}" class="btn-register">Inscription</a>
                @endauth
            </div>
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="container">
                <h1>Waste To Product</h1>
                <p>Une initiative qui valorise les déchets en leur donnant une seconde vie à travers le réemploi, la réparation ou la transformation. Rejoignez l'économie circulaire !</p>
                @auth
                    <div style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); padding: 1.5rem; border-radius: 15px; margin-top: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">
                        <p style="color: white; font-size: 1.3rem; margin-bottom: 1rem;">
                            ✨ Bienvenue, <strong>{{ Auth::user()->first_name }}</strong> !
                        </p>
                        <p style="color: rgba(255, 255, 255, 0.9); font-size: 1rem;">
                            Rôle: <strong>{{ Auth::user()->isAdmin() ? '👑 Administrateur' : '👤 Utilisateur' }}</strong>
                        </p>
                    </div>
                @else
                    <div class="cta-buttons">
                        <a href="{{ route('login') }}" class="cta-btn cta-primary">
                            🔐 Se Connecter
                        </a>
                        <a href="{{ route('register') }}" class="cta-btn cta-secondary">
                            ✨ Créer un Compte
                        </a>
                    </div>
                @endauth
            </div>
        </section>


        <section class="features">
            <div class="container">
                <h2 style="text-align: center; color: white; margin-bottom: 2rem;">Nos Fonctionnalités</h2>
                <div class="features-grid">
                    @auth
                        <div class="feature-card" onclick="window.location.href='{{ route('catalog.public') }}'" style="cursor: pointer;">
                            <div class="feature-icon">📦</div>
                            <h3>Catalogue des Objets</h3>
                            <p>Inventaire central des objets valorisables avec catégorisation et suivi du statut</p>
                        </div>
                        <div class="feature-card" onclick="window.location.href='{{ route('partners.public') }}'" style="cursor: pointer;">
                            <div class="feature-icon">🤝</div>
                            <h3>Réseau de Partenaires</h3>
                            <p>Réseau d'organisations collaboratrices pour des actions conjointes</p>
                        </div>
                        <div class="feature-card" onclick="window.location.href='{{ route('collection.points') }}'" style="cursor: pointer;">
                            <div class="feature-icon">📍</div>
                            <h3>Points de Collecte</h3>
                            <p>Géolocalisation et gestion des points de collecte avec suivi en temps réel</p>
                        </div>
                        <div class="feature-card" onclick="window.location.href='{{ route('events.workshops') }}'" style="cursor: pointer;">
                            <div class="feature-icon">🎪</div>
                            <h3>Événements & Ateliers</h3>
                            <p>Organisation d'ateliers de réparation et événements de sensibilisation</p>
                        </div>
                        @if(Auth::user()->isAdmin())
                            <div class="feature-card" onclick="window.location.href='{{ route('admin.users.index') }}'" style="cursor: pointer; border: 3px solid #ff6b6b;">
                                <div class="feature-icon">👥</div>
                                <h3>Gérer les Utilisateurs</h3>
                                <p>Administration des comptes utilisateurs et des rôles</p>
                            </div>
                            <div class="feature-card" onclick="window.location.href='{{ route('partners.types') }}'" style="cursor: pointer; border: 3px solid #ff6b6b;">
                                <div class="feature-icon">🏷️</div>
                                <h3>Types de Partenaires</h3>
                                <p>Gestion des catégories de partenaires</p>
                            </div>
                        @endif
                    @else
                        <div class="feature-card">
                            <div class="feature-icon">📦</div>
                            <h3>Catalogue des Objets</h3>
                            <p>Inventaire central des objets valorisables avec catégorisation et suivi du statut</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon">🤝</div>
                            <h3>Réseau de Partenaires</h3>
                            <p>Réseau d'organisations collaboratrices pour des actions conjointes</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon">📍</div>
                            <h3>Points de Collecte</h3>
                            <p>Géolocalisation et gestion des points de collecte avec suivi en temps réel</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon">🎪</div>
                            <h3>Événements & Ateliers</h3>
                            <p>Organisation d'ateliers de réparation et événements de sensibilisation</p>
                        </div>
                    @endauth

        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 Waste To Product. Tous droits réservés. 🌱 Pour une économie circulaire durable.</p>
        </div>
    </footer>
</body>
</html>
