<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Points de Collecte - Waste To Product</title>
    <style>
        /* --- Styles CSS identiques à ta version originale --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; line-height: 1.6; }
        .sidebar { position: fixed; left: 0; top: 0; width: 250px; height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 2rem 0; overflow-y: auto; }
        .sidebar .logo { text-align: center; padding: 0 1rem; margin-bottom: 2rem; }
        .nav-menu { list-style: none; }
        .nav-menu a { display: flex; align-items: center; color: white; text-decoration: none; padding: 1rem 1.5rem; transition: all 0.3s; }
        .nav-menu a:hover, .nav-menu a.active { background: rgba(255, 255, 255, 0.1); }
        .nav-menu .icon { margin-right: 1rem; }
        .main-content { margin-left: 250px; min-height: 100vh; }
        .header { background: white; padding: 2rem; box-shadow: 0 2px 10px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center; }
        .header h1 { color: #333; font-size: 2.2rem; }
        .breadcrumb a { color: #667eea; text-decoration: none; }
        .btn { padding: 12px 24px; background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: 500; transition: transform 0.3s ease; border: none; cursor: pointer; }
        .btn:hover { transform: translateY(-2px); }
        .btn-success { background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%); }
        .content { padding: 2rem; }
        .filters { background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); margin-bottom: 2rem; display: flex; gap: 1rem; flex-wrap: wrap; align-items: end; }
        .filter-group { display: flex; flex-direction: column; gap: 0.5rem; }
        .filter-group label { font-weight: 500; color: #333; }
        .filter-group select, .filter-group input { padding: 8px 12px; border: 2px solid #ddd; border-radius: 6px; font-size: 1rem; }
        .points-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2rem; }
        .point-card { background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); overflow: hidden; transition: transform 0.3s ease; }
        .point-card:hover { transform: translateY(-5px); }
        .point-header { padding: 2rem; color: white; position: relative; }
        .point-header.active { background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%); }
        .point-header.saturated { background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%); }
        .point-header.closed { background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%); }
        .status-badge { position: absolute; top: 1rem; right: 1rem; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600; background: rgba(255,255,255,0.2); }
        .point-content { padding: 2rem; }
        .point-info { margin-bottom: 2rem; }
        .info-item { display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.8rem; color: #666; }
        .capacity-bar { background: #e9ecef; border-radius: 10px; height: 8px; margin: 1rem 0; overflow: hidden; }
        .capacity-fill { height: 100%; border-radius: 10px; transition: width 0.3s ease; }
        .capacity-normal { background: #4CAF50; }
        .capacity-warning { background: #FF9800; }
        .capacity-danger { background: #f44336; }
        .point-actions { display: flex; gap: 0.5rem; flex-wrap: wrap; }
        .btn-edit { background: #17a2b8; flex: 1; min-width: 80px; }
        .btn-delete { background: #dc3545; flex: 1; min-width: 80px; }
        .btn-view { background: #6c757d; flex: 1; min-width: 80px; }
        .quick-stats { background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); margin-bottom: 2rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem; }
        .stat-item { text-align: center; padding: 1rem; border-radius: 8px; background: #f8f9fa; }
        .stat-number { font-size: 2rem; font-weight: bold; color: #FF9800; }
        .stat-label { color: #666; font-size: 0.9rem; }
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000; }
        .modal-content { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 3rem; border-radius: 16px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto; }
        .modal h2 { margin-bottom: 2rem; color: #333; }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: #333; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 8px; font-size: 1rem; }
        .form-group textarea { resize: vertical; min-height: 100px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .close-modal { position: absolute; top: 1rem; right: 1rem; background: none; border: none; font-size: 2rem; cursor: pointer; color: #999; }
        .form-actions { display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem; }
        .btn-cancel { background: #6c757d; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main-content { margin-left: 0; }
            .header { flex-direction: column; gap: 1rem; text-align: center; }
            .filters { flex-direction: column; }
            .points-grid { grid-template-columns: 1fr; }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<!-- Sidebar -->
<aside class="sidebar">
    <div class="logo">
        <h2>🔄 Waste To Product</h2>
        <p>Points de Collecte</p>
    </div>
    <ul class="nav-menu">
        <li><a href="{{ route('dashboard') }}"><span class="icon">🏠</span> Dashboard</a></li>
        <li><a href="{{ route('catalog.index') }}"><span class="icon">📦</span> Catalogue</a></li>
        <li><a href="{{ route('partners.index') }}"><span class="icon">🤝</span> Partenaires</a></li>
        <li><a href="{{ route('collection.index') }}"><span class="icon">📍</span> Points de Collecte</a></li>
        <li><a href="{{ route('collection.points') }}" class="active"><span class="icon">🏢</span> Gestion des Points</a></li>
        <li><a href="{{ route('collection.deposits') }}"><span class="icon">📋</span> Gestion des Dépôts</a></li>
        <li><a href="{{ route('events.index') }}"><span class="icon">🎪</span> Événements</a></li>
    </ul>
</aside>

<main class="main-content">
    <header class="header">
        <div>
            <h1>Gestion des Points de Collecte</h1>
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}">Dashboard</a> /
                <a href="{{ route('collection.index') }}">Points de Collecte</a> /
                Gestion des Points
            </div>
        </div>
        <button class="btn btn-success" onclick="openAddModal()">+ Nouveau Point</button>
    </header>

    <div class="content">
        <!-- Quick Stats -->
        <div class="quick-stats">
            <div class="stat-item"><div class="stat-number">{{ $points->count() }}</div><div class="stat-label">Points Total</div></div>
            <div class="stat-item"><div class="stat-number">{{ $points->where('status','active')->count() }}</div><div class="stat-label">Actifs</div></div>
            <div class="stat-item"><div class="stat-number">{{ $points->where('status','saturated')->count() }}</div><div class="stat-label">Saturés</div></div>
            <div class="stat-item"><div class="stat-number">{{ $points->where('status','closed')->count() }}</div><div class="stat-label">Fermés</div></div>
        </div>

        <!-- Filters -->
        <div class="filters">
            <div class="filter-group">
                <label>Statut</label>
                <select id="filterStatus">
                    <option value="">Tous les statuts</option>
                    <option value="active">Actif</option>
                    <option value="saturated">Saturé</option>
                    <option value="closed">Fermé</option>
                </select>
            </div>
            <div class="filter-group">
                <label>Capacité</label>
                <select id="filterCapacity">
                    <option value="">Toutes capacités</option>
                    <option value="small">Petite (< 50)</option>
                    <option value="medium">Moyenne (50-100)</option>
                    <option value="large">Grande (> 100)</option>
                </select>
            </div>
            <div class="filter-group">
                <label>Ville</label>
                <input type="text" id="filterCity" placeholder="Rechercher une ville...">
            </div>
            <div class="filter-group">
                <label>Responsable</label>
                <select id="filterUser">
                    <option value="">Tous les responsables</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn" onclick="applyFilters()">Filtrer</button>
        </div>

        <!-- Points Grid -->
        <div class="points-grid">
            @foreach($points as $point)
                @php
                    $usage = $point->capacity ? round(($point->used_capacity ?? 0) / $point->capacity * 100) : 0;
                    $fillClass = $usage < 70 ? 'capacity-normal' : ($usage < 90 ? 'capacity-warning' : 'capacity-danger');
                @endphp
                <div class="point-card" data-status="{{ $point->status }}" data-capacity="{{ $point->capacity }}" data-city="{{ $point->address }}" data-user="{{ $point->responsible_user_id }}">
                    <div class="point-header {{ $point->status }}">
                        <span class="status-badge">{{ strtoupper($point->status) }}</span>
                        <h3>{{ $point->name }}</h3>
                        <p>📍 {{ $point->address }}</p>
                    </div>
                    <div class="point-content">
                        <div class="point-info">
                            <div class="info-item"><span>📞</span><span>{{ $point->contact_info ?? 'Non renseigné' }}</span></div>
                            <div class="info-item"><span>⏰</span><span>{{ $point->opening_hours ?? 'Non renseigné' }}</span></div>
                            <div class="info-item"><span>👤</span><span>{{ $point->responsible->first_name ?? '' }} {{ $point->responsible->last_name ?? '' }} (Responsable)</span></div>
                            <div class="info-item"><span>📊</span><span>Capacité: {{ $point->used_capacity ?? 0 }}/{{ $point->capacity }}</span></div>
                        </div>
                        <div class="capacity-bar">
                            <div class="capacity-fill {{ $fillClass }}" style="width: {{ $usage }}%"></div>
                        </div>
                        <div class="point-actions">
                            <button class="btn btn-edit" onclick='openEditModal(@json($point))'>Modifier</button>
                            <form action="{{ route('collection.destroy', $point->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete" onclick="return confirm('Voulez-vous vraiment supprimer ce point ?')">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</main>

<!-- --- Modal Création --- -->
<div id="addPointModal" class="modal">
    <div class="modal-content">
        <button class="close-modal" onclick="closeAddModal()">&times;</button>
        <h2>Créer un Nouveau Point de Collecte</h2>
        <form action="{{ route('collection.store') }}" method="POST">
            @csrf
            <div class="form-group"><label>Nom du point de collecte</label><input type="text" name="name" required></div>
            <div class="form-group"><label>Adresse complète</label><textarea name="address" required></textarea></div>
            <div id="map" style="height: 300px; margin-bottom: 1rem;"></div>
            <div class="form-row">
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">

            </div>
            <div class="form-row">
                <div class="form-group"><label>Capacité de stockage</label><input type="number" name="capacity" required></div>
                <div class="form-group"><label>Responsable</label>
                    <select name="responsible_user_id" required>
                        <option value="">Choisir un responsable</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group"><label>Horaires d'ouverture</label><textarea name="opening_hours"></textarea></div>
            <div class="form-group"><label>Informations de contact</label><textarea name="contact_info"></textarea></div>
            <div class="form-group"><label>Statut</label>
                <select name="status" required>
                    <option value="active">Actif</option>
                    <option value="saturated">Saturé</option>
                    <option value="closed">Fermé</option>
                </select>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-cancel" onclick="closeAddModal()">Annuler</button>
                <button type="submit" class="btn btn-success">Créer</button>
            </div>
        </form>
    </div>
</div>

<!-- --- Modal Édition --- -->
<div id="editPointModal" class="modal">
    <div class="modal-content">
        <button class="close-modal" onclick="closeEditModal()">&times;</button>
        <h2>Modifier le Point de Collecte</h2>
        <form id="editPointForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group"><label>Nom du point de collecte</label><input type="text" name="name" required></div>
            <div class="form-group"><label>Adresse complète</label><textarea name="address" required></textarea></div>
            <div class="form-row">
                <div class="form-group"><label>Latitude</label><input type="number" step="0.000001" name="latitude" required></div>
                <div class="form-group"><label>Longitude</label><input type="number" step="0.000001" name="longitude" required></div>
            </div>
            <div class="form-row">
                <div class="form-group"><label>Capacité de stockage</label><input type="number" name="capacity" required></div>
                <div class="form-group"><label>Responsable</label>
                    <select name="responsible_user_id" required>
                        <option value="">Choisir un responsable</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group"><label>Horaires d'ouverture</label><textarea name="opening_hours"></textarea></div>
            <div class="form-group"><label>Informations de contact</label><textarea name="contact_info"></textarea></div>
            <div class="form-group"><label>Statut</label>
                <select name="status" required>
                    <option value="active">Actif</option>
                    <option value="saturated">Saturé</option>
                    <option value="closed">Fermé</option>
                </select>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-cancel" onclick="closeEditModal()">Annuler</button>
                <button type="submit" class="btn btn-success">Mettre à jour</button>
            </div>
        </form>
    </div>
</div>

<script>
    // --- Modal Création ---
    function openAddModal(){ document.getElementById('addPointModal').style.display='block'; }
    function closeAddModal(){ document.getElementById('addPointModal').style.display='none'; }

    // --- Modal Édition ---
    function openEditModal(point){
        const modal = document.getElementById('editPointModal');
        modal.style.display='block';
        const form = document.getElementById('editPointForm');
        form.action = `/collection-points/${point.id}`;
        form.name.value = point.name;
        form.address.value = point.address;
        form.latitude.value = point.latitude;
        form.longitude.value = point.longitude;
        form.capacity.value = point.capacity;
        form.responsible_user_id.value = point.responsible_user_id;
        form.opening_hours.value = point.opening_hours || '';
        form.contact_info.value = point.contact_info || '';
        form.status.value = point.status;
    }
    function closeEditModal(){ document.getElementById('editPointModal').style.display='none'; }

    // --- Filtrage simple ---
    function applyFilters(){
        const status = document.getElementById('filterStatus').value;
        const capacity = document.getElementById('filterCapacity').value;
        const city = document.getElementById('filterCity').value.toLowerCase();
        const user = document.getElementById('filterUser').value;

        document.querySelectorAll('.points-grid .point-card').forEach(card=>{
            const cardStatus = card.dataset.status;
            const cardCapacity = parseInt(card.dataset.capacity);
            const cardCity = card.dataset.city.toLowerCase();
            const cardUser = card.dataset.user;

            let show = true;
            if(status && cardStatus!==status) show=false;
            if(capacity){
                if(capacity==='small' && cardCapacity>=50) show=false;
                if(capacity==='medium' && (cardCapacity<50 || cardCapacity>100)) show=false;
                if(capacity==='large' && cardCapacity<=100) show=false;
            }
            if(city && !cardCity.includes(city)) show=false;
            if(user && cardUser!==user) show=false;

            card.style.display = show ? 'block' : 'none';
        });
    }
</script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let map = L.map('map').setView([36.8, 10.2], 13); // position par défaut
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    let marker = L.marker([36.8, 10.2], {draggable:true}).addTo(map);

    // mettre à jour les champs du formulaire quand le marker bouge
    marker.on('dragend', function(e){
        const pos = marker.getLatLng();
        document.getElementById('latitude').value = pos.lat.toFixed(6);
        document.getElementById('longitude').value = pos.lng.toFixed(6);
    });

    // si l'utilisateur clique sur la carte, bouger le marker
    map.on('click', function(e){
        marker.setLatLng(e.latlng);
        document.getElementById('latitude').value = e.latlng.lat.toFixed(6);
        document.getElementById('longitude').value = e.latlng.lng.toFixed(6);
    });
</script>

</body>
</html>
