<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Catalogue des Objets Valorables - Waste To Product</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
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
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .feature-card:hover {
            border-color: #667eea;
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.2);
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
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .feature-card .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .chart-card {
            animation: fadeInScale 0.6s ease-out;
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
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
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        .stat-box:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .stat-box .number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            animation: countUp 1s ease-out;
        }

        @keyframes countUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-box .label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .charts-section {
            margin-top: 2rem;
        }

        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .chart-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .chart-card h3 {
            color: #333;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .chart-card .icon {
            font-size: 1.5rem;
        }

        .chart-container {
            position: relative;
            height: 300px;
        }

        .chart-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        .legend-color {
            width: 16px;
            height: 16px;
            border-radius: 4px;
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

                <!-- Statistiques -->
                <div class="stats-row">
                    <div class="stat-box">
                        <div class="number">{{ number_format($totalItems) }}</div>
                        <div class="label">Objets Total</div>
                    </div>
                    <div class="stat-box">
                        <div class="number">{{ number_format($availableItems) }}</div>
                        <div class="label">Disponibles</div>
                    </div>
                    <div class="stat-box">
                        <div class="number">{{ number_format($inRepairItems) }}</div>
                        <div class="label">À Réparer</div>
                    </div>
                    <div class="stat-box">
                        <div class="number">{{ number_format($transformedItems) }}</div>
                        <div class="label">Transformés</div>
                    </div>
                </div>
            </div>

            <!-- Graphiques Statistiques -->
            <div class="charts-section">
                <div class="charts-grid">
                    <!-- Graphique de distribution par statut -->
                    <div class="chart-card">
                        <h3>
                            <span>📊 Distribution par Statut</span>
                            <span class="icon">🔄</span>
                        </h3>
                        <div class="chart-container">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>

                    <!-- Graphique de distribution par condition -->
                    <div class="chart-card">
                        <h3>
                            <span>🔧 État des Objets</span>
                            <span class="icon">⚙️</span>
                        </h3>
                        <div class="chart-container">
                            <canvas id="conditionChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Graphique de distribution par catégorie (pleine largeur) -->
                <div class="chart-card">
                    <h3>
                        <span>🏷️ Répartition par Catégorie</span>
                        <span class="icon">📈</span>
                    </h3>
                    <div class="chart-container" style="height: 400px;">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>

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

            </div>
        </div>
    </main>

    <script>
        // Configuration des couleurs
        const colors = {
            purple: '#667eea',
            pink: '#764ba2',
            blue: '#3b82f6',
            green: '#10b981',
            yellow: '#f59e0b',
            red: '#ef4444',
            indigo: '#6366f1',
            teal: '#14b8a6',
            orange: '#f97316'
        };

        // Graphique de distribution par statut (Doughnut)
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        const statusChart = new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Disponible', 'Transformé', 'Recyclé'],
                datasets: [{
                    data: [
                        {{ $statusData['disponible'] }},
                        {{ $statusData['transformé'] }},
                        {{ $statusData['recyclé'] }}
                    ],
                    backgroundColor: [
                        colors.green,
                        colors.blue,
                        colors.purple
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        // Graphique de condition (Pie)
        const conditionCtx = document.getElementById('conditionChart').getContext('2d');
        const conditionChart = new Chart(conditionCtx, {
            type: 'pie',
            data: {
                labels: ['Bon état', 'État moyen', 'À réparer'],
                datasets: [{
                    data: [
                        {{ $conditionData['bon'] }},
                        {{ $conditionData['moyen'] }},
                        {{ $conditionData['à réparer'] }}
                    ],
                    backgroundColor: [
                        colors.green,
                        colors.yellow,
                        colors.red
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        // Graphique de catégories (Bar)
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        const categoryChart = new Chart(categoryCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($categoryData)) !!},
                datasets: [{
                    label: 'Nombre d\'objets',
                    data: {!! json_encode(array_values($categoryData)) !!},
                    backgroundColor: [
                        colors.purple,
                        colors.blue,
                        colors.green,
                        colors.yellow,
                        colors.red,
                        colors.indigo,
                        colors.teal,
                        colors.orange,
                        colors.pink
                    ],
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.parsed.y} objet(s)`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        },
                        grid: {
                            display: true,
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Animation au chargement
        window.addEventListener('load', function() {
            const statBoxes = document.querySelectorAll('.stat-box');
            statBoxes.forEach((box, index) => {
                setTimeout(() => {
                    box.style.animation = 'fadeInUp 0.6s ease-out';
                }, index * 100);
            });
        });
    </script>

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</body>
</html>
