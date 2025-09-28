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
    <header>
        <nav class="container">
            <div class="logo">🔄 Waste To Product</div>
            <div class="nav-links">
                <a href="{{ route('home') }}">Accueil</a>
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('about') }}">À propos</a>
                <a href="#contact">Contact</a>
            </div>
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="container">
                <h1>Waste To Product</h1>
                <p>Une initiative qui valorise les déchets en leur donnant une seconde vie à travers le réemploi, la réparation ou la transformation. Rejoignez l'économie circulaire !</p>
            </div>
        </section>

        <section class="auth-section">
            <!-- Formulaire de Connexion -->
            <div class="auth-form">
                <h2>🔑 Connexion</h2>
                <form action="{{ route('login') }}" method="POST">
                    <div class="form-group">
                        <label for="login-email">Email</label>
                        <input type="email" id="login-email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="login-password">Mot de passe</label>
                        <input type="password" id="login-password" name="password" required>
                    </div>
                    <button type="submit" class="btn">Se connecter</button>
                </form>
            </div>

            <!-- Formulaire d'Inscription -->
            <div class="auth-form">
                <h2>✨ Inscription</h2>
                <form action="{{ route('register') }}" method="POST">
                    <div class="form-group">
                        <label for="register-username">Nom d'utilisateur</label>
                        <input type="text" id="register-username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="register-email">Email</label>
                        <input type="email" id="register-email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="register-first_name">Prénom</label>
                        <input type="text" id="register-first_name" name="first_name" required>
                    </div>
                    <div class="form-group">
                        <label for="register-last_name">Nom</label>
                        <input type="text" id="register-last_name" name="last_name" required>
                    </div>
                    <div class="form-group">
                        <label for="register-password">Mot de passe</label>
                        <input type="password" id="register-password" name="password" required>
                    </div>
                    <button type="submit" class="btn">S'inscrire</button>
                </form>
            </div>
        </section>

        <section class="features">
            <div class="container">
                <h2 style="text-align: center; color: white; margin-bottom: 2rem;">Nos Fonctionnalités</h2>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">📦</div>
                        <h3>Catalogue des Objets</h3>
                        <p>Inventaire central des objets valorisables avec catégorisation et suivi du statut</p>
                    </div>
                    <div class="feature-card" onclick="window.location.href='{{ route('partners.public') }}'" style="cursor: pointer;">
                        <div class="feature-icon">🤝</div>
                        <h3>Gestion des Partenaires</h3>
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
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 Waste To Product. Tous droits réservés. 🌱 Pour une économie circulaire durable.</p>
        </div>
    </footer>
</body>
</html>
