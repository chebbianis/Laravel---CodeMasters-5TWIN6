<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion des Catégories - Waste To Product</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        /* === Global Styles === */
        body {
            font-family: 'Inter', sans-serif;
            background: #f4f6f9;
            margin: 0;
            color: #333;
        }

        a { text-decoration: none; color: inherit; }

        /* === Sidebar === */
        .sidebar {
            position: fixed;
            left: 0; top: 0;
            width: 250px; height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff; padding: 2rem 0; overflow-y: auto;
        }
        .sidebar .logo {
            text-align: center; margin-bottom: 2rem; font-size: 1.5rem; font-weight: 600;
        }
        .nav-menu { list-style: none; padding-left: 0; }
        .nav-menu a { display: flex; align-items: center; padding: 1rem 1.5rem; transition: 0.3s; }
        .nav-menu a:hover { background: rgba(255,255,255,0.1); }
        .nav-menu .icon { margin-right: 1rem; }

        /* === Main Content === */
        .main-content { margin-left: 250px; min-height: 100vh; }
        .header {
            background: #fff; padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .breadcrumb a { color: #667eea; margin-right: 0.3rem; }

        .content { padding: 2rem; }

        .page-actions {
            display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;
            flex-wrap: wrap; gap: 1rem;
        }
        .btn-primary {
            padding: 0.8rem 1.8rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white; border-radius: 10px; border: none; cursor: pointer;
            transition: all 0.3s;
        }
        .btn-primary:hover { opacity: 0.9; }

        /* === Categories Grid === */
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.8rem;
        }

        /* === Category Card === */
        .category-card {
            background: #fff; border-radius: 20px; padding: 1.8rem 1.5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            display: flex; flex-direction: column; justify-content: space-between;
            border-left: 5px solid #667eea;
            position: relative;
        }
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.15);
        }

        .category-header { display: flex; align-items: center; margin-bottom: 1rem; }
        .category-icon {
            width: 60px; height: 60px; border-radius: 50%;
            display: flex; justify-content: center; align-items: center;
            font-size: 1.8rem; margin-right: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .category-info h3 { font-weight: 600; font-size: 1.2rem; margin-bottom: 0.3rem; }
        .category-stats { font-size: 0.9rem; color: #777; }
        .category-description { font-size: 0.95rem; color: #555; line-height: 1.5; margin-bottom: 1rem; }

        .category-actions { display: flex; gap: 0.6rem; flex-wrap: wrap; }
        .btn-sm { padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.85rem; cursor: pointer; border: none; }
        .btn-view { background: #1d72b8; color: #fff; } .btn-view:hover { background: #155d8b; }
        .btn-edit { background: #fbbc04; color: #212529; } .btn-edit:hover { background: #e0a800; }
        .btn-delete { background: #e53935; color: #fff; } .btn-delete:hover { background: #b71c1c; }

        /* === Modals === */
        .modal {
            display: none; position: fixed; top:0; left:0; width:100%; height:100%;
            background: rgba(0,0,0,0.5); z-index:1000; justify-content:center; align-items:center;
        }
        .modal.show { display: flex; }
        .modal-content {
            background: #fff; padding:2rem; border-radius:15px; width:90%; max-width:500px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        .modal-header { margin-bottom:1.5rem; }
        .close-btn { float:right; font-size:1.5rem; cursor:pointer; color:#999; }

        .form-group { margin-bottom:1rem; }
        .form-group label { display:block; margin-bottom:0.5rem; color:#555; font-weight:500; }
        .form-group input, .form-group textarea {
            width:100%; padding:0.8rem; border:2px solid #e2e8f0; border-radius:8px; font-size:1rem;
        }

        .color-picker {
            display:grid; grid-template-columns:repeat(6,1fr); gap:0.5rem; margin-top:0.5rem;
        }
        .color-option { width:40px; height:40px; border-radius:50%; cursor:pointer; border:3px solid transparent; transition:0.3s; }
        .color-option.selected { border-color:#333; }

        @media (max-width:768px){
            .sidebar { transform: translateX(-100%); }
            .main-content { margin-left:0; }
            .categories-grid { grid-template-columns:1fr; }
        }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="logo">🔄 Waste To Product</div>
    <ul class="nav-menu">
        <li><a href="{{ route('dashboard') }}"><span class="icon">🏠</span> Dashboard</a></li>
        <li><a href="{{ route('catalog.index') }}"><span class="icon">📦</span> Catalogue</a></li>
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
            @foreach($categories as $category)
            <div class="category-card">
                <div class="category-header">
                    <div class="category-icon" style="background: '{{ $category->color_code ?? '#e2e8f0' }}';">
                        {{ $category->icon ?? '📦' }}
                    </div>
                    <div class="category-info">
                        <h3>{{ $category->name }}</h3>
                        <div class="category-stats">{{ $category->items->count() }} objets</div>
                    </div>
                </div>
                <p class="category-description">{{ $category->description }}</p>
                <div class="category-actions">
                    <a href="{{ route('categories.items', $category->id) }}" class="btn-sm btn-view">👁️ Voir</a>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Voulez-vous vraiment supprimer cette catégorie ?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn-sm btn-delete">🗑️ Supprimer</button>
</form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</main>

<!-- === Modals === -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="close-btn" onclick="closeModal('addModal')">&times;</span>
            <h3>Ajouter une Nouvelle Catégorie</h3>
        </div>
     <form action="{{ route('categories.store') }}" method="POST">
    @csrf

    <!-- Nom -->
    <div class="form-group">
        <label for="name">Nom de la catégorie</label>
        <input type="text" id="name" name="name" placeholder="Nom" required
            style="width:100%; padding:0.8rem; border:2px solid #e2e8f0; border-radius:8px;">
    </div>

    <!-- Description -->
    <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description" placeholder="Description" rows="4"
            style="width:100%; padding:0.8rem; border:2px solid #e2e8f0; border-radius:8px;"></textarea>
    </div>

    <!-- Couleur -->
    <div class="form-group">
        <label>Couleur</label>
        <input type="hidden" name="color_code" id="selectedColor" value="#667eea" required>
        <div class="color-picker" style="display:flex; gap:0.5rem; margin-top:0.5rem;">
            @foreach(['#e3f2fd','#f3e5f5','#e8f5e8','#fff3e0','#e1f5fe','#f1f8e9','#667eea','#764ba2'] as $color)
                <div class="color-option"
                     style="background: '{{ $color }}'; width:30px; height:30px; border-radius:50%; cursor:pointer; border:2px solid #ccc;"
                     onclick="selectColor(this, '{{ $color }}')"></div>
            @endforeach
        </div>
    </div>

    <button type="submit" style="padding:0.8rem 2rem; background:#667eea; color:#fff; border:none; border-radius:10px; cursor:pointer;">
        Créer
    </button>
</form>

    </div>
</div>

<div id="editModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="close-btn" onclick="closeModal('editModal')">&times;</span>
            <h3>Modifier la Catégorie</h3>
        </div>
        <form method="POST" id="editForm">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Nom de la catégorie</label>
                <input type="text" name="name" id="edit_category_name" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" id="edit_category_description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label>Couleur</label>
                <div class="color-picker">
                    @foreach(['#e3f2fd','#f3e5f5','#e8f5e8','#fff3e0','#e1f5fe','#f1f8e9'] as $color)
                        <div class="color-option" style="background: '{ $color }}';" onclick="selectColor(this)"></div>
                    @endforeach
                </div>
                <input type="hidden" name="color_code" id="editSelectedColor">
            </div>
            <button type="submit" class="btn-primary">Mettre à jour</button>
        </form>
    </div>
</div>

<script>

    function openModal(id){ document.getElementById(id).classList.add('show'); }
    function closeModal(id){ document.getElementById(id).classList.remove('show'); }

    function selectColor(el){
        const parent = el.parentElement;
        parent.querySelectorAll('.color-option').forEach(opt => opt.classList.remove('selected'));
        el.classList.add('selected');
        const hiddenInput = parent.parentElement.querySelector('input[type=hidden]');
        hiddenInput.value = el.style.background;
    }

    function openEditModal(categoryId){
        const cat = categories[categoryId];
        if(cat){
            document.getElementById('edit_category_name').value = cat.name;
            document.getElementById('edit_category_description').value = cat.description;
            document.getElementById('editSelectedColor').value = cat.color_code;
            document.getElementById('editForm').action = `/categories/${cat.id}`;
            openModal('editModal');
        }
    }

    window.onclick = function(event){
        if(event.target.classList.contains('modal')){
            event.target.classList.remove('show');
        }

    }
    function selectColor(el, color) {
    document.querySelectorAll('.color-option').forEach(div => div.style.borderColor = '#ccc');
    el.style.borderColor = '#333';
    document.getElementById('selectedColor').value = color;
}
</script>

</body>
</html>
