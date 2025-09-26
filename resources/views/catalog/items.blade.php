<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion des Objets - Waste To Product</title>
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
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .search-bar {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .search-bar input,
        .search-bar select {
            padding: 0.8rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
        }

        .search-bar input:focus,
        .search-bar select:focus {
            outline: none;
            border-color: #667eea;
        }

        .items-table {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .table-header {
            background: #f8fafc;
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .table-header h2 {
            color: #333;
            display: flex;
            align-items: center;
        }

        .table-header .icon {
            margin-right: 1rem;
            font-size: 1.5rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            background: #f8fafc;
            font-weight: 600;
            color: #333;
        }

        .status {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status.available {
            background: #d4edda;
            color: #155724;
        }

        .status.repair {
            background: #fff3cd;
            color: #856404;
        }

        .status.transformed {
            background: #d1ecf1;
            color: #0c5460;
        }

        .actions {
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

        .btn-edit {
            background: #ffc107;
            color: #212529;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-view {
            background: #17a2b8;
            color: white;
        }

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
            max-width: 500px;
            max-height: 80vh;
            overflow-y: auto;
        }

        .modal-header {
            margin-bottom: 1.5rem;
        }

        .modal-header h3 {
            color: #333;
        }

        .close-btn {
            float: right;
            font-size: 1.5rem;
            cursor: pointer;
            color: #999;
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

        .form-group textarea {
            resize: vertical;
            height: 100px;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .search-bar {
                flex-direction: column;
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
            <div>
                <h1>Gestion des Objets Valorisables</h1>
                <div class="breadcrumb">
                    <a href="{{ route('dashboard') }}">Dashboard</a> / 
                    <a href="{{ route('catalog.index') }}">Catalogue</a> / Objets
                </div>
            </div>
        </header>

        <div class="content">
            <!-- Actions de page -->
            <div class="page-actions">
                <h2>Liste des Objets Valorisables</h2>
                <button onclick="openModal('addModal')" class="btn-primary">+ Ajouter un Objet</button>
            </div>

            <!-- Barre de recherche -->
            <div class="search-bar">
                <input type="text" placeholder="Rechercher un objet..." style="flex: 1;">
                <select style="width: 200px;">
                    <option value="">Toutes les catégories</option>
                    <option value="electronique">Électronique</option>
                    <option value="textile">Textile</option>
                    <option value="mobilier">Mobilier</option>
                    <option value="decoration">Décoration</option>
                </select>
                <select style="width: 150px;">
                    <option value="">Tous les états</option>
                    <option value="available">Disponible</option>
                    <option value="repair">En réparation</option>
                    <option value="transformed">Transformé</option>
                </select>
            </div>

            <!-- Tableau des objets -->
            <div class="items-table">
                <div class="table-header">
                    <h2><span class="icon">📋</span> Objets Valorisables</h2>
                </div>
                
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Catégorie</th>
                            <th>État</th>
                            <th>Statut</th>
                            <th>Date d'ajout</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Vélo de ville</td>
                            <td>Transport</td>
                            <td>Bon état</td>
                            <td><span class="status available">Disponible</span></td>
                            <td>15/03/2024</td>
                            <td class="actions">
                                <button class="btn-sm btn-view">👁️</button>
                                <button class="btn-sm btn-edit" onclick="openModal('editModal')">✏️</button>
                                <button class="btn-sm btn-delete">🗑️</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Ordinateur portable</td>
                            <td>Électronique</td>
                            <td>À réparer</td>
                            <td><span class="status repair">En réparation</span></td>
                            <td>12/03/2024</td>
                            <td class="actions">
                                <button class="btn-sm btn-view">👁️</button>
                                <button class="btn-sm btn-edit" onclick="openModal('editModal')">✏️</button>
                                <button class="btn-sm btn-delete">🗑️</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Commode en bois</td>
                            <td>Mobilier</td>
                            <td>Excellent</td>
                            <td><span class="status transformed">Transformé</span></td>
                            <td>08/03/2024</td>
                            <td class="actions">
                                <button class="btn-sm btn-view">👁️</button>
                                <button class="btn-sm btn-edit" onclick="openModal('editModal')">✏️</button>
                                <button class="btn-sm btn-delete">🗑️</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal Ajouter Objet -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close-btn" onclick="closeModal('addModal')">&times;</span>
                <h3>Ajouter un Nouvel Objet</h3>
            </div>
            
            <form>
                <div class="form-group">
                    <label for="name">Nom de l'objet</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="category">Catégorie</label>
                    <select id="category" name="category" required>
                        <option value="">Sélectionner une catégorie</option>
                        <option value="electronique">Électronique</option>
                        <option value="textile">Textile</option>
                        <option value="mobilier">Mobilier</option>
                        <option value="decoration">Décoration</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="condition">État</label>
                    <select id="condition" name="condition" required>
                        <option value="">Sélectionner l'état</option>
                        <option value="excellent">Excellent</option>
                        <option value="bon">Bon état</option>
                        <option value="moyen">État moyen</option>
                        <option value="reparer">À réparer</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="Description détaillée de l'objet..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="image">Image (URL)</label>
                    <input type="url" id="image" name="image_url">
                </div>
                
                <button type="submit" class="btn-primary">Ajouter l'Objet</button>
            </form>
        </div>
    </div>

    <!-- Modal Modifier Objet -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close-btn" onclick="closeModal('editModal')">&times;</span>
                <h3>Modifier l'Objet</h3>
            </div>
            
            <form>
                <div class="form-group">
                    <label for="edit_name">Nom de l'objet</label>
                    <input type="text" id="edit_name" name="name" value="Vélo de ville" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_category">Catégorie</label>
                    <select id="edit_category" name="category" required>
                        <option value="transport" selected>Transport</option>
                        <option value="electronique">Électronique</option>
                        <option value="textile">Textile</option>
                        <option value="mobilier">Mobilier</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="edit_condition">État</label>
                    <select id="edit_condition" name="condition" required>
                        <option value="bon" selected>Bon état</option>
                        <option value="excellent">Excellent</option>
                        <option value="moyen">État moyen</option>
                        <option value="reparer">À réparer</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="edit_status">Statut</label>
                    <select id="edit_status" name="status" required>
                        <option value="available" selected>Disponible</option>
                        <option value="repair">En réparation</option>
                        <option value="transformed">Transformé</option>
                        <option value="recycled">Recyclé</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="edit_description">Description</label>
                    <textarea id="edit_description" name="description">Vélo de ville en bon état, quelques éraflures mineures...</textarea>
                </div>
                
                <button type="submit" class="btn-primary">Mettre à Jour</button>
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

        // Fermer le modal en cliquant en dehors
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('show');
            }
        }
    </script>
</body>
</html>
