<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nos Partenaires - Waste To Product</title>
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
            max-width: 600px;
            margin: 0 auto;
        }

        .partners-section {
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

        .search-filters {
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
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s;
            border: 1px solid #e2e8f0;
        }

        .partner-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }

        .partner-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
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
            color: white;
        }

        .partner-info h3 {
            color: #333;
            margin-bottom: 0.5rem;
            font-size: 1.3rem;
        }

        .partner-type {
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            display: inline-block;
        }

        .type-ong { background: #d4edda; color: #155724; }
        .type-municipalite { background: #cce5ff; color: #004085; }
        .type-entreprise { background: #fff3cd; color: #856404; }
        .type-association { background: #d1ecf1; color: #0c5460; }
        .type-etablissement { background: #e2e3f0; color: #383d41; }

        .partner-details {
            margin-bottom: 1.5rem;
        }

        .detail-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.8rem;
            color: #666;
        }

        .detail-icon {
            margin-right: 0.8rem;
            width: 20px;
            font-size: 1.1rem;
        }

        .detail-item a {
            color: #667eea;
            text-decoration: none;
        }

        .detail-item a:hover {
            text-decoration: underline;
        }

        .partner-status {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
        }

        .status-badge {
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .contact-btn {
            padding: 0.5rem 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .contact-btn:hover {
            transform: translateY(-2px);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #666;
        }

        .empty-state .icon {
            font-size: 4rem;
            margin-bottom: 1rem;
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
            
            .partners-section {
                padding: 2rem 1rem;
            }
            
            .partners-grid {
                grid-template-columns: 1fr;
            }
            
            .search-filters {
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
                <a href="{{ route('partners.public') }}">Nos Partenaires</a>
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </div>
        </nav>
    </header>

    <main class="main-content">
        <div class="container">
            <div class="page-header">
                <h1>🤝 Nos Partenaires</h1>
                <p>Découvrez notre réseau d'organisations engagées dans l'économie circulaire et la valorisation des déchets</p>
            </div>

            <div class="partners-section">
                <div class="stats-row">
                    <div class="stat-box">
                        <div class="number">{{ $totalPartners }}</div>
                        <div class="label">Partenaires</div>
                    </div>
                    <div class="stat-box">
                        <div class="number">{{ $activePartners }}</div>
                        <div class="label">Actifs</div>
                    </div>
                    <div class="stat-box">
                        <div class="number">{{ $partnerTypes->count() }}</div>
                        <div class="label">Types</div>
                    </div>
                    <div class="stat-box">
                        <div class="number">{{ date('Y') - 2020 }}</div>
                        <div class="label">Années d'expérience</div>
                    </div>
                </div>

                <div class="search-filters">
                    <input type="text" class="search-input" placeholder="🔍 Rechercher un partenaire..." id="searchInput">
                    <select class="filter-select" id="typeFilter">
                        <option value="">Tous les types</option>
                        @foreach($partnerTypes as $type)
                            <option value="{{ $type->name }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="partners-grid" id="partnersGrid">
                    @forelse($partners as $partner)
                    <div class="partner-card" data-type="{{ $partner->type->name ?? '' }}" data-name="{{ strtolower($partner->name) }}">
                        <div class="partner-header">
                            @php
                                $typeColors = [
                                    'ONG' => '#28a745',
                                    'Municipalité' => '#007bff', 
                                    'Entreprise' => '#ffc107',
                                    'Association' => '#17a2b8',
                                    'Établissement Public' => '#6f42c1'
                                ];
                                $typeIcons = [
                                    'ONG' => '🌱',
                                    'Municipalité' => '🏛️',
                                    'Entreprise' => '🏢', 
                                    'Association' => '👥',
                                    'Établissement Public' => '🏤'
                                ];
                                $typeClasses = [
                                    'ONG' => 'type-ong',
                                    'Municipalité' => 'type-municipalite',
                                    'Entreprise' => 'type-entreprise',
                                    'Association' => 'type-association', 
                                    'Établissement Public' => 'type-etablissement'
                                ];
                                $typeName = $partner->type->name ?? '';
                            @endphp
                            <div class="partner-avatar" style="background: {{ $typeColors[$typeName] ?? '#6f42c1' }};">
                                {{ $typeIcons[$typeName] ?? '🏢' }}
                            </div>
                            <div class="partner-info">
                                <h3>{{ $partner->name }}</h3>
                                <span class="partner-type {{ $typeClasses[$typeName] ?? 'type-etablissement' }}">
                                    {{ $partner->type->name ?? 'Non défini' }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="partner-details">
                            <div class="detail-item">
                                <span class="detail-icon">📧</span>
                                <a href="mailto:{{ $partner->contact_email }}">{{ $partner->contact_email }}</a>
                            </div>
                            @if($partner->phone)
                            <div class="detail-item">
                                <span class="detail-icon">📞</span>
                                <a href="tel:{{ $partner->phone }}">{{ $partner->phone }}</a>
                            </div>
                            @endif
                            @if($partner->address)
                            <div class="detail-item">
                                <span class="detail-icon">📍</span>
                                <span>{{ $partner->address }}</span>
                            </div>
                            @endif
                            @if($partner->website)
                            <div class="detail-item">
                                <span class="detail-icon">🌐</span>
                                <a href="{{ $partner->website }}" target="_blank">{{ str_replace(['http://', 'https://'], '', $partner->website) }}</a>
                            </div>
                            @endif
                        </div>

                        @if($partner->description)
                        <div class="detail-item" style="margin-bottom: 1rem;">
                            <span class="detail-icon">📝</span>
                            <span>{{ Str::limit($partner->description, 100) }}</span>
                        </div>
                        @endif
                        
                        <div class="partner-status">
                            <span class="status-badge status-active">● Partenaire actif</span>
                            <a href="mailto:{{ $partner->contact_email }}" class="contact-btn">Contacter</a>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state" style="grid-column: 1 / -1;">
                        <div class="icon">🤝</div>
                        <h3>Aucun partenaire trouvé</h3>
                        <p>Nous travaillons à développer notre réseau de partenaires.</p>
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
        // Fonctionnalité de recherche et filtrage
        const searchInput = document.getElementById('searchInput');
        const typeFilter = document.getElementById('typeFilter');
        const partnersGrid = document.getElementById('partnersGrid');
        const partnerCards = document.querySelectorAll('.partner-card');

        function filterPartners() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedType = typeFilter.value;

            partnerCards.forEach(card => {
                const name = card.dataset.name;
                const type = card.dataset.type;
                
                const matchesSearch = name.includes(searchTerm);
                const matchesType = !selectedType || type === selectedType;
                
                if (matchesSearch && matchesType) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener('input', filterPartners);
        typeFilter.addEventListener('change', filterPartners);
    </script>
</body>
</html>
