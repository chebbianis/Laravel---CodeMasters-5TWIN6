<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Dépôts - Waste To Product</title>
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
        
        /* Main Content */
        .main-content {
            margin-left: 250px;
            min-height: 100vh;
        }
        
        .header {
            background: white;
            padding: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header h1 {
            color: #333;
            font-size: 2.2rem;
        }
        
        .breadcrumb a {
            color: #667eea;
            text-decoration: none;
        }
        
        .btn {
            padding: 12px 24px;
            background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%);
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
        
        .btn-success {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        }
        
        /* Content */
        .content {
            padding: 2rem;
        }
        
        /* Stats Dashboard */
        .stats-dashboard {
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
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .stat-card .number {
            font-size: 2.2rem;
            font-weight: bold;
            color: #FF9800;
            margin-bottom: 0.5rem;
        }
        
        .stat-card .label {
            color: #666;
            font-size: 1rem;
        }
        
        .stat-card .trend {
            font-size: 0.8rem;
            margin-top: 0.5rem;
        }
        
        .trend.up {
            color: #4CAF50;
        }
        
        .trend.down {
            color: #f44336;
        }
        
        /* Filters */
        .filters {
            background: white;
            padding: 2rem;
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
        }
        
        .filter-group select,
        .filter-group input {
            padding: 8px 12px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
        }
        
        /* Deposits Table */
        .deposits-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .section-header {
            padding: 2rem;
            border-bottom: 2px solid #f8f9fa;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .section-header h2 {
            color: #333;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .deposits-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .deposits-table th,
        .deposits-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #f8f9fa;
        }
        
        .deposits-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
        }
        
        .deposits-table tr:hover {
            background: #f8f9fa;
        }
        
        /* Item badges */
        .item-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .item-electronics {
            background: #e3f2fd;
            color: #1976d2;
        }
        
        .item-furniture {
            background: #fff3e0;
            color: #f57c00;
        }
        
        .item-clothing {
            background: #f3e5f5;
            color: #7b1fa2;
        }
        
        .item-books {
            background: #e8f5e8;
            color: #388e3c;
        }
        
        /* Point badges */
        .point-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            background: #fff3cd;
            color: #856404;
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
        
        .btn-view {
            background: #17a2b8;
            color: white;
        }
        
        .btn-edit {
            background: #28a745;
            color: white;
        }
        
        .btn-delete {
            background: #dc3545;
            color: white;
        }
        
        .action-btn:hover {
            opacity: 0.8;
            transform: translateY(-1px);
        }
        
        /* Recent Deposits */
        .recent-deposits {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .recent-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            margin-bottom: 0.5rem;
            border-radius: 8px;
            background: #f8f9fa;
            transition: all 0.3s;
        }
        
        .recent-item:hover {
            background: #e9ecef;
        }
        
        .recent-icon {
            font-size: 2rem;
            margin-right: 1rem;
        }
        
        .recent-info {
            flex: 1;
        }
        
        .recent-title {
            font-weight: 600;
            color: #333;
        }
        
        .recent-details {
            color: #666;
            font-size: 0.9rem;
        }
        
        .recent-time {
            color: #999;
            font-size: 0.8rem;
        }
        
        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            z-index: 1000;
        }
        
        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 3rem;
            border-radius: 16px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .modal h2 {
            margin-bottom: 2rem;
            color: #333;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #333;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        
        .close-modal {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: 2rem;
            cursor: pointer;
            color: #999;
        }
        
        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
        }
        
        .btn-cancel {
            background: #6c757d;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .filters {
                flex-direction: column;
            }
            
            .deposits-table {
                font-size: 0.8rem;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">
            <h2>🔄 Waste To Product</h2>
            <p>Points de Collecte</p>
        </div>
        
        <ul class="nav-menu">
            <li><a href="{{ route('dashboard') }}"><span class="icon">🏠</span> Dashboard</a></li>
            <li><a href="{{ route('catalog.index') }}"><span class="icon">📦</span> Catalogue des Objets</a></li>
            <li><a href="{{ route('partners.index') }}"><span class="icon">🤝</span> Partenaires</a></li>
            <li><a href="{{ route('collection.index') }}"><span class="icon">📍</span> Points de Collecte</a></li>
            <li><a href="{{ route('collection.points') }}"><span class="icon">🏢</span> Gestion des Points</a></li>
            <li><a href="{{ route('collection.deposits') }}" class="active"><span class="icon">📋</span> Gestion des Dépôts</a></li>
            <li><a href="{{ route('events.index') }}"><span class="icon">🎪</span> Événements</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <header class="header">
            <div>
                <h1>Gestion des Dépôts</h1>
                <div class="breadcrumb">
                    <a href="{{ route('dashboard') }}">Dashboard</a> / 
                    <a href="{{ route('collection.index') }}">Points de Collecte</a> / 
                    Gestion des Dépôts
                </div>
            </div>
            <button class="btn btn-success" onclick="openAddModal()">+ Nouveau Dépôt</button>
        </header>

        <div class="content">
            <!-- Stats Dashboard -->
            <div class="stats-dashboard">
                <div class="stat-card">
                    <div class="icon">📋</div>
                    <div class="number">1,234</div>
                    <div class="label">Dépôts ce mois</div>
                    <div class="trend up">↗ +15% vs mois dernier</div>
                </div>
                <div class="stat-card">
                    <div class="icon">📊</div>
                    <div class="number">89</div>
                    <div class="label">Dépôts aujourd'hui</div>
                    <div class="trend up">↗ +8% vs hier</div>
                </div>
                <div class="stat-card">
                    <div class="icon">⚖️</div>
                    <div class="number">2.8T</div>
                    <div class="label">Poids total collecté</div>
                    <div class="trend up">↗ +12%</div>
                </div>
                <div class="stat-card">
                    <div class="icon">👥</div>
                    <div class="number">456</div>
                    <div class="label">Déposants uniques</div>
                    <div class="trend up">↗ +23%</div>
                </div>
            </div>

            <!-- Recent Deposits -->
            <div class="recent-deposits">
                <h2 style="margin-bottom: 1.5rem; color: #333;">📋 Dépôts Récents</h2>
                
                <div class="recent-item">
                    <div class="recent-icon">📱</div>
                    <div class="recent-info">
                        <div class="recent-title">Smartphone Samsung Galaxy</div>
                        <div class="recent-details">Déposé par Marie Dubois au Centre-Ville Nord</div>
                        <div class="recent-time">Il y a 15 minutes</div>
                    </div>
                </div>
                
                <div class="recent-item">
                    <div class="recent-icon">🪑</div>
                    <div class="recent-info">
                        <div class="recent-title">Chaise de bureau</div>
                        <div class="recent-details">Déposé par Pierre Martin aux Halles</div>
                        <div class="recent-time">Il y a 32 minutes</div>
                    </div>
                </div>
                
                <div class="recent-item">
                    <div class="recent-icon">👕</div>
                    <div class="recent-info">
                        <div class="recent-title">Lot de vêtements (5 pièces)</div>
                        <div class="recent-details">Déposé par Sophie Leroy à Zone Industrielle Est</div>
                        <div class="recent-time">Il y a 1 heure</div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="filters">
                <div class="filter-group">
                    <label>Point de collecte</label>
                    <select>
                        <option value="">Tous les points</option>
                        <option value="1">Centre-Ville Nord</option>
                        <option value="2">Quartier des Halles</option>
                        <option value="3">Zone Industrielle Est</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Type d'objet</label>
                    <select>
                        <option value="">Tous les types</option>
                        <option value="electronics">Électronique</option>
                        <option value="furniture">Mobilier</option>
                        <option value="clothing">Vêtements</option>
                        <option value="books">Livres</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Date début</label>
                    <input type="date">
                </div>
                <div class="filter-group">
                    <label>Date fin</label>
                    <input type="date">
                </div>
                <div class="filter-group">
                    <label>Déposant</label>
                    <input type="text" placeholder="Nom du déposant...">
                </div>
                <button class="btn">Filtrer</button>
            </div>

            <!-- Deposits Table -->
            <div class="deposits-section">
                <div class="section-header">
                    <h2>📋 Liste des Dépôts</h2>
                    <div>
                        <button class="btn">📊 Export Excel</button>
                        <button class="btn" style="margin-left: 0.5rem;">📄 Export PDF</button>
                    </div>
                </div>
                
                <table class="deposits-table">
                    <thead>
                        <tr>
                            <th>Date & Heure</th>
                            <th>Point de Collecte</th>
                            <th>Objet Déposé</th>
                            <th>Déposant</th>
                            <th>Quantité</th>
                            <th>Notes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>26/09/2025<br><small>14:30</small></td>
                            <td><span class="point-badge">Centre-Ville Nord</span></td>
                            <td><span class="item-badge item-electronics">Smartphone Samsung</span></td>
                            <td>Marie Dubois</td>
                            <td>1</td>
                            <td>Écran cassé, fonctionne</td>
                            <td>
                                <button class="action-btn btn-view" title="Voir détails">👁️</button>
                                <button class="action-btn btn-edit" title="Modifier">✏️</button>
                                <button class="action-btn btn-delete" title="Supprimer">🗑️</button>
                            </td>
                        </tr>
                        <tr>
                            <td>26/09/2025<br><small>13:45</small></td>
                            <td><span class="point-badge">Quartier des Halles</span></td>
                            <td><span class="item-badge item-furniture">Chaise de bureau</span></td>
                            <td>Pierre Martin</td>
                            <td>1</td>
                            <td>Roulettes défaillantes</td>
                            <td>
                                <button class="action-btn btn-view" title="Voir détails">👁️</button>
                                <button class="action-btn btn-edit" title="Modifier">✏️</button>
                                <button class="action-btn btn-delete" title="Supprimer">🗑️</button>
                            </td>
                        </tr>
                        <tr>
                            <td>26/09/2025<br><small>12:20</small></td>
                            <td><span class="point-badge">Zone Industrielle Est</span></td>
                            <td><span class="item-badge item-clothing">Lot vêtements</span></td>
                            <td>Sophie Leroy</td>
                            <td>5</td>
                            <td>Bon état général</td>
                            <td>
                                <button class="action-btn btn-view" title="Voir détails">👁️</button>
                                <button class="action-btn btn-edit" title="Modifier">✏️</button>
                                <button class="action-btn btn-delete" title="Supprimer">🗑️</button>
                            </td>
                        </tr>
                        <tr>
                            <td>26/09/2025<br><small>11:15</small></td>
                            <td><span class="point-badge">Centre-Ville Nord</span></td>
                            <td><span class="item-badge item-books">Encyclopédie 20 volumes</span></td>
                            <td>Jean Moreau</td>
                            <td>20</td>
                            <td>Collection complète années 90</td>
                            <td>
                                <button class="action-btn btn-view" title="Voir détails">👁️</button>
                                <button class="action-btn btn-edit" title="Modifier">✏️</button>
                                <button class="action-btn btn-delete" title="Supprimer">🗑️</button>
                            </td>
                        </tr>
                        <tr>
                            <td>26/09/2025<br><small>10:30</small></td>
                            <td><span class="point-badge">Marché Saint-Germain</span></td>
                            <td><span class="item-badge item-electronics">Ordinateur portable</span></td>
                            <td>Anne Dupont</td>
                            <td>1</td>
                            <td>Ne démarre plus</td>
                            <td>
                                <button class="action-btn btn-view" title="Voir détails">👁️</button>
                                <button class="action-btn btn-edit" title="Modifier">✏️</button>
                                <button class="action-btn btn-delete" title="Supprimer">🗑️</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Add Deposit Modal -->
    <div id="addDepositModal" class="modal">
        <div class="modal-content">
            <button class="close-modal" onclick="closeAddModal()">&times;</button>
            <h2>Enregistrer un Nouveau Dépôt</h2>
            
            <form>
                <div class="form-row">
                    <div class="form-group">
                        <label>Point de collecte</label>
                        <select required>
                            <option value="">Choisir un point</option>
                            <option value="1">Centre-Ville Nord</option>
                            <option value="2">Quartier des Halles</option>
                            <option value="3">Zone Industrielle Est</option>
                            <option value="4">Marché Saint-Germain</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Objet déposé</label>
                        <select required>
                            <option value="">Choisir un objet</option>
                            <option value="1">Smartphone</option>
                            <option value="2">Ordinateur portable</option>
                            <option value="3">Chaise de bureau</option>
                            <option value="4">Vêtements</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Nom du déposant</label>
                    <input type="text" placeholder="Nom complet" required>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Date du dépôt</label>
                        <input type="date" required>
                    </div>
                    <div class="form-group">
                        <label>Heure du dépôt</label>
                        <input type="time" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Quantité</label>
                        <input type="number" min="1" placeholder="1" required>
                    </div>
                    <div class="form-group">
                        <label>Poids estimé (kg)</label>
                        <input type="number" step="0.1" placeholder="1.5">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>État de l'objet</label>
                    <select required>
                        <option value="">Choisir un état</option>
                        <option value="excellent">Excellent</option>
                        <option value="bon">Bon</option>
                        <option value="moyen">Moyen</option>
                        <option value="mauvais">Mauvais - pour pièces</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Notes et observations</label>
                    <textarea placeholder="Détails sur l'état, défauts éventuels, instructions particulières..."></textarea>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-cancel" onclick="closeAddModal()">Annuler</button>
                    <button type="submit" class="btn btn-success">Enregistrer le Dépôt</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('addDepositModal').style.display = 'block';
        }
        
        function closeAddModal() {
            document.getElementById('addDepositModal').style.display = 'none';
        }
        
        // Fermer la modal en cliquant en dehors
        window.onclick = function(event) {
            const modal = document.getElementById('addDepositModal');
            if (event.target === modal) {
                closeAddModal();
            }
        }
    </script>
</body>
</html>
