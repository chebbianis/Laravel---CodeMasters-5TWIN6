<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion des Catégories - Waste To Product</title>
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

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .category-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.3s;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .category-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .category-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-right: 1rem;
        }

        .category-info h3 {
            color: #333;
            margin-bottom: 0.5rem;
        }

        .category-stats {
            color: #666;
            font-size: 0.9rem;
        }

        .category-description {
            color: #666;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .category-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
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
        }

        .modal-header {
            margin-bottom: 1.5rem;
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
        .form-group textarea {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
        }

        .color-picker {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .color-option {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            border: 3px solid transparent;
            transition: all 0.3s;
        }

        .color-option.selected {
            border-color: #333;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .categories-grid {
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
            <h1>Gestion des Catégories</h1>
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}">Dashboard</a> / 
                <a href="{{ route('catalog.index') }}">Catalogue</a> / Catégories
            </div>
        </header>

        <div class="content">
            <div class="page-actions">
                <h2>Catégories d'Objets</h2>
                <button onclick="openModal('addModal')" class="btn-primary">+ Ajouter une Catégorie</button>
            </div>

            <div class="categories-grid">
                <!-- Catégorie Électronique -->
                <div class="category-card">
                    <div class="category-header">
                        <div class="category-icon" style="background: #e3f2fd;">📱</div>
                        <div class="category-info">
                            <h3>Électronique</h3>
                            <div class="category-stats">234 objets</div>
                        </div>
                    </div>
                    <p class="category-description">
                        Appareils électroniques, ordinateurs, téléphones, composants électroniques pouvant être réparés ou recyclés.
                    </p>
                    <div class="category-actions">
                        <button class="btn-sm btn-view">👁️ Voir</button>
                        <button class="btn-sm btn-edit" onclick="openEditModal('electronique')">✏️ Modifier</button>
                        <button class="btn-sm btn-delete">🗑️ Supprimer</button>
                    </div>
                </div>

                <!-- Catégorie Textile -->
                <div class="category-card">
                    <div class="category-header">
                        <div class="category-icon" style="background: #f3e5f5;">👔</div>
                        <div class="category-info">
                            <h3>Textile</h3>
                            <div class="category-stats">156 objets</div>
                        </div>
                    </div>
                    <p class="category-description">
                        Vêtements, tissus, accessoires textiles pouvant être transformés, réparés ou upcyclés.
                    </p>
                    <div class="category-actions">
                        <button class="btn-sm btn-view">👁️ Voir</button>
                        <button class="btn-sm btn-edit" onclick="openEditModal('textile')">✏️ Modifier</button>
                        <button class="btn-sm btn-delete">🗑️ Supprimer</button>
                    </div>
                </div>

                <!-- Catégorie Mobilier -->
                <div class="category-card">
                    <div class="category-header">
                        <div class="category-icon" style="background: #e8f5e8;">🪑</div>
                        <div class="category-info">
                            <h3>Mobilier</h3>
                            <div class="category-stats">89 objets</div>
                        </div>
                    </div>
                    <p class="category-description">
                        Meubles, chaises, tables, armoires pouvant être restaurés, customisés ou transformés.
                    </p>
                    <div class="category-actions">
                        <button class="btn-sm btn-view">👁️ Voir</button>
                        <button class="btn-sm btn-edit" onclick="openEditModal('mobilier')">✏️ Modifier</button>
                        <button class="btn-sm btn-delete">🗑️ Supprimer</button>
                    </div>
                </div>

                <!-- Catégorie Décoration -->
                <div class="category-card">
                    <div class="category-header">
                        <div class="category-icon" style="background: #fff3e0;">🎨</div>
                        <div class="category-info">
                            <h3>Décoration</h3>
                            <div class="category-stats">67 objets</div>
                        </div>
                    </div>
                    <p class="category-description">
                        Objets décoratifs, arts, artisanat pouvant être restaurés ou transformés en nouvelles créations.
                    </p>
                    <div class="category-actions">
                        <button class="btn-sm btn-view">👁️ Voir</button>
                        <button class="btn-sm btn-edit" onclick="openEditModal('decoration')">✏️ Modifier</button>
                        <button class="btn-sm btn-delete">🗑️ Supprimer</button>
                    </div>
                </div>

                <!-- Catégorie Transport -->
                <div class="category-card">
                    <div class="category-header">
                        <div class="category-icon" style="background: #e1f5fe;">🚲</div>
                        <div class="category-info">
                            <h3>Transport</h3>
                            <div class="category-stats">43 objets</div>
                        </div>
                    </div>
                    <p class="category-description">
                        Vélos, trottinettes, pièces de véhicules pouvant être réparées ou reconditionnées.
                    </p>
                    <div class="category-actions">
                        <button class="btn-sm btn-view">👁️ Voir</button>
                        <button class="btn-sm btn-edit" onclick="openEditModal('transport')">✏️ Modifier</button>
                        <button class="btn-sm btn-delete">🗑️ Supprimer</button>
                    </div>
                </div>

                <!-- Catégorie Cuisine -->
                <div class="category-card">
                    <div class="category-header">
                        <div class="category-icon" style="background: #f1f8e9;">🍳</div>
                        <div class="category-info">
                            <h3>Cuisine</h3>
                            <div class="category-stats">78 objets</div>
                        </div>
                    </div>
                    <p class="category-description">
                        Ustensiles, appareils de cuisine, vaisselle pouvant être réparés ou réutilisés.
                    </p>
                    <div class="category-actions">
                        <button class="btn-sm btn-view">👁️ Voir</button>
                        <button class="btn-sm btn-edit" onclick="openEditModal('cuisine')">✏️ Modifier</button>
                        <button class="btn-sm btn-delete">🗑️ Supprimer</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Ajouter Catégorie -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close-btn" onclick="closeModal('addModal')">&times;</span>
                <h3>Ajouter une Nouvelle Catégorie</h3>
            </div>
            
            <form>
                <div class="form-group">
                    <label for="category_name">Nom de la catégorie</label>
                    <input type="text" id="category_name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="category_description">Description</label>
                    <textarea id="category_description" name="description" rows="3" placeholder="Description de la catégorie..."></textarea>
                </div>
                
                <div class="form-group">
                    <label>Couleur de la catégorie</label>
                    <div class="color-picker">
                        <div class="color-option" style="background: #e3f2fd;" onclick="selectColor(this)"></div>
                        <div class="color-option" style="background: #f3e5f5;" onclick="selectColor(this)"></div>
                        <div class="color-option" style="background: #e8f5e8;" onclick="selectColor(this)"></div>
                        <div class="color-option" style="background: #fff3e0;" onclick="selectColor(this)"></div>
                        <div class="color-option" style="background: #e1f5fe;" onclick="selectColor(this)"></div>
                        <div class="color-option" style="background: #f1f8e9;" onclick="selectColor(this)"></div>
                    </div>
                </div>
                
                <button type="submit" class="btn-primary">Créer la Catégorie</button>
            </form>
        </div>
    </div>

    <!-- Modal Modifier Catégorie -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close-btn" onclick="closeModal('editModal')">&times;</span>
                <h3>Modifier la Catégorie</h3>
            </div>
            
            <form>
                <div class="form-group">
                    <label for="edit_category_name">Nom de la catégorie</label>
                    <input type="text" id="edit_category_name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_category_description">Description</label>
                    <textarea id="edit_category_description" name="description" rows="3"></textarea>
                </div>
                
                <div class="form-group">
                    <label>Couleur de la catégorie</label>
                    <div class="color-picker">
                        <div class="color-option" style="background: #e3f2fd;" onclick="selectColor(this)"></div>
                        <div class="color-option" style="background: #f3e5f5;" onclick="selectColor(this)"></div>
                        <div class="color-option" style="background: #e8f5e8;" onclick="selectColor(this)"></div>
                        <div class="color-option" style="background: #fff3e0;" onclick="selectColor(this)"></div>
                        <div class="color-option" style="background: #e1f5fe;" onclick="selectColor(this)"></div>
                        <div class="color-option" style="background: #f1f8e9;" onclick="selectColor(this)"></div>
                    </div>
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

        function openEditModal(categoryType) {
            const categories = {
                'electronique': { name: 'Électronique', description: 'Appareils électroniques, ordinateurs, téléphones...' },
                'textile': { name: 'Textile', description: 'Vêtements, tissus, accessoires textiles...' },
                'mobilier': { name: 'Mobilier', description: 'Meubles, chaises, tables, armoires...' },
                'decoration': { name: 'Décoration', description: 'Objets décoratifs, arts, artisanat...' },
                'transport': { name: 'Transport', description: 'Vélos, trottinettes, pièces de véhicules...' },
                'cuisine': { name: 'Cuisine', description: 'Ustensiles, appareils de cuisine, vaisselle...' }
            };

            const category = categories[categoryType];
            if (category) {
                document.getElementById('edit_category_name').value = category.name;
                document.getElementById('edit_category_description').value = category.description;
                openModal('editModal');
            }
        }

        function selectColor(element) {
            // Retirer la sélection précédente
            document.querySelectorAll('.color-option').forEach(option => {
                option.classList.remove('selected');
            });
            
            // Ajouter la sélection à l'élément cliqué
            element.classList.add('selected');
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
