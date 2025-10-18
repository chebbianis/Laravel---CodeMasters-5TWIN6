<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Waste To Product</title>
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

        .sidebar .logo p {
            font-size: 0.8rem;
            opacity: 0.8;
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

        .nav-menu a:hover {
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

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .badge-admin {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white;
        }

        .badge-user {
            background: linear-gradient(135deg, #4ecdc4, #44a08d);
            color: white;
        }

        .logout-btn {
            padding: 0.5rem 1rem;
            background: #e74c3c;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .logout-btn:hover {
            background: #c0392b;
        }

        .dashboard-content {
            padding: 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            text-align: center;
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card .icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .stat-card h3 {
            color: #333;
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }

        .stat-card .number {
            font-size: 2rem;
            font-weight: bold;
            color: #667eea;
        }

        .quick-actions {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .quick-actions h2 {
            margin-bottom: 1.5rem;
            color: #333;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .action-btn {
            display: flex;
            align-items: center;
            padding: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .action-btn .icon {
            margin-right: 1rem;
            font-size: 1.5rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="logo">
            <h2>🔄 Waste To Product</h2>
            <p>Tableau de bord</p>
        </div>
        
        <ul class="nav-menu">
            <li><a href="{{ route('dashboard') }}"><span class="icon">🏠</span> Dashboard</a></li>
            <li><a href="{{ route('catalog.index') }}"><span class="icon">📦</span> Catalogue des Objets</a></li>
            <li><a href="{{ route('partners.index') }}"><span class="icon">🤝</span> Partenaires</a></li>
            <li><a href="{{ route('collection.index') }}"><span class="icon">📍</span> Points de Collecte</a></li>
            <li><a href="{{ route('events.index') }}"><span class="icon">🎪</span> Événements</a></li>
        </ul>
    </aside>

    <main class="main-content">
        <header class="header">
            <h1>Tableau de Bord</h1>
            <div class="user-info">
                <span class="user-badge {{ Auth::user()->isAdmin() ? 'badge-admin' : 'badge-user' }}">
                    {{ Auth::user()->isAdmin() ? '👑 Admin' : '👤 Utilisateur' }}
                </span>
                <span>Bienvenue, {{ Auth::user()->first_name }}</span>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">Déconnexion</button>
                </form>
            </div>
        </header>

        <div class="dashboard-content">
            @if(session('success'))
                <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 10px; margin: 1rem 2rem; border-left: 4px solid #28a745;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 10px; margin: 1rem 2rem; border-left: 4px solid #dc3545;">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Statistiques -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="icon">📦</div>
                    <h3>Objets Valorisables</h3>
                    <div class="number">{{ \App\Models\Item::count() }}</div>
                </div>
                <div class="stat-card">
                    <div class="icon">🤝</div>
                    <h3>Partenaires Actifs</h3>
                    <div class="number">{{ \App\Models\Partner::count() }}</div>
                </div>
                <div class="stat-card">
                    <div class="icon">📍</div>
                    <h3>Points de Collecte</h3>
                    <div class="number">{{ \App\Models\CollectionPoint::count() }}</div>
                </div>
                <div class="stat-card">
                    <div class="icon">🎪</div>
                    <h3>Événements à venir</h3>
                    <div class="number">{{ \App\Models\Event::where('date', '>=', now())->count() }}</div>
                </div>
            </div>

            <!-- Actions Rapides -->
            <div class="quick-actions">
                <h2>Actions Rapides</h2>
                <div class="actions-grid">
                    <a href="{{ route('catalog.items') }}" class="action-btn">
                        <span class="icon">📦</span>
                        <span>Gérer les Objets</span>
                    </a>
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.users.index') }}" class="action-btn">
                            <span class="icon">👥</span>
                            <span>Gérer les Utilisateurs</span>
                        </a>
                        <a href="{{ route('partners.list') }}" class="action-btn">
                            <span class="icon">🤝</span>
                            <span>Gérer les Partenaires</span>
                        </a>
                        <a href="{{ route('partners.types') }}" class="action-btn">
                            <span class="icon">🏷️</span>
                            <span>Types de Partenaires</span>
                        </a>
                    @else
                        <a href="{{ route('partners.public') }}" class="action-btn">
                            <span class="icon">🤝</span>
                            <span>Voir les Partenaires</span>
                        </a>
                    @endif
                    <a href="{{ route('collection.points') }}" class="action-btn">
                        <span class="icon">📍</span>
                        <span>Points de Collecte</span>
                    </a>
                    <a href="{{ route('events.workshops') }}" class="action-btn">
                        <span class="icon">🎪</span>
                        <span>{{ Auth::user()->isAdmin() ? 'Créer un Événement' : 'Voir les Événements' }}</span>
                    </a>
                </div>
            </div>

            <!-- Informations du profil -->
            <div class="quick-actions" style="margin-top: 2rem;">
                <h2>Mon Profil</h2>
                <div style="background: white; padding: 1.5rem; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                    <p><strong>Nom complet:</strong> {{ Auth::user()->full_name }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Nom d'utilisateur:</strong> {{ Auth::user()->username }}</p>
                    <p><strong>Rôle:</strong> {{ Auth::user()->isAdmin() ? 'Administrateur' : 'Utilisateur' }}</p>
                    <p><strong>Dernière connexion:</strong> {{ Auth::user()->last_login ? Auth::user()->last_login->diffForHumans() : 'Première connexion' }}</p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
