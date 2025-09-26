<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Points de Collecte - Waste To Product</title>
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
        
        /* Filters */
        .content {
            padding: 2rem;
        }
        
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
        
        /* Points Grid */
        .points-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
        }
        
        .point-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        
        .point-card:hover {
            transform: translateY(-5px);
        }
        
        .point-header {
            padding: 2rem;
            color: white;
            position: relative;
        }
        
        .point-header.active {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        }
        
        .point-header.saturated {
            background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%);
        }
        
        .point-header.closed {
            background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);
        }
        
        .status-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            background: rgba(255,255,255,0.2);
        }
        
        .point-content {
            padding: 2rem;
        }
        
        .point-info {
            margin-bottom: 2rem;
        }
        
        .info-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.8rem;
            color: #666;
        }
        
        .capacity-bar {
            background: #e9ecef;
            border-radius: 10px;
            height: 8px;
            margin: 1rem 0;
            overflow: hidden;
        }
        
        .capacity-fill {
            height: 100%;
            border-radius: 10px;
            transition: width 0.3s ease;
        }
        
        .capacity-normal { background: #4CAF50; }
        .capacity-warning { background: #FF9800; }
        .capacity-danger { background: #f44336; }
        
        .point-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        
        .btn-edit {
            background: #17a2b8;
            flex: 1;
            min-width: 80px;
        }
        
        .btn-delete {
            background: #dc3545;
            flex: 1;
            min-width: 80px;
        }
        
        .btn-view {
            background: #6c757d;
            flex: 1;
            min-width: 80px;
        }
        
        /* Quick Stats */
        .quick-stats {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
        }
        
        .stat-item {
            text-align: center;
            padding: 1rem;
            border-radius: 8px;
            background: #f8f9fa;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #FF9800;
        }
        
        .stat-label {
            color: #666;
            font-size: 0.9rem;
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
        
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
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
            
            .points-grid {
                grid-template-columns: 1fr;
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
            <li><a href="{{ route('collection.points') }}" class="active"><span class="icon">🏢</span> Gestion des Points</a></li>
            <li><a href="{{ route('collection.deposits') }}"><span class="icon">📋</span> Gestion des Dépôts</a></li>
            <li><a href="{{ route('events.index') }}"><span class="icon">🎪</span> Événements</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <header class="header">
            <div>
                <h1>Gestion des Points de Collecte</h1>
                <div class="breadcrumb">
                    <a href="{{ route('dashboard') }}">Dashboard</a> / 
                    <a href="{{ route('collection.index') }}">Points de Collecte</a> / 
                    Gestion des Points
                </div>
            </div>
            <button class="btn btn-success" onclick="openAddModal()">+ Nouveau Point</button>
        </header>

        <div class="content">
            <!-- Quick Stats -->
            <div class="quick-stats">
                <div class="stat-item">
                    <div class="stat-number">89</div>
                    <div class="stat-label">Points Total</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">67</div>
                    <div class="stat-label">Actifs</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">15</div>
                    <div class="stat-label">Saturés</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">7</div>
                    <div class="stat-label">Fermés</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">78%</div>
                    <div class="stat-label">Taux Utilisation</div>
                </div>
            </div>

            <!-- Filters -->
            <div class="filters">
                <div class="filter-group">
                    <label>Statut</label>
                    <select>
                        <option value="">Tous les statuts</option>
                        <option value="active">Actif</option>
                        <option value="saturated">Saturé</option>
                        <option value="closed">Fermé</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Capacité</label>
                    <select>
                        <option value="">Toutes capacités</option>
                        <option value="small">Petite (< 50)</option>
                        <option value="medium">Moyenne (50-100)</option>
                        <option value="large">Grande (> 100)</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Ville</label>
                    <input type="text" placeholder="Rechercher une ville...">
                </div>
                <div class="filter-group">
                    <label>Responsable</label>
                    <select>
                        <option value="">Tous les responsables</option>
                        <option value="user1">Marie Dubois</option>
                        <option value="user2">Pierre Martin</option>
                        <option value="user3">Sophie Leroy</option>
                    </select>
                </div>
                <button class="btn">Filtrer</button>
            </div>

            <!-- Points Grid -->
            <div class="points-grid">
                <!-- Point Actif -->
                <div class="point-card">
                    <div class="point-header active">
                        <span class="status-badge">ACTIF</span>
                        <h3>Centre-Ville Nord</h3>
                        <p>📍 Place de la République, 75001 Paris</p>
                    </div>
                    <div class="point-content">
                        <div class="point-info">
                            <div class="info-item">
                                <span>📞</span>
                                <span>01 23 45 67 89</span>
                            </div>
                            <div class="info-item">
                                <span>⏰</span>
                                <span>Lun-Ven: 8h-18h, Sam: 9h-17h</span>
                            </div>
                            <div class="info-item">
                                <span>👤</span>
                                <span>Marie Dubois (Responsable)</span>
                            </div>
                            <div class="info-item">
                                <span>📊</span>
                                <span>Capacité: 85/150 (57%)</span>
                            </div>
                        </div>
                        
                        <div class="capacity-bar">
                            <div class="capacity-fill capacity-normal" style="width: 57%"></div>
                        </div>
                        
                        <div class="point-actions">
                            <button class="btn btn-view">Voir</button>
                            <button class="btn btn-edit">Modifier</button>
                            <button class="btn btn-delete">Supprimer</button>
                        </div>
                    </div>
                </div>

                <!-- Point Saturé -->
                <div class="point-card">
                    <div class="point-header saturated">
                        <span class="status-badge">SATURÉ</span>
                        <h3>Quartier des Halles</h3>
                        <p>📍 Rue de Rivoli, 75001 Paris</p>
                    </div>
                    <div class="point-content">
                        <div class="point-info">
                            <div class="info-item">
                                <span>📞</span>
                                <span>01 34 56 78 90</span>
                            </div>
                            <div class="info-item">
                                <span>⏰</span>
                                <span>Lun-Sam: 7h-19h</span>
                            </div>
                            <div class="info-item">
                                <span>👤</span>
                                <span>Pierre Martin (Responsable)</span>
                            </div>
                            <div class="info-item">
                                <span>📊</span>
                                <span>Capacité: 95/100 (95%)</span>
                            </div>
                        </div>
                        
                        <div class="capacity-bar">
                            <div class="capacity-fill capacity-danger" style="width: 95%"></div>
                        </div>
                        
                        <div class="point-actions">
                            <button class="btn btn-view">Voir</button>
                            <button class="btn btn-edit">Modifier</button>
                            <button class="btn btn-delete">Supprimer</button>
                        </div>
                    </div>
                </div>

                <!-- Point avec Capacité Moyenne -->
                <div class="point-card">
                    <div class="point-header active">
                        <span class="status-badge">ACTIF</span>
                        <h3>Zone Industrielle Est</h3>
                        <p>📍 Avenue des Entreprises, 94000 Créteil</p>
                    </div>
                    <div class="point-content">
                        <div class="point-info">
                            <div class="info-item">
                                <span>📞</span>
                                <span>01 45 67 89 01</span>
                            </div>
                            <div class="info-item">
                                <span>⏰</span>
                                <span>Lun-Ven: 6h-20h</span>
                            </div>
                            <div class="info-item">
                                <span>👤</span>
                                <span>Sophie Leroy (Responsable)</span>
                            </div>
                            <div class="info-item">
                                <span>📊</span>
                                <span>Capacité: 62/80 (78%)</span>
                            </div>
                        </div>
                        
                        <div class="capacity-bar">
                            <div class="capacity-fill capacity-warning" style="width: 78%"></div>
                        </div>
                        
                        <div class="point-actions">
                            <button class="btn btn-view">Voir</button>
                            <button class="btn btn-edit">Modifier</button>
                            <button class="btn btn-delete">Supprimer</button>
                        </div>
                    </div>
                </div>

                <!-- Point Fermé -->
                <div class="point-card">
                    <div class="point-header closed">
                        <span class="status-badge">FERMÉ</span>
                        <h3>Marché Saint-Germain</h3>
                        <p>📍 Boulevard Saint-Germain, 75006 Paris</p>
                    </div>
                    <div class="point-content">
                        <div class="point-info">
                            <div class="info-item">
                                <span>📞</span>
                                <span>01 56 78 90 12</span>
                            </div>
                            <div class="info-item">
                                <span>⏰</span>
                                <span>Fermé temporairement</span>
                            </div>
                            <div class="info-item">
                                <span>👤</span>
                                <span>Jean Moreau (Responsable)</span>
                            </div>
                            <div class="info-item">
                                <span>📊</span>
                                <span>Maintenance en cours</span>
                            </div>
                        </div>
                        
                        <div class="capacity-bar">
                            <div class="capacity-fill" style="width: 0%; background: #ccc"></div>
                        </div>
                        
                        <div class="point-actions">
                            <button class="btn btn-view">Voir</button>
                            <button class="btn btn-edit">Modifier</button>
                            <button class="btn btn-delete">Supprimer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Add Point Modal -->
    <div id="addPointModal" class="modal">
        <div class="modal-content">
            <button class="close-modal" onclick="closeAddModal()">&times;</button>
            <h2>Créer un Nouveau Point de Collecte</h2>
            
            <form>
                <div class="form-group">
                    <label>Nom du point de collecte</label>
                    <input type="text" placeholder="Ex: Centre-Ville Nord" required>
                </div>
                
                <div class="form-group">
                    <label>Adresse complète</label>
                    <textarea placeholder="Adresse précise du point de collecte..." required></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Latitude</label>
                        <input type="number" step="0.000001" placeholder="48.856614" required>
                    </div>
                    <div class="form-group">
                        <label>Longitude</label>
                        <input type="number" step="0.000001" placeholder="2.3522219" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Capacité de stockage</label>
                        <input type="number" placeholder="150" required>
                    </div>
                    <div class="form-group">
                        <label>Responsable</label>
                        <select required>
                            <option value="">Choisir un responsable</option>
                            <option value="1">Marie Dubois</option>
                            <option value="2">Pierre Martin</option>
                            <option value="3">Sophie Leroy</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Horaires d'ouverture</label>
                    <textarea placeholder="Ex: Lun-Ven: 8h-18h, Sam: 9h-17h" required></textarea>
                </div>
                
                <div class="form-group">
                    <label>Informations de contact</label>
                    <textarea placeholder="Téléphone, email, instructions particulières..."></textarea>
                </div>
                
                <div class="form-group">
                    <label>Statut initial</label>
                    <select required>
                        <option value="active">Actif</option>
                        <option value="closed">Fermé</option>
                    </select>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-cancel" onclick="closeAddModal()">Annuler</button>
                    <button type="submit" class="btn btn-success">Créer le Point</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('addPointModal').style.display = 'block';
        }
        
        function closeAddModal() {
            document.getElementById('addPointModal').style.display = 'none';
        }
        
        // Fermer la modal en cliquant en dehors
        window.onclick = function(event) {
            const modal = document.getElementById('addPointModal');
            if (event.target === modal) {
                closeAddModal();
            }
        }
    </script>
</body>
</html>
