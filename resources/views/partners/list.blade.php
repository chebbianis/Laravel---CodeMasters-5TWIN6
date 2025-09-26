<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Liste des Partenaires - Waste To Product</title>
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

        .nav-menu a:hover {
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

        .page-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .btn-primary {
            padding: 1rem 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }

        .filters {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .filters input,
        .filters select {
            padding: 0.8rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
        }

        .partners-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
        }

        .partner-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.3s;
        }

        .partner-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .partner-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .partner-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-right: 1rem;
        }

        .partner-info h3 {
            color: #333;
            margin-bottom: 0.5rem;
        }

        .partner-type {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .type-ong { background: #d4edda; color: #155724; }
        .type-municipalite { background: #cce5ff; color: #004085; }
        .type-entreprise { background: #fff3cd; color: #856404; }
        .type-association { background: #d1ecf1; color: #0c5460; }
        .type-etablissement { background: #e2e3f0; color: #383d41; }

        .partner-details {
            margin: 1rem 0;
        }

        .detail-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
            color: #666;
            font-size: 0.9rem;
        }

        .detail-icon {
            margin-right: 0.5rem;
            width: 16px;
        }

        .partner-status {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .status-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .status-inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .partner-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.8rem;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-edit { background: #ffc107; color: #212529; }
        .btn-delete { background: #dc3545; color: white; }
        .btn-view { background: #17a2b8; color: white; }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
        }

        .modal.show {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
        }

        .close-btn {
            float: right;
            font-size: 1.5rem;
            cursor: pointer;
            color: #999;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #555;
            font-weight: 500;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .partners-grid {
                grid-template-columns: 1fr;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="logo">
            <h2>🔄 Waste To Product</h2>
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
            <h1>Liste des Partenaires</h1>
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}">Dashboard</a> / 
                <a href="{{ route('partners.index') }}">Partenaires</a> / Liste
            </div>
        </header>

        <div class="content">
            <div class="page-actions">
                <h2>Nos Partenaires (56)</h2>
                <button onclick="openModal('addModal')" class="btn-primary">+ Ajouter un Partenaire</button>
            </div>

            <!-- Filtres -->
            <div class="filters">
                <input type="text" placeholder="Rechercher un partenaire..." style="flex: 1; min-width: 250px;">
                <select style="width: 180px;">
                    <option value="">Tous les types</option>
                    <option value="ong">ONG</option>
                    <option value="municipalite">Municipalité</option>
                    <option value="entreprise">Entreprise</option>
                    <option value="association">Association</option>
                    <option value="etablissement">Établissement Public</option>
                </select>
                <select style="width: 150px;">
                    <option value="">Tous les statuts</option>
                    <option value="active">Actif</option>
                    <option value="inactive">Inactif</option>
                </select>
            </div>

            <!-- Grille des partenaires -->
            <div class="partners-grid">
                <!-- Partenaire 1 -->
                <div class="partner-card">
                    <div class="partner-header">
                        <div class="partner-avatar" style="background: #d4edda;">🌱</div>
                        <div class="partner-info">
                            <h3>Eco-Citoyens 78</h3>
                            <span class="partner-type type-ong">Association</span>
                        </div>
                    </div>
                    
                    <div class="partner-details">
                        <div class="detail-item">
                            <span class="detail-icon">📧</span>
                            <span>contact@ecocitoyens78.fr</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-icon">📞</span>
                            <span>01 34 56 78 90</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-icon">📍</span>
                            <span>Versailles, 78000</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-icon">🌐</span>
                            <span>www.ecocitoyens78.fr</span>
                        </div>
                    </div>
                    
                    <div class="partner-status">
                        <span class="status-badge status-active">● Actif</span>
                        <div class="partner-actions">
                            <button class="btn-sm btn-view">👁️</button>
                            <button class="btn-sm btn-edit" onclick="openEditModal('ecocitoyens')">✏️</button>
                            <button class="btn-sm btn-delete">🗑️</button>
                        </div>
                    </div>
                </div>

                <!-- Partenaire 2 -->
                <div class="partner-card">
                    <div class="partner-header">
                        <div class="partner-avatar" style="background: #cce5ff;">🏛️</div>
                        <div class="partner-info">
                            <h3>Mairie de Paris</h3>
                            <span class="partner-type type-municipalite">Municipalité</span>
                        </div>
                    </div>
                    
                    <div class="partner-details">
                        <div class="detail-item">
                            <span class="detail-icon">📧</span>
                            <span>environnement@paris.fr</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-icon">📞</span>
                            <span>01 42 76 40 00</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-icon">📍</span>
                            <span>Paris, 75001</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-icon">🌐</span>
                            <span>www.paris.fr</span>
                        </div>
                    </div>
                    
                    <div class="partner-status">
                        <span class="status-badge status-active">● Actif</span>
                        <div class="partner-actions">
                            <button class="btn-sm btn-view">👁️</button>
                            <button class="btn-sm btn-edit" onclick="openEditModal('paris')">✏️</button>
                            <button class="btn-sm btn-delete">🗑️</button>
                        </div>
                    </div>
                </div>

                <!-- Partenaire 3 -->
                <div class="partner-card">
                    <div class="partner-header">
                        <div class="partner-avatar" style="background: #fff3cd;">🏢</div>
                        <div class="partner-info">
                            <h3>GreenTech Solutions</h3>
                            <span class="partner-type type-entreprise">Entreprise</span>
                        </div>
                    </div>
                    
                    <div class="partner-details">
                        <div class="detail-item">
                            <span class="detail-icon">📧</span>
                            <span>partenariats@greentech.com</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-icon">📞</span>
                            <span>01 45 67 89 10</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-icon">📍</span>
                            <span>Lyon, 69000</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-icon">🌐</span>
                            <span>www.greentech-solutions.com</span>
                        </div>
                    </div>
                    
                    <div class="partner-status">
                        <span class="status-badge status-active">● Actif</span>
                        <div class="partner-actions">
                            <button class="btn-sm btn-view">👁️</button>
                            <button class="btn-sm btn-edit" onclick="openEditModal('greentech')">✏️</button>
                            <button class="btn-sm btn-delete">🗑️</button>
                        </div>
                    </div>
                </div>

                <!-- Partenaire 4 -->
                <div class="partner-card">
                    <div class="partner-header">
                        <div class="partner-avatar" style="background: #d1ecf1;">👥</div>
                        <div class="partner-info">
                            <h3>Repair Café France</h3>
                            <span class="partner-type type-association">Association</span>
                        </div>
                    </div>
                    
                    <div class="partner-details">
                        <div class="detail-item">
                            <span class="detail-icon">📧</span>
                            <span>info@repaircafe.fr</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-icon">📞</span>
                            <span>01 23 45 67 89</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-icon">📍</span>
                            <span>Marseille, 13000</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-icon">🌐</span>
                            <span>www.repaircafe.fr</span>
                        </div>
                    </div>
                    
                    <div class="partner-status">
                        <span class="status-badge status-inactive">● Inactif</span>
                        <div class="partner-actions">
                            <button class="btn-sm btn-view">👁️</button>
                            <button class="btn-sm btn-edit" onclick="openEditModal('repaircafe')">✏️</button>
                            <button class="btn-sm btn-delete">🗑️</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Ajouter Partenaire -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close-btn" onclick="closeModal('addModal')">&times;</span>
                <h3>Ajouter un Nouveau Partenaire</h3>
            </div>
            
            <form>
                <div class="form-group">
                    <label for="partner_name">Nom de l'organisation</label>
                    <input type="text" id="partner_name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="partner_type">Type de partenaire</label>
                    <select id="partner_type" name="type_id" required>
                        <option value="">Sélectionner un type</option>
                        <option value="1">ONG</option>
                        <option value="2">Municipalité</option>
                        <option value="3">Entreprise</option>
                        <option value="4">Association</option>
                        <option value="5">Établissement Public</option>
                    </select>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="contact_email">Email de contact</label>
                        <input type="email" id="contact_email" name="contact_email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Téléphone</label>
                        <input type="tel" id="phone" name="phone">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="address">Adresse</label>
                    <input type="text" id="address" name="address">
                </div>
                
                <div class="form-group">
                    <label for="website">Site web</label>
                    <input type="url" id="website" name="website">
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="3" placeholder="Activités et missions du partenaire..."></textarea>
                </div>
                
                <button type="submit" class="btn-primary">Ajouter le Partenaire</button>
            </form>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.add('show');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('show');
        }

        function openEditModal(partnerId) {
            // Simulation de chargement des données du partenaire
            openModal('addModal'); // Réutilise le même modal pour la démo
        }

        // Fermer le modal en cliquant en dehors
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('show');
            }
        }
    </script>
</body>
</html>
