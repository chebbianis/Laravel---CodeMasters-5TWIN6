<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Inscriptions - Waste To Product</title>
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
        
        .page-header {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .page-header h1 {
            color: #333;
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
        }
        
        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .stat-card .number {
            font-size: 2rem;
            font-weight: bold;
            color: #9C27B0;
            margin-bottom: 0.5rem;
        }
        
        .stat-card .label {
            color: #666;
            font-size: 0.9rem;
        }
        
        /* Event Tabs */
        .event-tabs {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 2rem;
        }
        
        .tabs-header {
            display: flex;
            background: #f8f9fa;
            border-bottom: 2px solid #e9ecef;
        }
        
        .tab-button {
            flex: 1;
            padding: 1rem 2rem;
            background: none;
            border: none;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
            border-bottom: 3px solid transparent;
        }
        
        .tab-button.active {
            background: white;
            border-bottom-color: #9C27B0;
            color: #9C27B0;
        }
        
        .tab-content {
            padding: 2rem;
        }
        
        /* Participants Table */
        .participants-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        
        .participants-table th,
        .participants-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }
        
        .participants-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
        }
        
        .participants-table tr:hover {
            background: #f8f9fa;
        }
        
        /* Status badges */
        .status-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .status-confirmed {
            background: #d4edda;
            color: #155724;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }
        
        /* Action buttons */
        .action-btn {
            padding: 0.4rem 0.8rem;
            margin: 0 0.2rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.8rem;
            transition: all 0.3s;
        }
        
        .btn-confirm {
            background: #28a745;
            color: white;
        }
        
        .btn-cancel {
            background: #dc3545;
            color: white;
        }
        
        .btn-email {
            background: #17a2b8;
            color: white;
        }
        
        .action-btn:hover {
            opacity: 0.8;
            transform: translateY(-1px);
        }
        
        /* Filters */
        .filters {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: end;
        }
        
        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .filter-group label {
            font-weight: 500;
            color: #333;
            font-size: 0.9rem;
        }
        
        .filter-group select,
        .filter-group input {
            padding: 8px 12px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
        }
        
        .btn {
            padding: 8px 16px;
            background: linear-gradient(135deg, #9C27B0 0%, #E91E63 100%);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            height: fit-content;
        }
        
        .btn:hover {
            opacity: 0.9;
        }
        
        /* Export section */
        .export-section {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .export-section h3 {
            color: #333;
            margin-bottom: 1rem;
        }
        
        .export-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        .btn-export {
            background: #28a745;
        }
        
        .btn-csv {
            background: #17a2b8;
        }
        
        .btn-pdf {
            background: #fd7e14;
        }
        
        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #666;
        }
        
        .empty-state .icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
            
            .tabs-header {
                flex-direction: column;
            }
            
            .participants-table {
                font-size: 0.8rem;
            }
            
            .filters {
                flex-direction: column;
            }
            
            .export-buttons {
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
            <a href="{{ route('events.index') }}">Vue d'ensemble</a>
            <a href="{{ route('events.workshops') }}">Ateliers & Conférences</a>
            <a href="{{ route('events.participations') }}" class="active">Inscriptions</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Gestion des Inscriptions</h1>
            <p>Suivez et gérez les participants à vos événements et ateliers</p>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="icon">👥</div>
                <div class="number">156</div>
                <div class="label">Total Inscrits</div>
            </div>
            <div class="stat-card">
                <div class="icon">✅</div>
                <div class="number">134</div>
                <div class="label">Confirmés</div>
            </div>
            <div class="stat-card">
                <div class="icon">⏳</div>
                <div class="number">18</div>
                <div class="label">En Attente</div>
            </div>
            <div class="stat-card">
                <div class="icon">❌</div>
                <div class="number">4</div>
                <div class="label">Annulés</div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filters">
            <div class="filter-group">
                <label>Événement</label>
                <select>
                    <option value="">Tous les événements</option>
                    <option value="repair-cafe">Repair Café - Électroménager</option>
                    <option value="conference">Conférence Économie Circulaire</option>
                    <option value="upcycling">Atelier Upcycling</option>
                </select>
            </div>
            <div class="filter-group">
                <label>Statut</label>
                <select>
                    <option value="">Tous les statuts</option>
                    <option value="confirmed">Confirmé</option>
                    <option value="pending">En attente</option>
                    <option value="cancelled">Annulé</option>
                </select>
            </div>
            <div class="filter-group">
                <label>Date d'inscription</label>
                <input type="date">
            </div>
            <button class="btn">Filtrer</button>
        </div>

        <!-- Export Section -->
        <div class="export-section">
            <h3>Exporter les données</h3>
            <div class="export-buttons">
                <button class="btn btn-export">📊 Export Excel</button>
                <button class="btn btn-csv">📄 Export CSV</button>
                <button class="btn btn-pdf">📋 Liste PDF</button>
                <button class="btn">📧 Envoyer Newsletter</button>
            </div>
        </div>

        <!-- Event Tabs -->
        <div class="event-tabs">
            <div class="tabs-header">
                <button class="tab-button active" onclick="showTab('repair-cafe')">Repair Café (15 participants)</button>
                <button class="tab-button" onclick="showTab('conference')">Conférence (45 participants)</button>
                <button class="tab-button" onclick="showTab('upcycling')">Atelier Upcycling (8 participants)</button>
            </div>
            
            <!-- Repair Café Participants -->
            <div id="repair-cafe" class="tab-content">
                <table class="participants-table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Inscription</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Marie Dubois</td>
                            <td>marie.dubois@email.com</td>
                            <td>06 12 34 56 78</td>
                            <td>12/01/2025</td>
                            <td><span class="status-badge status-confirmed">Confirmé</span></td>
                            <td>
                                <button class="action-btn btn-email" title="Envoyer email">📧</button>
                                <button class="action-btn btn-cancel" title="Annuler">❌</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Pierre Martin</td>
                            <td>pierre.martin@email.com</td>
                            <td>06 98 76 54 32</td>
                            <td>14/01/2025</td>
                            <td><span class="status-badge status-confirmed">Confirmé</span></td>
                            <td>
                                <button class="action-btn btn-email" title="Envoyer email">📧</button>
                                <button class="action-btn btn-cancel" title="Annuler">❌</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Sophie Leroy</td>
                            <td>sophie.leroy@email.com</td>
                            <td>06 11 22 33 44</td>
                            <td>16/01/2025</td>
                            <td><span class="status-badge status-pending">En attente</span></td>
                            <td>
                                <button class="action-btn btn-confirm" title="Confirmer">✅</button>
                                <button class="action-btn btn-email" title="Envoyer email">📧</button>
                                <button class="action-btn btn-cancel" title="Annuler">❌</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Jean Moreau</td>
                            <td>jean.moreau@email.com</td>
                            <td>06 55 44 33 22</td>
                            <td>18/01/2025</td>
                            <td><span class="status-badge status-confirmed">Confirmé</span></td>
                            <td>
                                <button class="action-btn btn-email" title="Envoyer email">📧</button>
                                <button class="action-btn btn-cancel" title="Annuler">❌</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Conference Participants -->
            <div id="conference" class="tab-content" style="display: none;">
                <table class="participants-table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Organisation</th>
                            <th>Inscription</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Dr. Anne Dupont</td>
                            <td>anne.dupont@univ.fr</td>
                            <td>Université de Sciences</td>
                            <td>10/01/2025</td>
                            <td><span class="status-badge status-confirmed">Confirmé</span></td>
                            <td>
                                <button class="action-btn btn-email" title="Envoyer email">📧</button>
                                <button class="action-btn btn-cancel" title="Annuler">❌</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Marc Rousseau</td>
                            <td>marc.rousseau@eco.org</td>
                            <td>Association EcoMonde</td>
                            <td>12/01/2025</td>
                            <td><span class="status-badge status-confirmed">Confirmé</span></td>
                            <td>
                                <button class="action-btn btn-email" title="Envoyer email">📧</button>
                                <button class="action-btn btn-cancel" title="Annuler">❌</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Upcycling Participants -->
            <div id="upcycling" class="tab-content" style="display: none;">
                <div class="empty-state">
                    <div class="icon">📝</div>
                    <h3>Inscriptions ouvertes</h3>
                    <p>Les inscriptions pour cet atelier viennent d'ouvrir. Les premiers participants apparaîtront ici.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Cacher tous les contenus d'onglet
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => content.style.display = 'none');
            
            // Désactiver tous les boutons d'onglet
            const tabButtons = document.querySelectorAll('.tab-button');
            tabButtons.forEach(button => button.classList.remove('active'));
            
            // Afficher le contenu sélectionné
            document.getElementById(tabName).style.display = 'block';
            
            // Activer le bouton sélectionné
            event.target.classList.add('active');
        }
    </script>
</body>
</html>
