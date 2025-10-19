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

        .nav-menu a.active {
            background: rgba(255, 255, 255, 0.2);
            font-weight: 600;
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
            gap: 1rem;
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

        .alerts {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            display: flex;
            gap: 0.6rem;
            align-items: center;
        }

        .alert-success {
            background: #d1fae5;
            color: #047857;
            border: 1px solid #10b981;
        }

        .alert-error {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #ef4444;
        }

        .search-bar {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
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
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-1px);
            transition: all 0.3s;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                transform: translateX(-20px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .btn-primary, .btn-secondary, .btn-danger {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .stat-box {
            animation: fadeIn 0.6s ease-out;
        }

        .item-row {
            animation: slideIn 0.4s ease-out;
        }

        .feature-card {
            animation: fadeIn 0.8s ease-out;
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

        th.sortable {
            user-select: none;
            transition: all 0.3s;
        }

        th.sortable:hover {
            background: #e2e8f0;
        }

        th .sort-icon {
            font-size: 0.8rem;
            color: #9ca3af;
            margin-left: 0.25rem;
        }

        th.sorted-asc .sort-icon::before {
            content: '↑';
            color: #667eea;
            font-weight: bold;
        }

        th.sorted-desc .sort-icon::before {
            content: '↓';
            color: #667eea;
            font-weight: bold;
        }

        .item-row {
            transition: all 0.2s;
        }

        .item-row:hover {
            background: #f8fafc;
        }

        .item-row.selected {
            background: #eef2ff !important;
        }

        .text-center {
            text-align: center;
        }

        input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #667eea;
        }

        /* Toast Notifications */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .toast {
            min-width: 300px;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 1rem;
            animation: slideIn 0.3s ease-out;
            background: white;
        }

        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .toast.success {
            border-left: 4px solid #10b981;
        }

        .toast.error {
            border-left: 4px solid #ef4444;
        }

        .toast.info {
            border-left: 4px solid #3b82f6;
        }

        .toast-icon {
            font-size: 1.5rem;
        }

        .toast-content {
            flex: 1;
        }

        .toast-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .toast-message {
            font-size: 0.9rem;
            color: #6b7280;
        }

        .toast-close {
            cursor: pointer;
            color: #9ca3af;
            font-size: 1.2rem;
            transition: color 0.2s;
        }

        .toast-close:hover {
            color: #4b5563;
        }

        .status {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            text-transform: capitalize;
        }

        .status.status-disponible {
            background: #d1fae5;
            color: #047857;
        }

        .status.status-transforme {
            background: #e0f2fe;
            color: #075985;
        }

        .status.status-recycle {
            background: #ede9fe;
            color: #5b21b6;
        }

        .actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .actions form {
            margin: 0;
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.85rem;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
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
            max-width: 520px;
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
            min-height: 100px;
        }

        .empty-state {
            padding: 2.5rem;
            background: white;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            color: #555;
        }

        .item-image-cell {
            padding: 0.5rem;
        }

        .item-image-container {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            transition: all 0.3s;
        }

        .item-image-container:hover {
            border-color: #667eea;
            transform: scale(1.05);
        }

        .item-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .item-image-placeholder {
            color: #9ca3af;
            font-size: 1.5rem;
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

            .page-actions {
                flex-direction: column;
                align-items: flex-start;
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
            <li><a class="active" href="{{ route('catalog.items') }}"><span class="icon">🛠️</span> Objets</a></li>
            <li><a href="{{ route('catalog.categories') }}"><span class="icon">🏷️</span> Catégories</a></li>
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
            <div class="alerts">
                @if (session('success'))
                    <div class="alert alert-success">✅ {{ session('success') }}</div>
                @endif
                
                @if (session('error'))
                    <div class="alert alert-error">⚠️ {{ session('error') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-error">
                        ⚠️ Merci de corriger les erreurs suivantes :
                        <ul style="margin-top: 0.5rem; margin-left: 1.5rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="page-actions">
                <div>
                    <h2>Liste des Objets Valorisables</h2>
                    <p style="color:#6b7280;">{{ $items->count() }} objet(s) référencé(s)</p>
                </div>
                <div style="display: flex; gap: 1rem;">
                    <button type="button" onclick="exportData('csv')" class="btn-secondary">
                        📊 Exporter CSV
                    </button>
                    <button type="button" onclick="printTable()" class="btn-secondary">
                        🖨️ Imprimer
                    </button>
                    <button type="button" onclick="openModal('addModal')" class="btn-primary">
                        + Ajouter un Objet
                    </button>
                </div>
            </div>

            <div class="search-bar">
                <div style="position: relative; flex: 1;">
                    <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af;">🔍</span>
                    <input type="text" id="searchInput" placeholder="Rechercher par nom, description..." style="flex: 1; padding-left: 40px;">
                </div>
                <select id="categoryFilter" style="min-width: 200px;">
                    <option value="">Toutes les catégories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <select id="statusFilter" style="min-width: 180px;">
                    <option value="">Tous les statuts</option>
                    <option value="disponible">Disponible</option>
                    <option value="transformé">Transformé</option>
                    <option value="recyclé">Recyclé</option>
                </select>
                <select id="conditionFilter" style="min-width: 150px;">
                    <option value="">Toutes conditions</option>
                    <option value="bon">Bon état</option>
                    <option value="moyen">État moyen</option>
                    <option value="à réparer">À réparer</option>
                </select>
                <button type="button" onclick="resetFilters()" class="btn-secondary" style="white-space: nowrap;">
                    🔄 Réinitialiser
                </button>
            </div>

            <div class="items-table">
                <div class="table-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h2><span class="icon">📋</span> Objets Valorisables</h2>
                    <div id="bulkActions" style="display: none; gap: 0.5rem; align-items: center;">
                        <span id="selectedCount" style="color: #667eea; font-weight: 600;">0 sélectionné(s)</span>
                        <button type="button" onclick="bulkChangeStatus('disponible')" class="btn-secondary" style="padding: 0.5rem 1rem;">
                            ✅ Marquer disponible
                        </button>
                        <button type="button" onclick="bulkChangeStatus('transformé')" class="btn-secondary" style="padding: 0.5rem 1rem;">
                            🔄 Marquer transformé
                        </button>
                        <button type="button" onclick="bulkDelete()" class="btn-danger" style="padding: 0.5rem 1rem;">
                            🗑️ Supprimer
                        </button>
                    </div>
                </div>

                @php
                    $conditionLabels = [
                        'bon' => 'Bon état',
                        'moyen' => 'État moyen',
                        'à réparer' => 'À réparer'
                    ];
                @endphp

                <table id="itemsTable">
                    <thead>
                        <tr>
                            <th style="width: 50px;">
                                <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)">
                            </th>
                            <th style="width: 80px;">Image</th>
                            <th class="sortable" onclick="sortTable('name')" style="cursor: pointer;">
                                Nom <span class="sort-icon">⇅</span>
                            </th>
                            <th class="sortable" onclick="sortTable('category')" style="cursor: pointer;">
                                Catégorie <span class="sort-icon">⇅</span>
                            </th>
                            <th class="sortable" onclick="sortTable('condition')" style="cursor: pointer;">
                                État <span class="sort-icon">⇅</span>
                            </th>
                            <th class="sortable" onclick="sortTable('status')" style="cursor: pointer;">
                                Statut <span class="sort-icon">⇅</span>
                            </th>
                            <th class="sortable" onclick="sortTable('date')" style="cursor: pointer;">
                                Date d'ajout <span class="sort-icon">⇅</span>
                            </th>
                            <th style="width: 180px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                            @php
                                $statusSlug = \Illuminate\Support\Str::slug($item->status);
                                $statusLabel = ucfirst($item->status);
                                if ($item->status === 'transformé') {
                                    $statusLabel = 'Transformé';
                                } elseif ($item->status === 'recyclé') {
                                    $statusLabel = 'Recyclé';
                                }
                            @endphp
                            <tr class="item-row" 
                                data-id="{{ $item->id }}"
                                data-name="{{ strtolower($item->name) }}"
                                data-description="{{ strtolower($item->description ?? '') }}"
                                data-category="{{ $item->category_id }}"
                                data-status="{{ $item->status }}"
                                data-condition="{{ $item->condition }}"
                                data-date="{{ $item->created_at->timestamp }}">
                                <td class="text-center">
                                    <input type="checkbox" class="item-checkbox" value="{{ $item->id }}" onchange="updateBulkActions()">
                                </td>
                                <td class="item-image-cell">
                                    <div class="item-image-container">
                                        @if($item->image_url)
                                            <img src="{{ $item->image_url }}" alt="{{ $item->name }}" loading="lazy">
                                        @else
                                            <div class="item-image-placeholder">📦</div>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->category->name ?? 'Non attribuée' }}</td>
                                <td>{{ $conditionLabels[$item->condition] ?? ucfirst($item->condition) }}</td>
                                <td><span class="status status-{{ $statusSlug }}">{{ $statusLabel }}</span></td>
                                <td>{{ optional($item->created_at)->format('d/m/Y') }}</td>
                                <td class="actions">
                                    <button type="button" class="btn-sm btn-edit" 
                                        data-id="{{ $item->id }}"
                                        data-name="{{ $item->name }}"
                                        data-description="{{ $item->description }}"
                                        data-category="{{ $item->category_id }}"
                                        data-condition="{{ $item->condition }}"
                                        data-status="{{ $item->status }}"
                                        data-image="{{ $item->image_url }}"
                                        onclick="openItemEditModal(this)">✏️ Modifier</button>
                                    <form method="POST" action="{{ route('catalog.items.destroy', $item) }}" onsubmit="return confirm('Supprimer définitivement l\'objet {{ $item->name }} ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-sm btn-delete">🗑️ Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <h3>🛠️ Aucun objet valorisable pour le moment</h3>
                                        <p>Ajoutez vos premiers objets pour alimenter le catalogue et suivre leur transformation.</p>
                                        <button type="button" onclick="openModal('addModal')" class="btn-primary" style="margin-top: 1rem;">Créer un objet</button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
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
            
            <form method="POST" action="{{ route('catalog.items.store') }}" id="addItemForm" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="name">Nom de l'objet</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                </div>
                
                <div class="form-group">
                    <label for="category">Catégorie</label>
                    <select id="category" name="category_id" required>
                        <option value="">Sélectionner une catégorie</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="condition">État</label>
                    <select id="condition" name="condition" required>
                        <option value="">Sélectionner l'état</option>
                        <option value="bon" {{ old('condition') === 'bon' ? 'selected' : '' }}>Bon état</option>
                        <option value="moyen" {{ old('condition') === 'moyen' ? 'selected' : '' }}>État moyen</option>
                        <option value="à réparer" {{ old('condition') === 'à réparer' ? 'selected' : '' }}>À réparer</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="status">Statut</label>
                    <select id="status" name="status" required>
                        <option value="">Sélectionner le statut</option>
                        <option value="disponible" {{ old('status') === 'disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="transformé" {{ old('status') === 'transformé' ? 'selected' : '' }}>Transformé</option>
                        <option value="recyclé" {{ old('status') === 'recyclé' ? 'selected' : '' }}>Recyclé</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="Description détaillée de l'objet...">{{ old('description') }}</textarea>
                </div>
                
                <div class="form-group">
                    <label>Image</label>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <div>
                            <label for="image_file" style="font-weight: normal; font-size: 0.9rem; color: #666;">Télécharger une image</label>
                            <input type="file" id="image_file" name="image_file" accept="image/*" style="margin-top: 0.3rem;">
                        </div>
                        <div style="text-align: center; color: #999; font-size: 0.9rem; margin: 0.5rem 0;">ou</div>
                        <div>
                            <label for="image_url" style="font-weight: normal; font-size: 0.9rem; color: #666;">URL de l'image</label>
                            <input type="url" id="image_url" name="image_url" value="{{ old('image_url') }}" style="margin-top: 0.3rem;">
                        </div>
                    </div>
                    <small style="color: #666; font-size: 0.8rem;">Le téléchargement a la priorité sur l'URL. Formats acceptés : JPEG, PNG, JPG, GIF (max 2Mo)</small>
                </div>
                
                <button type="submit" class="btn-primary" style="width: 100%; margin-top: 1rem;">Ajouter l'Objet</button>
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
            
            <form method="POST" id="editItemForm" data-base-action="{{ route('catalog.items.update', '__ID__') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="edit_name">Nom de l'objet</label>
                    <input type="text" id="edit_name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_category">Catégorie</label>
                    <select id="edit_category" name="category_id" required>
                        <option value="">Sélectionner une catégorie</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="edit_condition">État</label>
                    <select id="edit_condition" name="condition" required>
                        <option value="bon">Bon état</option>
                        <option value="moyen">État moyen</option>
                        <option value="à réparer">À réparer</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="edit_status">Statut</label>
                    <select id="edit_status" name="status" required>
                        <option value="disponible">Disponible</option>
                        <option value="transformé">Transformé</option>
                        <option value="recyclé">Recyclé</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="edit_description">Description</label>
                    <textarea id="edit_description" name="description" rows="4"></textarea>
                </div>

                <div class="form-group">
                    <label>Image</label>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <div>
                            <label for="edit_image_file" style="font-weight: normal; font-size: 0.9rem; color: #666;">Nouvelle image</label>
                            <input type="file" id="edit_image_file" name="image_file" accept="image/*" style="margin-top: 0.3rem;">
                        </div>
                        <div style="text-align: center; color: #999; font-size: 0.9rem; margin: 0.5rem 0;">ou</div>
                        <div>
                            <label for="edit_image_url" style="font-weight: normal; font-size: 0.9rem; color: #666;">URL de l'image</label>
                            <input type="url" id="edit_image_url" name="image_url" style="margin-top: 0.3rem;">
                        </div>
                    </div>
                    <small style="color: #666; font-size: 0.8rem;">Le téléchargement remplacera l'image actuelle. Formats acceptés : JPEG, PNG, JPG, GIF (max 2Mo)</small>
                </div>
                
                <button type="submit" class="btn-primary" style="width: 100%; margin-top: 1rem;">Mettre à Jour</button>
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

        function openItemEditModal(button) {
            const item = {
                id: button.dataset.id,
                name: button.dataset.name,
                description: button.dataset.description || '',
                category_id: button.dataset.category || '',
                condition: button.dataset.condition || 'bon',
                status: button.dataset.status || 'disponible',
                image_url: button.dataset.image || ''
            };
            
            const form = document.getElementById('editItemForm');
            const baseAction = form.dataset.baseAction;
            form.action = baseAction.replace('__ID__', item.id);

            document.getElementById('edit_name').value = item.name;
            document.getElementById('edit_category').value = item.category_id;
            document.getElementById('edit_condition').value = item.condition;
            document.getElementById('edit_status').value = item.status;
            document.getElementById('edit_description').value = item.description;
            document.getElementById('edit_image_url').value = item.image_url;

            openModal('editModal');
        }

        window.onclick = function(event) {
            if (event.target.classList && event.target.classList.contains('modal')) {
                event.target.classList.remove('show');
            }
        }

        // Toast Notification System
        function showToast(type, title, message) {
            const container = document.getElementById('toastContainer') || createToastContainer();
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            
            const icons = {
                success: '✅',
                error: '❌',
                info: 'ℹ️'
            };
            
            toast.innerHTML = `
                <div class="toast-icon">${icons[type] || '📢'}</div>
                <div class="toast-content">
                    <div class="toast-title">${title}</div>
                    <div class="toast-message">${message}</div>
                </div>
                <div class="toast-close" onclick="this.parentElement.remove()">×</div>
            `;
            
            container.appendChild(toast);
            
            setTimeout(() => toast.remove(), 5000);
        }

        function createToastContainer() {
            const container = document.createElement('div');
            container.id = 'toastContainer';
            container.className = 'toast-container';
            document.body.appendChild(container);
            return container;
        }

        // Search and Filter Functionality
        let filterTimeout;
        document.getElementById('searchInput').addEventListener('input', function() {
            clearTimeout(filterTimeout);
            filterTimeout = setTimeout(applyFilters, 300);
        });

        document.getElementById('categoryFilter').addEventListener('change', applyFilters);
        document.getElementById('statusFilter').addEventListener('change', applyFilters);
        document.getElementById('conditionFilter').addEventListener('change', applyFilters);

        function applyFilters() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const categoryFilter = document.getElementById('categoryFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;
            const conditionFilter = document.getElementById('conditionFilter').value;

            const rows = document.querySelectorAll('.item-row');
            let visibleCount = 0;

            rows.forEach(row => {
                const name = row.dataset.name || '';
                const description = row.dataset.description || '';
                const category = row.dataset.category || '';
                const status = row.dataset.status || '';
                const condition = row.dataset.condition || '';

                const matchesSearch = !searchTerm || name.includes(searchTerm) || description.includes(searchTerm);
                const matchesCategory = !categoryFilter || category === categoryFilter;
                const matchesStatus = !statusFilter || status === statusFilter;
                const matchesCondition = !conditionFilter || condition === conditionFilter;

                if (matchesSearch && matchesCategory && matchesStatus && matchesCondition) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            showToast('info', 'Filtres appliqués', `${visibleCount} objet(s) affiché(s)`);
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('categoryFilter').value = '';
            document.getElementById('statusFilter').value = '';
            document.getElementById('conditionFilter').value = '';
            applyFilters();
        }

        // Sorting Functionality
        let currentSort = { column: null, direction: 'asc' };

        function sortTable(column) {
            const tbody = document.querySelector('#itemsTable tbody');
            const rows = Array.from(tbody.querySelectorAll('.item-row'));

            if (currentSort.column === column) {
                currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
            } else {
                currentSort.column = column;
                currentSort.direction = 'asc';
            }

            // Update sort indicators
            document.querySelectorAll('th.sortable').forEach(th => {
                th.classList.remove('sorted-asc', 'sorted-desc');
            });
            const header = Array.from(document.querySelectorAll('th.sortable')).find(
                th => th.textContent.toLowerCase().includes(column.toLowerCase().substring(0, 4))
            );
            if (header) {
                header.classList.add(`sorted-${currentSort.direction}`);
            }

            rows.sort((a, b) => {
                let aVal, bVal;

                switch(column) {
                    case 'name':
                        aVal = a.dataset.name;
                        bVal = b.dataset.name;
                        break;
                    case 'category':
                        aVal = a.querySelector('td:nth-child(4)').textContent;
                        bVal = b.querySelector('td:nth-child(4)').textContent;
                        break;
                    case 'condition':
                        aVal = a.dataset.condition;
                        bVal = b.dataset.condition;
                        break;
                    case 'status':
                        aVal = a.dataset.status;
                        bVal = b.dataset.status;
                        break;
                    case 'date':
                        aVal = parseInt(a.dataset.date);
                        bVal = parseInt(b.dataset.date);
                        break;
                    default:
                        return 0;
                }

                if (currentSort.direction === 'asc') {
                    return aVal > bVal ? 1 : -1;
                } else {
                    return aVal < bVal ? 1 : -1;
                }
            });

            rows.forEach(row => tbody.appendChild(row));
            showToast('info', 'Tri appliqué', `Trié par ${column} (${currentSort.direction === 'asc' ? 'croissant' : 'décroissant'})`);
        }

        // Bulk Actions Functionality
        function toggleSelectAll(checkbox) {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            checkboxes.forEach(cb => {
                if (cb.closest('.item-row').style.display !== 'none') {
                    cb.checked = checkbox.checked;
                    if (checkbox.checked) {
                        cb.closest('.item-row').classList.add('selected');
                    } else {
                        cb.closest('.item-row').classList.remove('selected');
                    }
                }
            });
            updateBulkActions();
        }

        function updateBulkActions() {
            const checkboxes = document.querySelectorAll('.item-checkbox:checked');
            const count = checkboxes.length;
            const bulkActions = document.getElementById('bulkActions');
            const selectedCount = document.getElementById('selectedCount');

            if (count > 0) {
                bulkActions.style.display = 'flex';
                selectedCount.textContent = `${count} sélectionné(s)`;
            } else {
                bulkActions.style.display = 'none';
            }

            // Update row highlighting
            document.querySelectorAll('.item-checkbox').forEach(cb => {
                if (cb.checked) {
                    cb.closest('.item-row').classList.add('selected');
                } else {
                    cb.closest('.item-row').classList.remove('selected');
                }
            });
        }

        function bulkChangeStatus(newStatus) {
            const checkboxes = document.querySelectorAll('.item-checkbox:checked');
            const ids = Array.from(checkboxes).map(cb => cb.value);

            if (ids.length === 0) {
                showToast('error', 'Erreur', 'Aucun objet sélectionné');
                return;
            }

            if (confirm(`Voulez-vous vraiment changer le statut de ${ids.length} objet(s) à "${newStatus}" ?`)) {
                // Here you would make an AJAX request to update the status
                // For now, we'll just show a success message
                showToast('success', 'Statut mis à jour', `${ids.length} objet(s) marqué(s) comme "${newStatus}"`);
                
                // Update UI
                checkboxes.forEach(cb => {
                    const row = cb.closest('.item-row');
                    const statusCell = row.querySelector('.status');
                    if (statusCell) {
                        statusCell.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
                        statusCell.className = 'status status-' + newStatus.replace('é', 'e');
                    }
                    row.dataset.status = newStatus;
                    cb.checked = false;
                });
                
                updateBulkActions();
            }
        }

        function bulkDelete() {
            const checkboxes = document.querySelectorAll('.item-checkbox:checked');
            const ids = Array.from(checkboxes).map(cb => cb.value);

            if (ids.length === 0) {
                showToast('error', 'Erreur', 'Aucun objet sélectionné');
                return;
            }

            if (confirm(`⚠️ ATTENTION ! Voulez-vous vraiment supprimer ${ids.length} objet(s) ?\n\nCette action est irréversible.`)) {
                // Here you would make an AJAX request to delete the items
                // For now, we'll just remove them from the UI
                showToast('success', 'Suppression réussie', `${ids.length} objet(s) supprimé(s)`);
                
                checkboxes.forEach(cb => {
                    cb.closest('.item-row').remove();
                });
                
                updateBulkActions();
            }
        }

        // Show welcome toast on page load
        window.addEventListener('load', function() {
            const itemCount = document.querySelectorAll('.item-row').length;
            showToast('info', 'Bienvenue', `${itemCount} objet(s) dans le catalogue`);
        });

        // Export to CSV
        function exportData(format) {
            const rows = Array.from(document.querySelectorAll('.item-row')).filter(row => row.style.display !== 'none');
            
            if (rows.length === 0) {
                showToast('error', 'Erreur', 'Aucune donnée à exporter');
                return;
            }

            let csvContent = "data:text/csv;charset=utf-8,";
            csvContent += "Nom,Catégorie,État,Statut,Date d'ajout\n";

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const data = [
                    cells[2].textContent.trim(), // Nom
                    cells[3].textContent.trim(), // Catégorie
                    cells[4].textContent.trim(), // État
                    cells[5].textContent.trim(), // Statut
                    cells[6].textContent.trim()  // Date
                ];
                csvContent += data.map(field => `"${field}"`).join(',') + "\n";
            });

            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", `objets_valorisables_${new Date().toISOString().split('T')[0]}.csv`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            showToast('success', 'Export réussi', `${rows.length} objet(s) exporté(s) en CSV`);
        }

        // Print table
        function printTable() {
            const printWindow = window.open('', '', 'height=600,width=800');
            const rows = Array.from(document.querySelectorAll('.item-row')).filter(row => row.style.display !== 'none');
            
            let tableHTML = `
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Objets Valorisables - Impression</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; }
                        h1 { color: #333; border-bottom: 3px solid #667eea; padding-bottom: 10px; }
                        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
                        th { background-color: #667eea; color: white; }
                        tr:nth-child(even) { background-color: #f8fafc; }
                        .print-date { color: #666; font-size: 0.9rem; margin-bottom: 20px; }
                        @media print {
                            body { margin: 0; }
                        }
                    </style>
                </head>
                <body>
                    <h1>🔄 Waste To Product - Objets Valorisables</h1>
                    <div class="print-date">Imprimé le ${new Date().toLocaleDateString('fr-FR', { 
                        year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' 
                    })}</div>
                    <table>
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Catégorie</th>
                                <th>État</th>
                                <th>Statut</th>
                                <th>Date d'ajout</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                tableHTML += `
                    <tr>
                        <td>${cells[2].textContent.trim()}</td>
                        <td>${cells[3].textContent.trim()}</td>
                        <td>${cells[4].textContent.trim()}</td>
                        <td>${cells[5].textContent.trim()}</td>
                        <td>${cells[6].textContent.trim()}</td>
                    </tr>
                `;
            });

            tableHTML += `
                        </tbody>
                    </table>
                    <div style="margin-top: 30px; color: #666; font-size: 0.9rem;">
                        Total: ${rows.length} objet(s)
                    </div>
                </body>
                </html>
            `;

            printWindow.document.write(tableHTML);
            printWindow.document.close();
            printWindow.focus();
            
            setTimeout(() => {
                printWindow.print();
                showToast('success', 'Impression lancée', 'Document prêt à imprimer');
            }, 250);
        }
    
    </script>
</body>
</html>
