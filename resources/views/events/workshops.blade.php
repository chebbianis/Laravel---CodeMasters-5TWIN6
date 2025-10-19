<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ateliers et Conférences - Waste To Product</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; line-height: 1.6; }

        /* Sidebar */
        .sidebar { position: fixed; top: 0; left: 0; width: 250px; height: 100vh; background: linear-gradient(180deg, #667eea 0%, #764ba2 100%); color: white; padding: 2rem 0; overflow-y: auto; }
        .sidebar-header { text-align: center; padding: 0 1rem 2rem; border-bottom: 1px solid rgba(255,255,255,0.2); }
        .sidebar-nav { padding: 2rem 0; }
        .sidebar-nav a { display: block; color: white; text-decoration: none; padding: 1rem 2rem; transition: background 0.3s; border-left: 3px solid transparent; }
        .sidebar-nav a:hover, .sidebar-nav a.active { background: rgba(255,255,255,0.1); border-left-color: white; }

        /* Main Content */
        .main-content { margin-left: 250px; padding: 2rem; }
        .page-header { background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; }
        .page-header h1 { color: #333; font-size: 2.2rem; }

        .btn { padding: 12px 24px; background: linear-gradient(135deg, #9C27B0 0%, #E91E63 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: 500; transition: transform 0.3s ease; border: none; cursor: pointer; }
        .btn:hover { transform: translateY(-2px); }
        .btn-success { background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%); }

        /* Filters */
        .filters { background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); margin-bottom: 2rem; display: flex; gap: 1rem; flex-wrap: wrap; }
        .filter-group { display: flex; flex-direction: column; gap: 0.5rem; }
        .filter-group label { font-weight: 500; color: #333; }
        .filter-group select, .filter-group input { padding: 8px 12px; border: 2px solid #ddd; border-radius: 6px; font-size: 1rem; }

        /* Events Grid */
        .events-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2rem; }
        .event-card { background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); overflow: hidden; transition: transform 0.3s ease; }
        .event-card:hover { transform: translateY(-5px); }
        .event-card .event-type { padding: 1rem; color: white; text-align: center; font-weight: 600; }
        .event-type.workshop { background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%); }
        .event-type.conference { background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%); }
        .event-type.repair { background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%); }
        .event-card .event-content { padding: 2rem; }
        .event-card .event-title { font-size: 1.4rem; font-weight: 600; color: #333; margin-bottom: 1rem; }
        .event-info { display: flex; flex-direction: column; gap: 0.8rem; margin-bottom: 1rem; }
        .event-info-item { display: flex; align-items: center; gap: 0.5rem; color: #666; }
        .event-actions { display: flex; gap: 1rem; }
        .btn-edit { background: #17a2b8; flex: 1; }
        .btn-delete { background: #dc3545; flex: 1; }

        /* Styles pour les statistiques d'avis */
        .event-stats {
            margin-top: 1rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .stats-row {
            display: flex;
            justify-content: space-around;
            text-align: center;
        }
        .stat-item {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .stat-icon {
            font-size: 1.5rem;
            margin-bottom: 0.3rem;
        }
        .stat-value {
            font-weight: bold;
            font-size: 1.1rem;
            color: #333;
        }
        .stat-label {
            font-size: 0.8rem;
            color: #666;
        }
        .no-feedback {
            text-align: center;
            color: #888;
        }

        /* NOUVEAU : Styles pour la gestion des places */
        .places-available {
            color: #28a745;
            font-weight: 500;
            font-size: 0.9rem;
        }
        .places-full {
            color: #dc3545;
            font-weight: 500;
            font-size: 0.9rem;
        }

        /* Add/Edit Event Modal */
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000; }
        .modal-content { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 3rem; border-radius: 16px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto; }
        .modal h2 { margin-bottom: 2rem; color: #333; }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: #333; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 8px; font-size: 1rem; }
        .form-group textarea { resize: vertical; min-height: 100px; }
        .form-actions { display: flex; gap: 1rem; justify-content: flex-end; }
        .btn-cancel { background: #6c757d; }
        .close-modal { position: absolute; top: 1rem; right: 1rem; background: none; border: none; font-size: 2rem; cursor: pointer; color: #999; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main-content { margin-left: 0; padding: 1rem; }
            .page-header { flex-direction: column; gap: 1rem; text-align: center; }
            .filters { flex-direction: column; }
            .events-grid { grid-template-columns: 1fr; }
            .stats-row { flex-direction: column; gap: 1rem; }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>Waste To Product</h2>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('events.index') }}" class="active">Événements</a>
            <a href="{{ route('events.participations') }}">Participations</a>
            <a href="{{ route('catalog.index') }}">Catalogue</a>
            <a href="{{ route('partners.index') }}">Partenaires</a>
            <a href="{{ route('collection.index') }}">Collecte</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Ateliers & Conférences</h1>
            <button class="btn btn-success" onclick="openAddModal()">+ Ajouter un événement</button>
        </div>

        <!-- Filters -->
        <div class="filters">
            <form method="GET" action="{{ route('events.workshops') }}" style="display:flex; gap:1rem; flex-wrap:wrap;">
                <div class="filter-group">
                    <label for="type">Type</label>
                    <select id="type" name="type">
                        <option value="">Tous</option>
                        <option value="workshop" @selected(request('type') == 'workshop')>Atelier</option>
                        <option value="conference" @selected(request('type') == 'conference')>Conférence</option>
                        <option value="repair" @selected(request('type') == 'repair')>Repair Café</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="date">Date</label>
                    <input type="date" id="date" name="date" value="{{ request('date') }}">
                </div>
                <div class="filter-group" style="align-self:flex-end;">
                    <button type="submit" class="btn">Filtrer</button>
                </div>
            </form>
        </div>

        <!-- Events Grid -->
        <div class="events-grid">
            @foreach($events as $event)
            <div class="event-card">
                <div class="event-type {{ $event->type }}">
                    @if($event->type == 'workshop') 🔧 ATELIER DE RÉPARATION
                    @elseif($event->type == 'conference') 🎓 CONFÉRENCE
                    @elseif($event->type == 'repair') ♻️ ATELIER CRÉATIF
                    @endif
                </div>
                <div class="event-content">
                    <h3 class="event-title">{{ $event->title }}</h3>
                    <div class="event-info">
                        <div class="event-info-item">
                            <span>📅</span>
                            <span>{{ \Carbon\Carbon::parse($event->date)->translatedFormat('l d F Y') }}</span>
                        </div>
                        <div class="event-info-item">
                            <span>⏰</span>
                            <span>{{ \Carbon\Carbon::parse($event->date)->format('H:i') }}</span>
                        </div>
                        <div class="event-info-item">
                            <span>📍</span>
                            <span>{{ $event->location }}</span>
                        </div>
                        <div class="event-info-item">
                            <span>👥</span>
                            <span>
                                {{ $event->participations_count }}/{{ $event->max_participants }} participants
                                @if($event->participations_count >= $event->max_participants)
                                    <span class="places-full">• COMPLET</span>
                                @else
                                    <span class="places-available">• {{ $event->max_participants - $event->participations_count }} places libres</span>
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Statistiques des avis -->
                    <div class="event-stats">
                        @if($event->rating_count > 0)
                        <div class="stats-row">
                            <div class="stat-item">
                                <span class="stat-icon">⭐</span>
                                <span class="stat-value">{{ number_format($event->average_rating, 1) }}/5</span>
                                <span class="stat-label">({{ $event->rating_count }} avis)</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-icon">😊</span>
                                <span class="stat-value">{{ $event->positive_feedbacks }}</span>
                                <span class="stat-label">positifs</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-icon">😞</span>
                                <span class="stat-value">{{ $event->negative_feedbacks }}</span>
                                <span class="stat-label">négatifs</span>
                            </div>
                        </div>
                        @else
                        <div class="no-feedback">
                            <span class="stat-icon">📝</span>
                            <span class="stat-label">Aucun avis pour le moment</span>
                        </div>
                        @endif
                    </div>

                    <div class="event-actions">
                        <button class="btn btn-edit"
                            onclick="openEditModal(
                                {{ $event->id }},
                                '{{ addslashes($event->title) }}',
                                '{{ $event->type }}',
                                `{{ addslashes($event->description) }}`,
                                '{{ \Carbon\Carbon::parse($event->date)->format('Y-m-d') }}',
                                '{{ $event->start_time ?? '' }}',
                                '{{ $event->end_time ?? '' }}',
                                '{{ addslashes($event->location) }}',
                                '{{ $event->max_participants }}'
                            )">
                            Modifier
                        </button>
                        <form action="{{ route('events.destroy', $event) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-delete" onclick="return confirm('Supprimer cet événement ?')">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Add/Edit Event Modal -->
    <div id="eventModal" class="modal">
        <div class="modal-content">
            <button class="close-modal" onclick="closeEventModal()">&times;</button>
            <h2 id="modalTitle">Créer un Nouvel Événement</h2>
            <form id="eventForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="form-group">
                    <label>Titre de l'événement</label>
                    <input type="text" name="title" id="event_title" required>
                </div>
                <div class="form-group">
                    <label>Type d'événement</label>
                    <select name="type" id="event_type" required>
                        <option value="">Choisir un type</option>
                        <option value="workshop">Atelier</option>
                        <option value="conference">Conférence</option>
                        <option value="repair">Repair Café</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" id="event_description" required></textarea>
                </div>
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="date" id="event_date" required>
                </div>
                <div class="form-group">
                    <label>Heure de début</label>
                    <input type="time" name="start_time" id="event_start_time">
                </div>
                <div class="form-group">
                    <label>Heure de fin</label>
                    <input type="time" name="end_time" id="event_end_time">
                </div>
                <div class="form-group">
                    <label>Lieu</label>
                    <input type="text" name="location" id="event_location" required>
                </div>
                <div class="form-group">
                    <label>Nombre maximum de participants</label>
                    <input type="number" min="1" name="max_participants" id="event_max_participants" required>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-cancel" onclick="closeEventModal()">Annuler</button>
                    <button type="submit" class="btn btn-success" id="submitBtn">Créer l'Événement</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('eventModal').style.display = 'block';
            document.getElementById('modalTitle').innerText = "Créer un Nouvel Événement";
            document.getElementById('eventForm').action = "{{ route('events.store') }}";
            document.getElementById('formMethod').value = "POST";
            document.getElementById('submitBtn').innerText = "Créer l'Événement";
            // Vide les champs
            document.getElementById('event_title').value = "";
            document.getElementById('event_type').value = "";
            document.getElementById('event_description').value = "";
            document.getElementById('event_date').value = "";
            document.getElementById('event_start_time').value = "";
            document.getElementById('event_end_time').value = "";
            document.getElementById('event_location').value = "";
            document.getElementById('event_max_participants').value = "";
        }

        function openEditModal(id, title, type, description, date, start_time, end_time, location, max_participants) {
            document.getElementById('eventModal').style.display = 'block';
            document.getElementById('modalTitle').innerText = "Modifier l'Événement";
            document.getElementById('eventForm').action = "/events/" + id;
            document.getElementById('formMethod').value = "PUT";
            document.getElementById('submitBtn').innerText = "Enregistrer";
            document.getElementById('event_title').value = title;
            document.getElementById('event_type').value = type;
            document.getElementById('event_description').value = description;
            document.getElementById('event_date').value = date;
            document.getElementById('event_start_time').value = start_time;
            document.getElementById('event_end_time').value = end_time;
            document.getElementById('event_location').value = location;
            document.getElementById('event_max_participants').value = max_participants;
        }

        function closeEventModal() {
            document.getElementById('eventModal').style.display = 'none';
        }

        window.onclick = function(event) {
            var modal = document.getElementById('eventModal');
            if (event.target == modal) {
                closeEventModal();
            }
        }
    </script>
</body>
</html>