<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ajouter un Partenaire - Waste To Product</title>
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

        .form-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            max-width: 800px;
            margin: 0 auto;
        }

        .form-header {
            margin-bottom: 2rem;
            text-align: center;
        }

        .form-header h2 {
            color: #333;
            margin-bottom: 0.5rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group.full-width {
            grid-column: span 2;
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
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            margin-top: 1rem;
        }

        .checkbox-group input[type="checkbox"] {
            width: auto;
            margin-right: 0.5rem;
        }

        .btn-group {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .alert-danger {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .main-content {
                margin-left: 0;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .form-group.full-width {
                grid-column: span 1;
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
            <h1>Ajouter un Partenaire</h1>
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}">Dashboard</a> / 
                <a href="{{ route('partners.index') }}">Partenaires</a> / 
                <a href="{{ route('partners.list') }}">Liste</a> / Ajouter
            </div>
        </header>

        <div class="content">
            <div class="form-card">
                <div class="form-header">
                    <h2>🤝 Nouveau Partenaire</h2>
                    <p>Ajoutez un nouveau partenaire à votre réseau de collaboration</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul style="margin: 0; padding-left: 1rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('partners.store') }}">
                    @csrf
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Nom de l'organisation *</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="type_id">Type de partenaire *</label>
                            <select id="type_id" name="type_id" required>
                                <option value="">Sélectionner un type</option>
                                @foreach($partnerTypes as $type)
                                    <option value="{{ $type->id }}" {{ old('type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="contact_email">Email de contact *</label>
                            <input type="email" id="contact_email" name="contact_email" value="{{ old('contact_email') }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Téléphone</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="created_by">ID Utilisateur créateur *</label>
                        <input type="number" id="created_by" name="created_by" value="{{ old('created_by', 1) }}" required min="1">
                        <small style="color: #666; font-size: 0.9rem;">Entrez l'ID de l'utilisateur qui crée ce partenaire (ex: 1)</small>
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="address">Adresse</label>
                        <input type="text" id="address" name="address" value="{{ old('address') }}">
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="website">Site web</label>
                        <input type="url" id="website" name="website" value="{{ old('website') }}" placeholder="https://exemple.com">
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" rows="4" placeholder="Décrivez les activités et missions du partenaire...">{{ old('description') }}</textarea>
                    </div>

                    <div class="checkbox-group">
                        <input type="checkbox" id="is_active" name="is_active" {{ old('is_active') ? 'checked' : '' }}>
                        <label for="is_active">Partenaire actif</label>
                    </div>
                    
                    <div class="btn-group">
                        <a href="{{ route('partners.list') }}" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-primary">Créer le Partenaire</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
