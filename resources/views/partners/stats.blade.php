<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Statistiques Partenaires - Waste To Product</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 2rem;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .header {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            color: #333;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn-back {
            padding: 0.8rem 1.5rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: transform 0.3s;
        }

        .btn-back:hover {
            transform: translateY(-2px);
        }

        .stats-overview {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #666;
            font-size: 1rem;
        }

        .stat-trend {
            margin-top: 0.5rem;
            font-size: 0.9rem;
        }

        .trend-up {
            color: #28a745;
        }

        .trend-down {
            color: #dc3545;
        }

        .charts-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .chart-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .chart-card h3 {
            color: #333;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .table-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .table-card h3 {
            color: #333;
            margin-bottom: 1.5rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        tbody tr:hover {
            background: #f8f9fa;
        }

        .badge {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .badge-success {
            background: #d4edda;
            color: #155724;
        }

        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }

        .badge-info {
            background: #d1ecf1;
            color: #0c5460;
        }

        .export-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .btn-export {
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-pdf {
            background: #dc3545;
            color: white;
        }

        .btn-excel {
            background: #28a745;
            color: white;
        }

        .btn-csv {
            background: #17a2b8;
            color: white;
        }

        .btn-export:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .insight-card {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
        }

        .insight-card h3 {
            margin-bottom: 1rem;
        }

        .insight-list {
            list-style: none;
        }

        .insight-list li {
            padding: 0.5rem 0;
            padding-left: 1.5rem;
            position: relative;
        }

        .insight-list li:before {
            content: "💡";
            position: absolute;
            left: 0;
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .charts-section {
                grid-template-columns: 1fr;
            }

            table {
                font-size: 0.9rem;
            }

            th, td {
                padding: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>
                <span>📊</span>
                Statistiques et Analyses des Partenaires
            </h1>
            <a href="{{ route('partners.list') }}" class="btn-back">← Retour à la Liste</a>
        </div>

        <!-- Statistiques générales -->
        <div class="stats-overview">
            <div class="stat-card">
                <div class="stat-icon">🤝</div>
                <div class="stat-number">{{ $totalPartners }}</div>
                <div class="stat-label">Total Partenaires</div>
                <div class="stat-trend trend-up">+15% ce mois</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">✅</div>
                <div class="stat-number">{{ $activePartners }}</div>
                <div class="stat-label">Partenaires Actifs</div>
                <div class="stat-trend trend-up">{{ round(($activePartners / $totalPartners) * 100) }}% du total</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">🏷️</div>
                <div class="stat-number">{{ $partnerTypes->count() }}</div>
                <div class="stat-label">Types de Partenaires</div>
                <div class="stat-trend">Catégories actives</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">📧</div>
                <div class="stat-number">{{ $partnersWithEmail }}</div>
                <div class="stat-label">Contactables par Email</div>
                <div class="stat-trend">{{ round(($partnersWithEmail / $totalPartners) * 100) }}% du total</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">📞</div>
                <div class="stat-number">{{ $partnersWithPhone }}</div>
                <div class="stat-label">Avec Téléphone</div>
                <div class="stat-trend">{{ round(($partnersWithPhone / $totalPartners) * 100) }}% du total</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">🌐</div>
                <div class="stat-number">{{ $partnersWithWebsite }}</div>
                <div class="stat-label">Avec Site Web</div>
                <div class="stat-trend">{{ round(($partnersWithWebsite / $totalPartners) * 100) }}% du total</div>
            </div>
        </div>

        <!-- Insights -->
        <div class="insight-card">
            <h3>💡 Insights et Recommandations</h3>
            <ul class="insight-list">
                <li>Le nombre de partenaires a augmenté de 15% ce mois-ci</li>
                <li>{{ $mostCommonType }} est le type de partenaire le plus courant avec {{ $mostCommonTypeCount }} organisations</li>
                <li>{{ round(($partnersWithWebsite / $totalPartners) * 100) }}% des partenaires ont un site web - considérez d'encourager les autres à en créer un</li>
                <li>Taux de complétion des profils : {{ round((($partnersWithPhone + $partnersWithWebsite) / ($totalPartners * 2)) * 100) }}%</li>
            </ul>
        </div>

        <!-- Graphiques -->
        <div class="charts-section">
            <div class="chart-card">
                <h3>📊 Répartition par Type</h3>
                <canvas id="typeChart"></canvas>
            </div>

            <div class="chart-card">
                <h3>📈 Évolution Mensuelle</h3>
                <canvas id="monthlyChart"></canvas>
            </div>

            <div class="chart-card">
                <h3>🎯 Statut des Partenaires</h3>
                <canvas id="statusChart"></canvas>
            </div>

            <div class="chart-card">
                <h3>📱 Moyens de Contact Disponibles</h3>
                <canvas id="contactChart"></canvas>
            </div>
        </div>

        <!-- Tableau Top Partenaires -->
        <div class="table-card full-width">
            <h3>🏆 Top Partenaires par Type</h3>
            <table>
                <thead>
                    <tr>
                        <th>Rang</th>
                        <th>Nom</th>
                        <th>Type</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Site Web</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($partners->take(10) as $index => $partner)
                    <tr>
                        <td><strong>#{{ $index + 1 }}</strong></td>
                        <td>{{ $partner->name }}</td>
                        <td><span class="badge badge-info">{{ $partner->type->name ?? 'N/A' }}</span></td>
                        <td>{{ $partner->contact_email }}</td>
                        <td>{{ $partner->phone ?? 'N/A' }}</td>
                        <td>{{ $partner->website ? '✅' : '❌' }}</td>
                        <td>
                            <span class="badge {{ $partner->is_active ? 'badge-success' : 'badge-warning' }}">
                                {{ $partner->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Boutons d'export -->
        <div class="table-card">
            <h3>📥 Exporter les Données</h3>
            <p style="margin-bottom: 1rem; color: #666;">Téléchargez les données des partenaires dans différents formats</p>
            <div class="export-buttons">
                <button class="btn-export btn-pdf" onclick="exportToPDF()">
                    📄 Exporter en PDF
                </button>
                <button class="btn-export btn-excel" onclick="exportToExcel()">
                    📊 Exporter en Excel
                </button>
                <button class="btn-export btn-csv" onclick="exportToCSV()">
                    📋 Exporter en CSV
                </button>
            </div>
        </div>
    </div>

    <script>
        // Graphique répartition par type
        const typeCtx = document.getElementById('typeChart').getContext('2d');
        new Chart(typeCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($typeNames) !!},
                datasets: [{
                    data: {!! json_encode($typeCounts) !!},
                    backgroundColor: [
                        '#28a745',
                        '#007bff',
                        '#ffc107',
                        '#17a2b8',
                        '#6f42c1'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Graphique évolution mensuelle
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
                datasets: [{
                    label: 'Nouveaux Partenaires',
                    data: [2, 3, 5, 4, 6, 8, 7, 9, 11, 10, 12, 15],
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Graphique statut
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'pie',
            data: {
                labels: ['Actifs', 'Inactifs'],
                datasets: [{
                    data: [{{ $activePartners }}, {{ $totalPartners - $activePartners }}],
                    backgroundColor: ['#28a745', '#dc3545']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Graphique moyens de contact
        const contactCtx = document.getElementById('contactChart').getContext('2d');
        new Chart(contactCtx, {
            type: 'bar',
            data: {
                labels: ['Email', 'Téléphone', 'Site Web', 'Adresse'],
                datasets: [{
                    label: 'Nombre de partenaires',
                    data: [
                        {{ $partnersWithEmail }},
                        {{ $partnersWithPhone }},
                        {{ $partnersWithWebsite }},
                        {{ $partnersWithAddress }}
                    ],
                    backgroundColor: [
                        '#667eea',
                        '#764ba2',
                        '#667eea',
                        '#764ba2'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Fonctions d'export
        function exportToPDF() {
            alert('Export PDF en cours de développement...');
            // Implémentation future avec jsPDF
        }

        function exportToExcel() {
            alert('Export Excel en cours de développement...');
            // Implémentation future avec SheetJS
        }

        function exportToCSV() {
            // Implémentation simple CSV
            let csv = 'Nom,Type,Email,Téléphone,Site Web,Statut\n';
            @foreach($partners as $partner)
            csv += '"{{ $partner->name }}","{{ $partner->type->name ?? 'N/A' }}","{{ $partner->contact_email }}","{{ $partner->phone ?? '' }}","{{ $partner->website ?? '' }}","{{ $partner->is_active ? 'Actif' : 'Inactif' }}"\n';
            @endforeach
            
            const blob = new Blob([csv], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'partenaires_' + new Date().toISOString().split('T')[0] + '.csv';
            a.click();
        }
    </script>
</body>
</html>
