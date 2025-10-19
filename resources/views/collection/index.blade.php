<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Points de Collecte - Waste To Product</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            line-height: 1.6;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            overflow-y: auto;
        }

        .sidebar .logo {
            text-align: center;
            padding: 0 1rem;
            margin-bottom: 2rem;
        }

        .nav-menu {
            list-style: none;
        }

        .nav-menu a {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            padding: 1rem 1.5rem;
            transition: all 0.3s;
        }

        .nav-menu a:hover,
        .nav-menu a.active {
            background: rgba(255, 255, 255, 0.1);
        }

        .nav-menu .icon {
            margin-right: 1rem;
        }

        .main-content {
            margin-left: 250px;
            min-height: 100vh;
        }

        .header {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .breadcrumb a {
            color: #667eea;
            text-decoration: none;
        }

        .content {
            padding: 2rem;
        }

        .module-overview {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
        }

        .module-overview h2 {
            color: #333;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .module-overview .icon {
            margin-right: 1rem;
            font-size: 2rem;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            text-align: center;
        }

        .stat-box .number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: #f8fafc;
            padding: 2rem;
            border-radius: 15px;
            border: 2px solid #e2e8f0;
            transition: all 0.3s;
        }

        .feature-card:hover {
            border-color: #667eea;
            transform: translateY(-3px);
        }

        .feature-card h3 {
            color: #333;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .feature-card .icon {
            margin-right: 0.5rem;
            font-size: 1.5rem;
        }

        .feature-card p {
            color: #666;
            margin-bottom: 1.5rem;
        }

        .btn {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .map-placeholder {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            padding: 2rem;
            margin-bottom: 2rem;
            text-align: center;
        }

        .map-area {
            height: 300px;
            background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            font-size: 3rem;
            color: #667eea;
            margin-bottom: 1rem;
        }

        .status-indicators {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .status-item {
            display: flex;
            align-items: center;
            padding: 0.8rem;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .status-full {
            background: #fff3cd;
            color: #856404;
        }

        .status-closed {
            background: #f8d7da;
            color: #721c24;
        }

        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 0.5rem;
        }

        .dot-active { background: #28a745; }
        .dot-full { background: #ffc107; }
        .dot-closed { background: #dc3545; }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="logo">
            <h2>🔄 Waste To Product</h2>
            <p>Points de Collecte</p>
        </div>

        <ul class="nav-menu">
            <li><a href="{{ route('dashboard') }}"><span class="icon">🏠</span> Dashboard</a></li>
            <li><a href="{{ route('catalog.index') }}"><span class="icon">📦</span> Catalogue des Objets</a></li>
            <li><a href="{{ route('partners.index') }}"><span class="icon">🤝</span> Partenaires</a></li>
            <li><a href="{{ route('collection.index') }}" class="active"><span class="icon">📍</span> Points de Collecte</a></li>
            <li><a href="{{ route('events.index') }}"><span class="icon">🎪</span> Événements</a></li>
        </ul>
    </aside>

    <main class="main-content">
        <header class="header">
            <h1>Gestion des Points de Collecte</h1>
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}">Dashboard</a> / Points de Collecte
            </div>
        </header>

        <div class="content">
            <!-- Vue d'ensemble -->
            <div class="module-overview">
                <h2><span class="icon">📍</span> Géolocalisation et Gestion des Points de Collecte</h2>
                <p>Gérez la localisation des points de collecte et suivez en temps réel les dépôts pour optimiser la logistique et éviter la saturation. Visualisez votre réseau de collecte sur une carte interactive.</p>

                <!-- Statistiques -->
                <div class="stats-row">
                    <div class="stat-box">
                        <div class="number">89</div>
                        <div class="label">Points Total</div>
                    </div>
                    <div class="stat-box">
                        <div class="number">67</div>
                        <div class="label">Actifs</div>
                    </div>
                    <div class="stat-box">
                        <div class="number">15</div>
                        <div class="label">Saturés</div>
                    </div>
                    <div class="stat-box">
                        <div class="number">1,234</div>
                        <div class="label">Dépôts ce mois</div>
                    </div>
                </div>
            </div>

            <!-- Carte des points de collecte -->
            <div class="map-placeholder">
                <h2>Carte Interactive des Points de Collecte</h2>
                <div class="map-area">
                    <div>🗺️</div>
                    <div style="font-size: 1rem; margin-top: 1rem; color: #666;">
                        Carte interactive avec géolocalisation des points de collecte
                    </div>
                </div>

                <div class="status-indicators">
                    <div class="status-item status-active">
                        <div class="status-dot dot-active"></div>
                        <span>67 Points Actifs</span>
                    </div>
                    <div class="status-item status-full">
                        <div class="status-dot dot-full"></div>
                        <span>15 Points Saturés</span>
                    </div>
                    <div class="status-item status-closed">
                        <div class="status-dot dot-closed"></div>
                        <span>7 Points Fermés</span>
                    </div>
                </div>
            </div>

            <!-- Fonctionnalités -->
            <div class="features-grid">
                <div class="feature-card">
                    <h3><span class="icon">📍</span> Gestion des Points</h3>
                    <p>Créez, modifiez et gérez vos points de collecte. Définissez la localisation, la capacité et les horaires d'ouverture de chaque point.</p>
                    <a href="{{ route('collection.points') }}" class="btn">Gérer les Points</a>
                </div>

                <div class="feature-card">
                    <h3><span class="icon">📋</span> Suivi des Dépôts</h3>
                    <p>Enregistrez et suivez tous les dépôts effectués dans chaque point de collecte. Analysez les flux et optimisez la collecte.</p>
                    <a href="{{ route('collection.deposits') }}" class="btn">Gérer les Dépôts</a>
                </div>

                <div class="feature-card">
                    <h3><span class="icon">📊</span> Analyses et Rapports</h3>
                    <p>Consultez les statistiques de collecte, identifiez les tendances et générez des rapports sur l'efficacité de votre réseau.</p>
                    <a href="#" class="btn">Voir les Analyses</a>
                </div>

                <div class="feature-card">
                    <h3><span class="icon">🚨</span> Alertes de Saturation</h3>
                    <p>Recevez des notifications automatiques lorsqu'un point de collecte approche de sa capacité maximale.</p>
                    <a href="#" class="btn">Configurer les Alertes</a>
                </div>

                <div class="feature-card">
                    <h3><span class="icon">🚚</span> Planification Logistique</h3>
                    <p>Optimisez les tournées de collecte en fonction du taux de remplissage et de la localisation des points.</p>
                    <a href="#" class="btn">Planifier les Tournées</a>
                </div>

                <div class="feature-card">
                    <h3><span class="icon">👥</span> Gestion des Responsables</h3>
                    <p>Assignez des responsables à chaque point de collecte et gérez leurs accès et permissions.</p>
                    <a href="#" class="btn">Gérer les Responsables</a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
