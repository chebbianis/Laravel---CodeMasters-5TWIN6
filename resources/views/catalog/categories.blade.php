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
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
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
            display: flex;
            flex-direction: column;
            justify-content: space-between;
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
            font-weight: 600;
            color: #1f2937;
        }

        .category-info h3 {
            color: #333;
            margin-bottom: 0.2rem;
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
            flex-wrap: wrap;
        }

        .category-actions form {
            margin: 0;
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
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

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-weight: 500;
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

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .color-picker {
            display: grid;
            grid-template-columns: repeat(6, 40px);
            gap: 0.5rem;
            margin-bottom: 0.8rem;
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

        .color-input-wrapper {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .color-input-wrapper input[type="color"] {
            width: 60px;
            height: 40px;
            border: none;
            padding: 0;
            background: transparent;
            cursor: pointer;
        }

        .empty-state {
            background: white;
            border-radius: 15px;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            color: #555;
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
            <li><a href="{{ route('catalog.items') }}"><span class="icon">🛠️</span> Objets</a></li>
            <li><a class="active" href="{{ route('catalog.categories') }}"><span class="icon">🏷️</span> Catégories</a></li>
            <li><a href="{{ route('partners.index') }}"><span class="icon">🤝</span> Partenaires</a></li>
            <li><a href="{{ route('collection.index') }}"><span class="icon">📍</span> Points de Collecte</a></li>
            <li><a href="{{ route('events.index') }}"><span class="icon">🎪</span> Événements</a></li>
        </ul>
    </aside>

    <main class="main-content">
        <header class="header">
            <div>
                <h1>Gestion des Catégories</h1>
                <div class="breadcrumb">
                    <a href="{{ route('dashboard') }}">Dashboard</a> / 
                    <a href="{{ route('catalog.index') }}">Catalogue</a> / Catégories
                </div>
            </div>
        </header>

        <div class="content">
            @if (session('success'))
                <div class="alert alert-success">✅ {{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-error">⚠️ {{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    ⚠️ Merci de corriger les erreurs suivantes :
                    <ul style="margin-left: 1.5rem; margin-top: 0.5rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="page-actions">
                <div>
                    <h2>Catégories d'Objets</h2>
                    <p style="color: #6b7280;">{{ $categories->count() }} catégorie(s) enregistrée(s)</p>
                </div>
                <button type="button" onclick="openModal('addModal')" class="btn-primary">+ Ajouter une Catégorie</button>
            </div>

            <div class="categories-grid">
                @forelse ($categories as $category)
                    <div class="category-card">
                        <div>
                            <div class="category-header">
                                <div class="category-icon" style="background: {{ $category->color_code }}33;">
                                    {{ mb_strtoupper(mb_substr($category->name, 0, 1)) }}
                                </div>
                                <div class="category-info">
                                    <h3>{{ $category->name }}</h3>
                                    <div class="category-stats">{{ $category->items_count }} objet(s)</div>
                                </div>
                            </div>
                            <p class="category-description">
                                {{ $category->description ? 
                                    \Illuminate\Support\Str::limit($category->description, 140) : 
                                    'Aucune description fournie pour cette catégorie.' }}
                            </p>
                        </div>
                        <div class="category-actions">
                            <a class="btn-sm btn-view" href="{{ route('catalog.items') }}?category={{ $category->id }}">👁️ Voir les objets</a>
                            <button type="button" class="btn-sm btn-edit"
                                data-id="{{ $category->id }}"
                                data-name="{{ $category->name }}"
                                data-description="{{ $category->description }}"
                                data-color="{{ $category->color_code }}"
                                onclick="openEditModal(this)">✏️ Modifier</button>
                            <form method="POST" action="{{ route('catalog.categories.destroy', $category) }}" onsubmit="return confirm('Supprimer définitivement la catégorie {{ $category->name }} ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm btn-delete">🗑️ Supprimer</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <h3>🗂️ Aucune catégorie pour le moment</h3>
                        <p>Ajoutez votre première catégorie afin d’organiser les objets valorisables du catalogue.</p>
                        <button type="button" onclick="openModal('addModal')" class="btn-primary" style="margin-top: 1.5rem;">Créer une catégorie</button>
                    </div>
                @endforelse
            </div>
        </div>
    </main>

    @php
        $colorPalette = [
            '#e3f2fd', '#f3e5f5', '#e8f5e9', '#fff3e0', '#e1f5fe', '#f1f8e9',
            '#fef9c3', '#fee2e2', '#e0f2fe', '#ede9fe', '#d1fae5', '#f5f5f5'
        ];
    @endphp

    <!-- Modal Ajouter Catégorie -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close-btn" onclick="closeModal('addModal')">&times;</span>
                <h3>Ajouter une Nouvelle Catégorie</h3>
            </div>
            
            <form method="POST" action="{{ route('catalog.categories.store') }}" id="addCategoryForm">
                @csrf

                <div class="form-group">
                    <label for="category_name">Nom de la catégorie</label>
                    <input type="text" id="category_name" name="name" value="{{ old('name') }}" required>
                </div>
                
                <div class="form-group">
                    <label for="category_description">Description</label>
                    <textarea id="category_description" name="description" rows="3" placeholder="Description de la catégorie...">{{ old('description') }}</textarea>
                </div>
                
                <div class="form-group">
                    <label>Couleur de la catégorie</label>
                    <div class="color-picker" data-target="add_color_code">
                        @foreach ($colorPalette as $color)
                            <button type="button" class="color-option{{ old('color_code', '#667eea') === $color ? ' selected' : '' }}" style="background: {{ $color }};" data-color="{{ $color }}" onclick="selectColor(this, 'add_color_code')"></button>
                        @endforeach
                    </div>
                    <div class="color-input-wrapper">
                        <input type="color" value="{{ old('color_code', '#667eea') }}" onchange="setCustomColor(this.value, 'add_color_code')">
                        <span id="add_color_preview" style="display:inline-block; padding:0.4rem 0.8rem; border-radius:6px; background: {{ old('color_code', '#667eea') }}; color:#fff;">{{ old('color_code', '#667eea') }}</span>
                    </div>
                    <input type="hidden" name="color_code" id="add_color_code" value="{{ old('color_code', '#667eea') }}">
                </div>
                
                <button type="submit" class="btn-primary" style="width: 100%; margin-top: 1rem;">Créer la Catégorie</button>
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
            
            <form method="POST" id="editCategoryForm" data-base-action="{{ route('catalog.categories.update', '__ID__') }}">
                @csrf
                @method('PUT')

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
                    <div class="color-picker" data-target="edit_color_code">
                        @foreach ($colorPalette as $color)
                            <button type="button" class="color-option" style="background: {{ $color }};" data-color="{{ $color }}" onclick="selectColor(this, 'edit_color_code')"></button>
                        @endforeach
                    </div>
                    <div class="color-input-wrapper">
                        <input type="color" value="#667eea" onchange="setCustomColor(this.value, 'edit_color_code')" id="edit_color_input">
                        <span id="edit_color_preview" style="display:inline-block; padding:0.4rem 0.8rem; border-radius:6px; background:#667eea; color:#fff;">#667eea</span>
                    </div>
                    <input type="hidden" name="color_code" id="edit_color_code" value="#667eea">
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

        function selectColor(element, inputId) {
            const color = element.getAttribute('data-color');
            const picker = element.parentElement;
            picker.querySelectorAll('.color-option').forEach(option => option.classList.remove('selected'));
            element.classList.add('selected');
            document.getElementById(inputId).value = color;
            updateColorPreview(inputId, color);
            const colorInput = picker.parentElement.querySelector('input[type="color"]');
            if (colorInput) {
                colorInput.value = color;
            }
        }

        function setCustomColor(color, inputId) {
            document.getElementById(inputId).value = color;
            updateColorPreview(inputId, color);
            const picker = document.querySelector(`[data-target="${inputId}"]`);
            if (picker) {
                picker.querySelectorAll('.color-option').forEach(option => option.classList.remove('selected'));
            }
        }

        function updateColorPreview(inputId, color) {
            const previewId = inputId === 'add_color_code' ? 'add_color_preview' : 'edit_color_preview';
            const preview = document.getElementById(previewId);
            if (preview) {
                preview.style.background = color;
                preview.textContent = color;
            }
        }

        function openEditModal(button) {
            const category = {
                id: button.dataset.id,
                name: button.dataset.name,
                description: button.dataset.description || '',
                color_code: button.dataset.color || '#667eea'
            };
            const form = document.getElementById('editCategoryForm');
            const baseAction = form.dataset.baseAction;
            form.action = baseAction.replace('__ID__', category.id);

            document.getElementById('edit_category_name').value = category.name;
            document.getElementById('edit_category_description').value = category.description ?? '';
            document.getElementById('edit_color_code').value = category.color_code;
            document.getElementById('edit_color_input').value = category.color_code;
            updateColorPreview('edit_color_code', category.color_code);

            const picker = document.querySelector('[data-target="edit_color_code"]');
            if (picker) {
                picker.querySelectorAll('.color-option').forEach(option => {
                    if (option.dataset.color === category.color_code) {
                        option.classList.add('selected');
                    } else {
                        option.classList.remove('selected');
                    }
                });
            }

            openModal('editModal');
        }

        window.onclick = function(event) {
            if (event.target.classList && event.target.classList.contains('modal')) {
                event.target.classList.remove('show');
            }
        }
    </script>
</body>
</html>
