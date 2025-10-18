<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Catalogue des Objets - Waste To Product</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        header {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: white;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .nav-links a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .main-content {
            padding-top: 120px;
            padding-bottom: 2rem;
        }

        .page-header {
            text-align: center;
            color: white;
            margin-bottom: 3rem;
        }

        .page-header h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .page-header p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto;
        }

        .catalog-section {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 3rem 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .stat-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 15px;
            text-align: center;
        }

        .stat-box .number {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .stat-box .label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .filters-section {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .search-input {
            flex: 1;
            min-width: 250px;
            padding: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 1rem;
        }

        .filter-select {
            padding: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 1rem;
            background: white;
            min-width: 200px;
        }

        .items-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2rem;
        }

        .item-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: all 0.3s;
            border: 1px solid #e2e8f0;
        }

        .item-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }

        .item-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: #667eea;
        }

        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .item-content {
            padding: 1.5rem;
        }

        .item-header {
            margin-bottom: 1rem;
        }

        .item-title {
            font-size: 1.3rem;
            color: #333;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .item-category {
            display: inline-block;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .item-description {
            color: #666;
            margin-bottom: 1rem;
            line-height: 1.5;
            min-height: 60px;
        }

        .item-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
        }

        .item-condition {
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            background: #e2e8f0;
            color: #495057;
        }

        .item-status {
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status-disponible {
            background: #d1fae5;
            color: #047857;
        }

        .status-transforme {
            background: #e0f2fe;
            color: #075985;
        }

        .status-recycle {
            background: #ede9fe;
            color: #5b21b6;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #666;
            grid-column: 1 / -1;
        }

        .empty-state .icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .categories-pills {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .category-pill {
            padding: 0.6rem 1.2rem;
            border-radius: 25px;
            background: white;
            border: 2px solid #e2e8f0;
            color: #667eea;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
        }

        .category-pill:hover,
        .category-pill.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: transparent;
        }

        footer {
            background: rgba(0, 0, 0, 0.8);
            color: white;
            text-align: center;
            padding: 2rem 0;
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2rem;
            }
            
            .catalog-section {
                padding: 2rem 1rem;
            }
            
            .items-grid {
                grid-template-columns: 1fr;
            }
            
            .filters-section {
                flex-direction: column;
            }
            
            .nav-links {
                display: none;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav class="container">
            <a href="{{ route('home') }}" class="logo">🔄 Waste To Product</a>
            <div class="nav-links">
                <a href="{{ route('home') }}">Accueil</a>
                <a href="{{ route('catalog.public') }}">Catalogue</a>
                <a href="{{ route('partners.public') }}">Partenaires</a>
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </div>
        </nav>
    </header>

    <main class="main-content">
        <div class="container">
            <div class="page-header">
                <h1>🛠️ Catalogue des Objets Valorisables</h1>
                <p>Découvrez notre collection d'objets en attente de transformation. Chaque objet a une seconde vie qui l'attend !</p>
            </div>

            <div class="catalog-section">
                <div class="stats-row">
                    <div class="stat-box">
                        <div class="number">{{ $totalItems }}</div>
                        <div class="label">Objets</div>
                    </div>
                    <div class="stat-box">
                        <div class="number">{{ $availableItems }}</div>
                        <div class="label">Disponibles</div>
                    </div>
                    <div class="stat-box">
                        <div class="number">{{ $categories->count() }}</div>
                        <div class="label">Catégories</div>
                    </div>
                    <div class="stat-box">
                        <div class="number">{{ $transformedItems }}</div>
                        <div class="label">Transformés</div>
                    </div>
                </div>

                <div class="categories-pills">
                    <button class="category-pill active" data-category="">Tous les objets</button>
                    @foreach($categories as $category)
                        <button class="category-pill" data-category="{{ $category->id }}" style="border-color: {{ $category->color_code }};">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>

                <div class="filters-section">
                    <input type="text" class="search-input" placeholder="🔍 Rechercher un objet..." id="searchInput">
                    <select class="filter-select" id="statusFilter">
                        <option value="">Tous les statuts</option>
                        <option value="disponible">Disponible</option>
                        <option value="transformé">Transformé</option>
                        <option value="recyclé">Recyclé</option>
                    </select>
                    <select class="filter-select" id="conditionFilter">
                        <option value="">Tous les états</option>
                        <option value="bon">Bon état</option>
                        <option value="moyen">État moyen</option>
                        <option value="à réparer">À réparer</option>
                    </select>
                </div>

                <div class="items-grid" id="itemsGrid">
                    @forelse($items as $item)
                    @php
                        $statusSlug = \Illuminate\Support\Str::slug($item->status);
                        $conditionLabels = [
                            'bon' => 'Bon état',
                            'moyen' => 'État moyen',
                            'à réparer' => 'À réparer'
                        ];
                    @endphp
                    <div class="item-card" 
                         data-category="{{ $item->category_id ?? '' }}" 
                         data-status="{{ $item->status }}" 
                         data-condition="{{ $item->condition }}"
                         data-name="{{ strtolower($item->name) }}">
                        <div class="item-image">
                            @if($item->image_url)
                                <img src="{{ $item->image_url }}" alt="{{ $item->name }}">
                            @else
                                🛠️
                            @endif
                        </div>
                        <div class="item-content">
                            <div class="item-header">
                                <h3 class="item-title">{{ $item->name }}</h3>
                                @if($item->category)
                                    <span class="item-category" style="background: {{ $item->category->color_code }}33; color: {{ $item->category->color_code }};">
                                        {{ $item->category->name }}
                                    </span>
                                @endif
                            </div>
                            <p class="item-description">
                                {{ $item->description ? \Illuminate\Support\Str::limit($item->description, 100) : 'Objet valorisable en attente de transformation.' }}
                            </p>
                            <div class="item-meta">
                                <span class="item-condition">{{ $conditionLabels[$item->condition] ?? ucfirst($item->condition) }}</span>
                                <span class="item-status status-{{ $statusSlug }}">{{ ucfirst($item->status) }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <div class="icon">🛠️</div>
                        <h3>Aucun objet trouvé</h3>
                        <p>Nous travaillons à enrichir notre catalogue d'objets valorisables.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 Waste To Product. Tous droits réservés. 🌱 Pour une économie circulaire durable.</p>
        </div>
    </footer>

    <script>
        // Gestion des filtres et de la recherche
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const conditionFilter = document.getElementById('conditionFilter');
        const itemsGrid = document.getElementById('itemsGrid');
        const itemCards = document.querySelectorAll('.item-card');
        const categoryPills = document.querySelectorAll('.category-pill');
        
        let currentCategory = '';

        // Filtrage par catégorie
        categoryPills.forEach(pill => {
            pill.addEventListener('click', function() {
                categoryPills.forEach(p => p.classList.remove('active'));
                this.classList.add('active');
                currentCategory = this.dataset.category;
                filterItems();
            });
        });

        // Fonction de filtrage
        function filterItems() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedStatus = statusFilter.value;
            const selectedCondition = conditionFilter.value;

            itemCards.forEach(card => {
                const name = card.dataset.name;
                const category = card.dataset.category;
                const status = card.dataset.status;
                const condition = card.dataset.condition;
                
                const matchesSearch = name.includes(searchTerm);
                const matchesCategory = !currentCategory || category === currentCategory;
                const matchesStatus = !selectedStatus || status === selectedStatus;
                const matchesCondition = !selectedCondition || condition === selectedCondition;
                
                if (matchesSearch && matchesCategory && matchesStatus && matchesCondition) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Événements de filtrage
        searchInput.addEventListener('input', filterItems);
        statusFilter.addEventListener('change', filterItems);
        conditionFilter.addEventListener('change', filterItems);
    </script>
</body>
</html>
