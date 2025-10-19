<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Inscriptions - Waste To Product</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; line-height: 1.6; }

        .sidebar { position: fixed; top:0; left:0; width:250px; height:100vh; background:linear-gradient(180deg,#667eea 0%,#764ba2 100%); color:white; padding:2rem 0; overflow-y:auto; }
        .sidebar-header { text-align:center; padding:0 1rem 2rem; border-bottom:1px solid rgba(255,255,255,0.2); }
        .sidebar-nav { padding:2rem 0; }
        .sidebar-nav a { display:block; color:white; text-decoration:none; padding:1rem 2rem; transition: background 0.3s; border-left:3px solid transparent; }
        .sidebar-nav a:hover, .sidebar-nav a.active { background: rgba(255,255,255,0.1); border-left-color:white; }

        .main-content { margin-left:250px; padding:2rem; }
        .page-header { background:white; padding:2rem; border-radius:12px; box-shadow:0 4px 20px rgba(0,0,0,0.1); margin-bottom:2rem; }
        .page-header h1 { color:#333; font-size:2.2rem; margin-bottom:0.5rem; }

        .stats-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:1.5rem; margin-bottom:2rem; }
        .stat-card { background:white; padding:2rem; border-radius:12px; box-shadow:0 4px 20px rgba(0,0,0,0.1); text-align:center; }
        .stat-card .icon { font-size:2.5rem; margin-bottom:1rem; }
        .stat-card .number { font-size:2rem; font-weight:bold; color:#9C27B0; margin-bottom:0.5rem; }
        .stat-card .label { color:#666; font-size:0.9rem; }

        .event-tabs { background:white; border-radius:12px; box-shadow:0 4px 20px rgba(0,0,0,0.1); overflow:hidden; margin-bottom:2rem; }
        .tabs-header { display:flex; background:#f8f9fa; border-bottom:2px solid #e9ecef; }
        .tab-button { flex:1; padding:1rem 2rem; background:none; border:none; cursor:pointer; font-weight:500; transition: all 0.3s; border-bottom:3px solid transparent; }
        .tab-button.active { background:white; border-bottom-color:#9C27B0; color:#9C27B0; }
        .tab-content { padding:2rem; }

        .participants-table { width:100%; border-collapse:collapse; margin-top:1rem; }
        .participants-table th, .participants-table td { padding:1rem; text-align:left; border-bottom:1px solid #e9ecef; }
        .participants-table th { background:#f8f9fa; font-weight:600; color:#333; }
        .participants-table tr:hover { background:#f8f9fa; }

        .status-badge { padding:0.3rem 0.8rem; border-radius:20px; font-size:0.8rem; font-weight:500; }
        .status-confirmed { background:#d4edda; color:#155724; }
        .status-pending { background:#fff3cd; color:#856404; }
        .status-cancelled { background:#f8d7da; color:#721c24; }

        .action-btn { padding:0.4rem 0.8rem; margin:0 0.2rem; border:none; border-radius:4px; cursor:pointer; font-size:0.8rem; transition: all 0.3s; }
        .btn-confirm { background:#28a745; color:white; }
        .btn-cancel { background:#dc3545; color:white; }
        .btn-email { background:#17a2b8; color:white; }
        .action-btn:hover { opacity:0.8; transform: translateY(-1px); }

        .filters { background:white; padding:1.5rem; border-radius:12px; box-shadow:0 4px 20px rgba(0,0,0,0.1); margin-bottom:2rem; display:flex; gap:1rem; flex-wrap:wrap; align-items:end; }
        .filter-group { display:flex; flex-direction:column; gap:0.5rem; }
        .filter-group label { font-weight:500; color:#333; font-size:0.9rem; }
        .filter-group select, .filter-group input { padding:8px 12px; border:2px solid #ddd; border-radius:6px; font-size:1rem; }
        .btn { padding:8px 16px; background:linear-gradient(135deg, #9C27B0 0%, #E91E63 100%); color:white; border:none; border-radius:6px; cursor:pointer; font-weight:500; height:fit-content; }
        .btn:hover { opacity:0.9; }

        .export-section { background:white; padding:2rem; border-radius:12px; box-shadow:0 4px 20px rgba(0,0,0,0.1); margin-bottom:2rem; }
        .export-section h3 { color:#333; margin-bottom:1rem; }
        .export-buttons { display:flex; gap:1rem; flex-wrap:wrap; }
        .btn-export { background:#28a745; }
        .btn-csv { background:#17a2b8; }
        .btn-pdf { background:#fd7e14; }

        .empty-state { text-align:center; padding:4rem 2rem; color:#666; }
        .empty-state .icon { font-size:4rem; margin-bottom:1rem; opacity:0.5; }

        /* NOUVEAU : Section Analyse des Avis */
        .sentiment-analysis-section {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .events-sentiment-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }
        .event-sentiment-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-left: 4px solid #9C27B0;
        }
        .sentiment-details {
            margin-top: 1rem;
        }
        .rating-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        .stars {
            display: flex;
            align-items: center;
            gap: 0.2rem;
        }
        .rating-value {
            margin-left: 0.5rem;
            font-weight: bold;
        }
        .rating-count {
            color: #666;
            font-size: 0.9rem;
        }
        .sentiment-bars {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .sentiment-bar {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .sentiment-bar .label {
            width: 80px;
            font-size: 0.9rem;
        }
        .sentiment-bar .value {
            width: 30px;
            text-align: center;
            font-weight: bold;
        }
        .bar {
            flex: 1;
            height: 8px;
            background: #e0e0e0;
            border-radius: 4px;
            overflow: hidden;
        }
        .bar .fill {
            height: 100%;
            transition: width 0.3s ease;
        }
        .sentiment-bar.positive .fill { background: #4CAF50; }
        .sentiment-bar.neutral .fill { background: #FFC107; }
        .sentiment-bar.negative .fill { background: #F44336; }
        .no-data {
            text-align: center;
            color: #888;
            font-style: italic;
            padding: 1rem;
        }

        @media (max-width:768px) {
            .sidebar { transform:translateX(-100%); }
            .main-content { margin-left:0; padding:1rem; }
            .tabs-header { flex-direction:column; }
            .participants-table { font-size:0.8rem; }
            .filters { flex-direction:column; }
            .export-buttons { flex-direction:column; }
            .events-sentiment-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>🎯 Événements</h2>
            <p>Gestion des Ateliers</p>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}">← Tableau de Bord</a>
            <a href="{{ route('events.index') }}">Vue d'ensemble</a>
            <a href="{{ route('events.workshops') }}">Ateliers & Conférences</a>
            <a href="{{ route('events.participations') }}" class="active">Inscriptions</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="page-header">
            <h1>Gestion des Inscriptions</h1>
            <p>Suivez et gérez les participants à vos événements et ateliers</p>
        </div>

        <!-- NOUVEAU : Section Analyse des Avis -->
        <div class="sentiment-analysis-section">
            <h3>📊 Analyse des Avis - Tous les Événements</h3>
            
            <div class="events-sentiment-grid">
                @foreach($events as $event)
                <div class="event-sentiment-card">
                    <h4>{{ $event->title }}</h4>
                    
                    @if($event->rating_count > 0)
                    <div class="sentiment-details">
                        <div class="rating-section">
                            <div class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($event->average_rating))
                                        <span>⭐</span>
                                    @else
                                        <span>☆</span>
                                    @endif
                                @endfor
                                <span class="rating-value">{{ number_format($event->average_rating, 1) }}/5</span>
                            </div>
                            <div class="rating-count">{{ $event->rating_count }} avis</div>
                        </div>
                        
                        <div class="sentiment-bars">
                            <div class="sentiment-bar positive">
                                <span class="label">😊 Positifs</span>
                                <span class="value">{{ $event->positive_feedbacks }}</span>
                                <div class="bar">
                                    <div class="fill" style="width: {{ $event->rating_count > 0 ? ($event->positive_feedbacks / $event->rating_count * 100) : 0 }}%"></div>
                                </div>
                            </div>
                            <div class="sentiment-bar neutral">
                                <span class="label">😐 Neutres</span>
                                <span class="value">{{ $event->neutral_feedbacks }}</span>
                                <div class="bar">
                                    <div class="fill" style="width: {{ $event->rating_count > 0 ? ($event->neutral_feedbacks / $event->rating_count * 100) : 0 }}%"></div>
                                </div>
                            </div>
                            <div class="sentiment-bar negative">
                                <span class="label">😞 Négatifs</span>
                                <span class="value">{{ $event->negative_feedbacks }}</span>
                                <div class="bar">
                                    <div class="fill" style="width: {{ $event->rating_count > 0 ? ($event->negative_feedbacks / $event->rating_count * 100) : 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="no-data">Aucun avis pour le moment</div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <!-- Stats dynamiques -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="icon">👥</div>
                <div class="number">{{ $stats['total'] ?? 0 }}</div>
                <div class="label">Total Inscrits</div>
            </div>
            <div class="stat-card">
                <div class="icon">✅</div>
                <div class="number">{{ $stats['confirmed'] ?? 0 }}</div>
                <div class="label">Confirmés</div>
            </div>
            <div class="stat-card">
                <div class="icon">⏳</div>
                <div class="number">{{ $stats['pending'] ?? 0 }}</div>
                <div class="label">En Attente</div>
            </div>
            <div class="stat-card">
                <div class="icon">❌</div>
                <div class="number">{{ $stats['cancelled'] ?? 0 }}</div>
                <div class="label">Annulés</div>
            </div>
        </div>

        <!-- Filters dynamiques -->
        <div class="filters">
            <form method="GET" action="{{ route('events.participations') }}" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: end;">
                <div class="filter-group">
                    <label>Événement</label>
                    <select name="event">
                        <option value="">Tous les événements</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}" @selected(request('event') == $event->id)>{{ $event->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label>Statut</label>
                    <select name="status">
                        <option value="">Tous les statuts</option>
                        <option value="confirmed" @selected(request('status')=='confirmed')>Confirmé</option>
                        <option value="pending" @selected(request('status')=='pending')>En attente</option>
                        <option value="cancelled" @selected(request('status')=='cancelled')>Annulé</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Date d'inscription</label>
                    <input type="date" name="date" value="{{ request('date') }}">
                </div>
                <button type="submit" class="btn">Filtrer</button>
            </form>
        </div>

        <!-- Export Section -->
        <div class="export-section">
            <h3>Exporter les données</h3>
            <div class="export-buttons">
                <a href="{{ route('events.participations.export', ['format'=>'excel']) }}" class="btn btn-export">📊 Export Excel</a>
                <a href="{{ route('events.participations.export', ['format'=>'csv']) }}" class="btn btn-csv">📄 Export CSV</a>
                <a href="{{ route('events.participations.export', ['format'=>'pdf']) }}" class="btn btn-pdf">📋 Liste PDF</a>
                <a href="{{ route('events.participations.newsletter') }}" class="btn">📧 Envoyer Newsletter</a>
            </div>
        </div>

        <!-- Event Tabs dynamiques -->
        <div class="event-tabs">
            <div class="tabs-header">
                @foreach($events as $index => $event)
                    <button class="tab-button @if($index===0) active @endif" onclick="showTab('event-{{ $event->id }}', event)">
                        {{ $event->title }} ({{ $event->participations->count() }})
                    </button>
                @endforeach
            </div>

            @foreach($events as $index => $event)
                <div id="event-{{ $event->id }}" class="tab-content" @if($index!==0) style="display:none;" @endif>
                    @if($event->participations->isEmpty())
                        <div class="empty-state">
                            <div class="icon">📝</div>
                            <h3>Inscriptions ouvertes</h3>
                            <p>Les inscriptions pour cet atelier viennent d'ouvrir.</p>
                        </div>
                    @else
                        <table class="participants-table">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>Inscription</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($event->participations as $participant)
                                    @php $notes = json_decode($participant->notes); @endphp
                                    <tr>
                                        <td>{{ $notes->name ?? '—' }}</td>
                                        <td>{{ $notes->email ?? '—' }}</td>
                                        <td>{{ $notes->phone ?? '—' }}</td>
                                        <td>{{ $participant->registration_date->format('d/m/Y') }}</td>
                                        <td>
                                            <span class="status-badge status-{{ $participant->status }}">
                                                {{ ucfirst($participant->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($participant->status=='pending')
                                                <form method="POST" action="{{ route('participations.confirm', $participant->id) }}" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="action-btn btn-confirm" title="Confirmer">✅</button>
                                                </form>
                                            @endif
                                            <form method="POST" action="{{ route('participations.cancel', $participant->id) }}" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="action-btn btn-cancel" title="Annuler">❌</button>
                                            </form>
                                            <a href="mailto:{{ $notes->email ?? '' }}" class="action-btn btn-email" title="Envoyer email">📧</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function showTab(tabName, evt) {
            const contents = document.querySelectorAll('.tab-content');
            contents.forEach(c => c.style.display='none');
            const buttons = document.querySelectorAll('.tab-button');
            buttons.forEach(b => b.classList.remove('active'));
            document.getElementById(tabName).style.display='block';
            evt.currentTarget.classList.add('active');
        }
    </script>
</body>
</html>