<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Événements - Waste To Product</title>
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
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            overflow-y: auto;
        }
        
        .sidebar-header {
            text-align: center;
            padding: 0 1rem 2rem;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        
        .sidebar-header h2 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
        
        .sidebar-nav {
            padding: 2rem 0;
        }
        
        .sidebar-nav a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 1rem 2rem;
            transition: background 0.3s;
            border-left: 3px solid transparent;
        }
        
        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background: rgba(255,255,255,0.1);
            border-left-color: white;
        }
        
        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 2rem;
        }
        
        .header {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .header h1 {
            color: #333;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        
        .header p {
            color: #666;
            font-size: 1.1rem;
        }
        
        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .stat-card .icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .stat-card .number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 0.5rem;
        }
        
        .stat-card .label {
            color: #666;
            font-size: 1rem;
        }
        
        /* Management Cards */
        .management-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
        }
        
        .management-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        
        .management-card:hover {
            transform: translateY(-5px);
        }
        
        .management-card .card-header {
            background: linear-gradient(135deg, #9C27B0 0%, #E91E63 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .management-card .card-header .icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        
        .management-card .card-header h3 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }
        
        .management-card .card-body {
            padding: 2rem;
        }
        
        .management-card .card-body p {
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #9C27B0 0%, #E91E63 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: transform 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background: #f8f9fa;
            color: #495057;
            border: 2px solid #dee2e6;
        }
        
        .btn-secondary:hover {
            background: #e9ecef;
        }
        
        /* Quick Actions */
        .quick-actions {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .quick-actions h2 {
            color: #333;
            margin-bottom: 1.5rem;
        }
        
        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .management-grid {
                grid-template-columns: 1fr;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>🎯 Événements</h2>
            <p>Gestion des Ateliers</p>
        </div>
        
        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}">← Tableau de Bord</a>
            <a href="{{ route('events.index') }}" class="active">Vue d'ensemble</a>
            <a href="{{ route('events.workshops') }}">Ateliers & Conférences</a>
            <a href="{{ route('events.participations') }}">Inscriptions</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <h1>Gestion des Événements et Ateliers</h1>
            <p>Organisation d'ateliers de réparation, conférences sur l'économie circulaire et événements de sensibilisation</p>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <h2>Actions Rapides</h2>
            <div class="action-buttons">
                <button class="btn">+ Nouvel Événement</button>
                <button class="btn btn-secondary">📊 Rapport Mensuel</button>
                <button class="btn btn-secondary">👥 Gérer les Participants</button>
                <button class="btn btn-secondary">📧 Envoi Newsletter</button>
            </div>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="icon">🎪</div>
                <div class="number">23</div>
                <div class="label">Événements Organisés</div>
            </div>
            <div class="stat-card">
                <div class="icon">👥</div>
                <div class="number">456</div>
                <div class="label">Participants Totaux</div>
            </div>
            <div class="stat-card">
                <div class="icon">🔧</div>
                <div class="number">15</div>
                <div class="label">Ateliers de Réparation</div>
            </div>
            <div class="stat-card">
                <div class="icon">🎓</div>
                <div class="number">8</div>
                <div class="label">Conférences</div>
            </div>
        </div>

        <!-- Management Cards -->
        <div class="management-grid">
            <!-- Ateliers et Conférences -->
            <div class="management-card">
                <div class="card-header">
                    <div class="icon">🛠️</div>
                    <h3>Ateliers & Conférences</h3>
                </div>
                <div class="card-body">
                    <p>Organisez et gérez vos ateliers de réparation, conférences sur l'économie circulaire et événements de sensibilisation. Planifiez les dates, gérez les intervenants et les ressources nécessaires.</p>
                    <a href="{{ route('events.workshops') }}" class="btn">Gérer les Ateliers</a>
                </div>
            </div>

            <!-- Inscriptions et Participations -->
            <div class="management-card">
                <div class="card-header">
                    <div class="icon">📋</div>
                    <h3>Inscriptions & Participations</h3>
                </div>
                <div class="card-body">
                    <p>Suivez les inscriptions aux événements, gérez les listes de participants et analyser la participation. Envoyez des rappels et gérez les confirmations de présence.</p>
                    <a href="{{ route('events.participations') }}" class="btn">Voir les Inscriptions</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
