<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Types de Partenaires - Waste To Product</title>
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

        .types-table {
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

        .type-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 500;
            color: white;
        }

        .type-ong { background: #28a745; }
        .type-municipalite { background: #007bff; }
        .type-entreprise { background: #ffc107; color: #212529; }
        .type-association { background: #17a2b8; }
        .type-etablissement { background: #6f42c1; }

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

        .btn-edit { background: #ffc107; color: #212529; }
        .btn-delete { background: #dc3545; color: white; }

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

        .icon-picker {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .icon-option {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1.5rem;
            transition: all 0.3s;
        }

        .icon-option:hover {
            border-color: #667eea;
        }

        .icon-option.selected {
            border-color: #667eea;
            background: #f0f4ff;
        }

        .count-badge {
            background: #e9ecef;
            color: #495057;
            padding: 0.2rem 0.6rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .main-content {
                margin-left: 0;
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
            <h1>Types de Partenaires</h1>
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}">Dashboard</a> / 
                <a href="{{ route('partners.index') }}">Partenaires</a> / Types
            </div>
        </header>

        <div class="content">
            <div class="page-actions">
                <h2>Gestion des Types de Partenaires</h2>
                <button onclick="openModal('addModal')" class="btn-primary">+ Ajouter un Type</button>
            </div>

            <div class="types-table">
                <div class="table-header">
                    <h3>Types de Partenaires Configurés</h3>
                </div>
                
                <table>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Nombre de Partenaires</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="type-badge type-ong">
                                    🌱 ONG
                                </div>
                            </td>
                            <td>Organisations non gouvernementales engagées dans l'écologie et le développement durable</td>
                            <td><span class="count-badge">12 partenaires</span></td>
                            <td class="actions">
                                <button class="btn-sm btn-edit" onclick="openEditModal('ong')">✏️ Modifier</button>
                                <button class="btn-sm btn-delete">🗑️ Supprimer</button>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <div class="type-badge type-municipalite">
                                    🏛️ Municipalité
                                </div>
                            </td>
                            <td>Collectivités territoriales et services publics locaux</td>
                            <td><span class="count-badge">8 partenaires</span></td>
                            <td class="actions">
                                <button class="btn-sm btn-edit" onclick="openEditModal('municipalite')">✏️ Modifier</button>
                                <button class="btn-sm btn-delete">🗑️ Supprimer</button>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <div class="type-badge type-entreprise">
                                    🏢 Entreprise
                                </div>
                            </td>
                            <td>Entreprises privées engagées dans la responsabilité sociale et environnementale</td>
                            <td><span class="count-badge">23 partenaires</span></td>
                            <td class="actions">
                                <button class="btn-sm btn-edit" onclick="openEditModal('entreprise')">✏️ Modifier</button>
                                <button class="btn-sm btn-delete">🗑️ Supprimer</button>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <div class="type-badge type-association">
                                    👥 Association
                                </div>
                            </td>
                            <td>Associations locales et organisations à but non lucratif</td>
                            <td><span class="count-badge">18 partenaires</span></td>
                            <td class="actions">
                                <button class="btn-sm btn-edit" onclick="openEditModal('association')">✏️ Modifier</button>
                                <button class="btn-sm btn-delete">🗑️ Supprimer</button>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <div class="type-badge type-etablissement">
                                    🏫 Établissement Public
                                </div>
                            </td>
                            <td>Universités, écoles, hôpitaux et autres établissements publics</td>
                            <td><span class="count-badge">7 partenaires</span></td>
                            <td class="actions">
                                <button class="btn-sm btn-edit" onclick="openEditModal('etablissement')">✏️ Modifier</button>
                                <button class="btn-sm btn-delete">🗑️ Supprimer</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal Ajouter Type -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close-btn" onclick="closeModal('addModal')">&times;</span>
                <h3>Ajouter un Nouveau Type de Partenaire</h3>
            </div>
            
            <form>
                <div class="form-group">
                    <label for="type_name">Nom du type</label>
                    <input type="text" id="type_name" name="name" placeholder="Ex: Coopérative" required>
                </div>
                
                <div class="form-group">
                    <label for="type_description">Description</label>
                    <textarea id="type_description" name="description" rows="3" placeholder="Description du type de partenaire..." required></textarea>
                </div>
                
                <div class="form-group">
                    <label>Icône du type</label>
                    <div class="icon-picker">
                        <div class="icon-option" onclick="selectIcon(this)">🌱</div>
                        <div class="icon-option" onclick="selectIcon(this)">🏛️</div>
                        <div class="icon-option" onclick="selectIcon(this)">🏢</div>
                        <div class="icon-option" onclick="selectIcon(this)">👥</div>
                        <div class="icon-option" onclick="selectIcon(this)">🏫</div>
                        <div class="icon-option" onclick="selectIcon(this)">🏪</div>
                        <div class="icon-option" onclick="selectIcon(this)">🌍</div>
                        <div class="icon-option" onclick="selectIcon(this)">♻️</div>
                        <div class="icon-option" onclick="selectIcon(this)">🔧</div>
                        <div class="icon-option" onclick="selectIcon(this)">🎯</div>
                        <div class="icon-option" onclick="selectIcon(this)">⚡</div>
                        <div class="icon-option" onclick="selectIcon(this)">🚀</div>
                    </div>
                </div>
                
                <button type="submit" class="btn-primary">Créer le Type</button>
            </form>
        </div>
    </div>

    <!-- Modal Modifier Type -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close-btn" onclick="closeModal('editModal')">&times;</span>
                <h3>Modifier le Type de Partenaire</h3>
            </div>
            
            <form>
                <div class="form-group">
                    <label for="edit_type_name">Nom du type</label>
                    <input type="text" id="edit_type_name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_type_description">Description</label>
                    <textarea id="edit_type_description" name="description" rows="3" required></textarea>
                </div>
                
                <div class="form-group">
                    <label>Icône du type</label>
                    <div class="icon-picker">
                        <div class="icon-option" onclick="selectIcon(this)">🌱</div>
                        <div class="icon-option" onclick="selectIcon(this)">🏛️</div>
                        <div class="icon-option" onclick="selectIcon(this)">🏢</div>
                        <div class="icon-option" onclick="selectIcon(this)">👥</div>
                        <div class="icon-option" onclick="selectIcon(this)">🏫</div>
                        <div class="icon-option" onclick="selectIcon(this)">🏪</div>
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

        function openEditModal(typeId) {
            const types = {
                'ong': { name: 'ONG', description: 'Organisations non gouvernementales...' },
                'municipalite': { name: 'Municipalité', description: 'Collectivités territoriales...' },
                'entreprise': { name: 'Entreprise', description: 'Entreprises privées engagées...' },
                'association': { name: 'Association', description: 'Associations locales...' },
                'etablissement': { name: 'Établissement Public', description: 'Universités, écoles...' }
            };

            const type = types[typeId];
            if (type) {
                document.getElementById('edit_type_name').value = type.name;
                document.getElementById('edit_type_description').value = type.description;
                openModal('editModal');
            }
        }

        function selectIcon(element) {
            // Retirer la sélection précédente
            document.querySelectorAll('.icon-option').forEach(option => {
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
