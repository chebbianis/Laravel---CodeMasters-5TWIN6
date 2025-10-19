<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $partner->name }} - Waste To Product</title>
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

        .partner-header {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .partner-main-info {
            display: flex;
            align-items: center;
        }

        .partner-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: bold;
            color: white;
            margin-right: 1.5rem;
        }

        .partner-details h1 {
            color: #333;
            margin-bottom: 0.5rem;
        }

        .partner-type {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 500;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .type-ong { background: #d4edda; color: #155724; }
        .type-municipalité { background: #cce5ff; color: #004085; }
        .type-entreprise { background: #fff3cd; color: #856404; }
        .type-association { background: #d1ecf1; color: #0c5460; }
        .type-etablissement-public { background: #e2e3f0; color: #383d41; }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
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

        .actions {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .info-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .info-card h3 {
            color: #333;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .info-card .icon {
            margin-right: 0.5rem;
            font-size: 1.5rem;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding: 0.8rem;
            background: #f8fafc;
            border-radius: 8px;
        }

        .info-item .icon {
            margin-right: 1rem;
            width: 20px;
            text-align: center;
        }

        .info-item a {
            color: #667eea;
            text-decoration: none;
        }

        .meta-info {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .meta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .meta-item {
            text-align: center;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 8px;
        }

        .meta-item .value {
            font-size: 1.5rem;
            font-weight: bold;
            color: #667eea;
            display: block;
        }

        .meta-item .label {
            color: #666;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .main-content {
                margin-left: 0;
            }

            .partner-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .info-grid {
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
            <h1>{{ $partner->name }}</h1>
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}">Dashboard</a> / 
                <a href="{{ route('partners.index') }}">Partenaires</a> / 
                <a href="{{ route('partners.list') }}">Liste</a> / {{ $partner->name }}
            </div>
        </header>

        <div class="content">
            <!-- En-tête du partenaire -->
            <div class="partner-header">
                <div class="partner-main-info">
                    <div class="partner-avatar type-{{ strtolower(str_replace(' ', '-', $partner->type->name)) }}">
                        {{ substr($partner->name, 0, 1) }}
                    </div>
                    <div class="partner-details">
                        <h1>{{ $partner->name }}</h1>
                        <div class="partner-type type-{{ strtolower(str_replace(' ', '-', $partner->type->name)) }}">
                            {{ $partner->type->name }}
                        </div>
                        <div class="status-badge {{ $partner->is_active ? 'status-active' : 'status-inactive' }}">
                            {{ $partner->is_active ? '● Partenaire Actif' : '● Partenaire Inactif' }}
                        </div>
                    </div>
                </div>
                
                <div class="actions">
                    <a href="{{ route('partners.edit', $partner) }}" class="btn btn-primary">
                        ✏️ Modifier
                    </a>
                    <a href="{{ route('partners.list') }}" class="btn btn-secondary">
                        ← Retour à la liste
                    </a>
                </div>
            </div>

            <!-- Informations détaillées -->
            <div class="info-grid">
                <!-- Contact -->
                <div class="info-card">
                    <h3><span class="icon">📞</span> Informations de Contact</h3>
                    
                    <div class="info-item">
                        <span class="icon">📧</span>
                        <div>
                            <strong>Email :</strong><br>
                            <a href="mailto:{{ $partner->contact_email }}">{{ $partner->contact_email }}</a>
                        </div>
                    </div>

                    @if($partner->phone)
                    <div class="info-item">
                        <span class="icon">📱</span>
                        <div>
                            <strong>Téléphone :</strong><br>
                            <a href="tel:{{ $partner->phone }}">{{ $partner->phone }}</a>
                        </div>
                    </div>
                    @endif

                    @if($partner->address)
                    <div class="info-item">
                        <span class="icon">📍</span>
                        <div>
                            <strong>Adresse :</strong><br>
                            {{ $partner->address }}
                        </div>
                    </div>
                    @endif

                    @if($partner->website)
                    <div class="info-item">
                        <span class="icon">🌐</span>
                        <div>
                            <strong>Site web :</strong><br>
                            <a href="{{ $partner->website }}" target="_blank">{{ $partner->website }}</a>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Description -->
                <div class="info-card">
                    <h3><span class="icon">📄</span> Description</h3>
                    @if($partner->description)
                        <p>{{ $partner->description }}</p>
                    @else
                        <p style="color: #999; font-style: italic;">Aucune description disponible.</p>
                    @endif
                </div>
            </div>

            <!-- Métadonnées -->
            <div class="meta-info">
                <h3 style="margin-bottom: 1rem;">📊 Informations Système</h3>
                <div class="meta-grid">
                    <div class="meta-item">
                        <span class="value">{{ $partner->created_at->format('d/m/Y') }}</span>
                        <span class="label">Date de création</span>
                    </div>
                    <div class="meta-item">
                        <span class="value">{{ $partner->updated_at->format('d/m/Y') }}</span>
                        <span class="label">Dernière modification</span>
                    </div>
                    <div class="meta-item">
                        <span class="value">{{ $partner->creator->username ?? 'Système' }}</span>
                        <span class="label">Créé par</span>
                    </div>
                    <div class="meta-item">
                        <span class="value">{{ $partner->type->name }}</span>
                        <span class="label">Type de partenaire</span>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
