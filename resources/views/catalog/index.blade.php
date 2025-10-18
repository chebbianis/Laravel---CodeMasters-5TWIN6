<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Catalogue des Objets Valorables - Waste To Product</title>
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

        .sidebar .logo h2 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .nav-menu {
            list-style: none;
        }

        .nav-menu li {
            margin-bottom: 0.5rem;
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
            transform: translateX(5px);
        }

        .nav-menu .icon {
            margin-right: 1rem;
            font-size: 1.2rem;
        }

        .main-content {
            margin-left: 250px;
            min-height: 100vh;
        }

        .header {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            color: #333;
            font-size: 1.8rem;
        }

        .breadcrumb {
            color: #666;
            font-size: 0.9rem;
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

        .module-overview p {
            color: #666;
            margin-bottom: 2rem;
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

        .feature-card .btn {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .feature-card .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
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

        .stat-box .label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="logo">
            <h2>🔄 Waste To Product</h2>
            <p>Catalogue des Objets</p>
        </div>
        
        <ul class="nav-menu">
            <li><a href="{{ route('dashboard') }}"><span class="icon">🏠</span> Dashboard</a></li>
            <li><a href="{{ route('catalog.index') }}" class="active"><span class="icon">📦</span> Catalogue des Objets</a></li>
            <li><a href="{{ route('partners.index') }}"><span class="icon">🤝</span> Partenaires</a></li>
            <li><a href="{{ route('collection.index') }}"><span class="icon">📍</span> Points de Collecte</a></li>
            <li><a href="{{ route('events.index') }}"><span class="icon">🎪</span> Événements</a></li>
        </ul>
    </aside>

    <main class="main-content">
        <header class="header">
            <div>
                <h1>Catalogue des Objets Valorables</h1>
                <div class="breadcrumb">
                    <a href="{{ route('dashboard') }}">Dashboard</a> / Catalogue des Objets
                </div>
            </div>
        </header>

        <div class="content">
            <!-- Vue d'ensemble du module -->
            <div class="module-overview">
                <h2><span class="icon">📦</span> Inventaire Central des Objets Valorisables</h2>
                <p>Gérez et suivez tous les objets pouvant être valorisés à travers le réemploi, la réparation ou la transformation. Ce module permet de catégoriser les objets et de suivre leur statut pour optimiser leur réutilisation dans l'économie circulaire.</p>

                

            <!-- Fonctionnalités -->
            <div class="features-grid">
                <div class="feature-card">
                    <h3><span class="icon">📋</span> Gestion des Objets</h3>
                    <p>Ajoutez, modifiez et supprimez des objets valorisables. Gérez leurs descriptions, états, images et suivez leur parcours de valorisation.</p>
                    <a href="{{ route('catalog.items') }}" class="btn">Gérer les Objets</a>
                </div>

                <div class="feature-card">
                    <h3><span class="icon">🏷️</span> Gestion des Catégories</h3>
                    <p>Organisez les objets par catégories (électronique, textile, mobilier, etc.) pour faciliter la recherche et la gestion de l'inventaire.</p>
                    <a href="{{ route('catalog.categories') }}" class="btn">Gérer les Catégories</a>
                </div>

                <div class="feature-card">
                    <h3><span class="icon">📊</span> Rapports et Analyses</h3>
                    <p>Consultez les statistiques de valorisation, analysez les tendances et générez des rapports sur l'impact environnemental.</p>
                    <a href="#" class="btn">Voir les Rapports</a>
                </div>

                <div class="feature-card">
                    <h3><span class="icon">🔍</span> Recherche Avancée</h3>
                    <p>Recherchez rapidement des objets par catégorie, état, date d'ajout ou mots-clés pour optimiser la gestion de l'inventaire.</p>
                    <a href="#" class="btn">Rechercher</a>
                </div>
            </div>
            
        </div>
    </main>
</body>
</html>
