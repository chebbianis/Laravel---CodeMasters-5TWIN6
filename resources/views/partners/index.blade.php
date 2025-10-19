<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion des Partenaires - Waste To Product</title>
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

        .partner-types {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
        }

        .types-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .type-badge {
            padding: 1rem;
            border-radius: 10px;
            text-align: center;
            color: white;
            font-weight: 500;
        }

        .type-ong { background: #28a745; }
        .type-municipalite { background: #007bff; }
        .type-entreprise { background: #ffc107; color: #212529; }
        .type-association { background: #17a2b8; }
        .type-etablissement { background: #6f42c1; }

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
            <p>Gestion des Partenaires</p>
        </div>
        
        <ul class="nav-menu">
            <li><a href="{{ route('dashboard') }}"><span class="icon">🏠</span> Dashboard</a></li>
            <li><a href="{{ route('catalog.index') }}"><span class="icon">📦</span> Catalogue des Objets</a></li>
            <li><a href="{{ route('partners.index') }}" class="active"><span class="icon">🤝</span> Partenaires</a></li>
            <li><a href="{{ route('collection.index') }}"><span class="icon">📍</span> Points de Collecte</a></li>
            <li><a href="{{ route('events.index') }}"><span class="icon">🎪</span> Événements</a></li>
        </ul>
    </aside>

    <main class="main-content">
        <header class="header">
            <h1>Gestion des Partenaires</h1>
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}">Dashboard</a> / Partenaires
            </div>
        </header>

        <div class="content">
            <!-- Vue d'ensemble -->
            <div class="module-overview">
                <h2><span class="icon">🤝</span> Réseau des Organisations Collaboratrices</h2>
                <p>Gérez le réseau des organisations partenaires pour maintenir les coordonnées, suivre les collaborations et organiser des actions conjointes dans le cadre de l'économie circulaire.</p>

                <!-- Statistiques -->
                <div class="stats-row">
                    <div class="stat-box">
                        <div class="number">56</div>
                        <div class="label">Partenaires Total</div>
                    </div>
                    <div class="stat-box">
                        <div class="number">48</div>
                        <div class="label">Actifs</div>
                    </div>
                    <div class="stat-box">
                        <div class="number">23</div>
                        <div class="label">Collaborations</div>
                    </div>
                    <div class="stat-box">
                        <div class="number">12</div>
                        <div class="label">Nouveaux ce mois</div>
                    </div>
                </div>
            </div>

            <!-- Types de Partenaires -->
            <div class="partner-types">
                <h2>Types de Partenaires</h2>
                <div class="types-grid">
                    <div class="type-badge type-ong">
                        <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">🌱</div>
                        <div>ONG</div>
                    </div>
                    <div class="type-badge type-municipalite">
                        <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">🏛️</div>
                        <div>Municipalité</div>
                    </div>
                    <div class="type-badge type-entreprise">
                        <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">🏢</div>
                        <div>Entreprise</div>
                    </div>
                    <div class="type-badge type-association">
                        <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">👥</div>
                        <div>Association</div>
                    </div>
                    <div class="type-badge type-etablissement">
                        <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">🏫</div>
                        <div>Établissement Public</div>
                    </div>
                </div>
            </div>

            <!-- Fonctionnalités -->
            <div class="features-grid">
                <div class="feature-card">
                    <h3><span class="icon">📋</span> Liste des Partenaires</h3>
                    <p>Consultez, ajoutez et gérez tous vos partenaires. Maintenez leurs informations de contact à jour et suivez le statut de vos collaborations.</p>
                    <a href="{{ route('partners.list') }}" class="btn">Gérer les Partenaires</a>
                </div>

                <div class="feature-card">
                    <h3><span class="icon">🏷️</span> Types de Partenaires</h3>
                    <p>Organisez vos partenaires par type (ONG, municipalités, entreprises) pour faciliter la gestion et les communications ciblées.</p>
                    <a href="{{ route('partners.types') }}" class="btn">Gérer les Types</a>
                </div>


        </div>
    </main>
</body>
</html>
