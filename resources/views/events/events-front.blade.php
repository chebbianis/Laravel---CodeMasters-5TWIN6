<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Événements & Ateliers - Waste To Product</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height:1.6;
            color:#333;
            background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);
            min-height:100vh;
        }
        .container { max-width:1200px; margin:0 auto; padding:0 20px; }
        header {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            padding:1rem 0;
            position: fixed;
            width:100%;
            top:0;
            z-index:1000;
        }
        nav { display:flex; justify-content:space-between; align-items:center; }
        .logo { font-size:1.8rem; font-weight:bold; color:white; }
        .nav-links { display:flex; gap:2rem; }
        .nav-links a { color:white; text-decoration:none; padding:0.5rem 1rem; border-radius:5px; transition: background 0.3s; }
        .nav-links a:hover, .nav-links a.active { background: rgba(255,255,255,0.2); }
        main { padding-top:120px; }
        .hero {
            padding: 2rem 0;
            text-align:center;
            color:white;
        }
        .hero h1 { font-size:3rem; margin-bottom:0.5rem; text-shadow:2px 2px 4px rgba(0,0,0,0.3); }
        .hero p { font-size:1.2rem; max-width:700px; margin:0 auto; }
        .events-grid {
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
            gap:2rem;
            margin-top:2rem;
        }
        .event-card {
            background:white;
            border-radius:15px;
            box-shadow:0 5px 15px rgba(0,0,0,0.1);
            overflow:hidden;
            transition: transform 0.3s;
            display:flex;
            flex-direction:column;
        }
        .event-card:hover { transform:translateY(-5px); }
        .event-type {
            padding:1rem;
            color:white;
            font-weight:600;
            text-align:center;
        }
        .event-type.workshop { background:linear-gradient(135deg,#4CAF50 0%,#45a049 100%); }
        .event-type.conference { background:linear-gradient(135deg,#2196F3 0%,#1976D2 100%); }
        .event-type.repair { background:linear-gradient(135deg,#FF9800 0%,#F57C00 100%); }
        .event-content { padding:1.5rem; display:flex; flex-direction:column; flex:1; }
        .event-title { font-size:1.4rem; font-weight:600; color:#333; margin-bottom:1rem; }
        .event-info { display:flex; flex-direction:column; gap:0.5rem; margin-bottom:1rem; }
        .event-info-item { display:flex; align-items:center; gap:0.5rem; color:#555; font-size:0.95rem; }
        .btn { padding:10px 20px; background:linear-gradient(135deg,#9C27B0 0%,#E91E63 100%); color:white; border:none; border-radius:8px; cursor:pointer; transition: transform 0.3s; margin-top:auto; text-align:center; text-decoration:none; display:inline-block; }
        .btn:hover { transform:translateY(-2px); }
        footer { background: rgba(0,0,0,0.8); color:white; text-align:center; padding:2rem 0; margin-top:4rem; }

        /* Modal */
        .modal { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5); z-index:1000; }
        .modal-content { background:#fff; margin:5% auto; padding:2rem; border-radius:12px; width:90%; max-width:400px; position:relative; }
        .close-modal { position:absolute; top:1rem; right:1rem; font-size:2rem; background:none; border:none; color:#888; cursor:pointer; }
        .form-group { margin-bottom:1rem; }
        label { display:block; margin-bottom:0.3rem; color:#333; }
        input[type="text"], input[type="email"] { width:100%; padding:8px; border:1px solid #ccc; border-radius:6px; }
        @media(max-width:768px) { .nav-links { display:none; } .events-grid { grid-template-columns:1fr; } .hero h1 { font-size:2rem; } }
    </style>
</head>
<body>
<header>
    <div class="container">
        <div class="logo">🔄 Waste To Product</div>
        <div class="nav-links">
            <a href="{{ route('home') }}">Accueil</a>
            <a href="{{ route('events-front') }}" class="active">Événements & Ateliers</a>
        </div>
    </div>
</header>

<main>
    <section class="hero">
        <div class="container">
            <h1>Événements & Ateliers</h1>
            <p>Participez à nos ateliers de réparation, conférences et événements pour valoriser les déchets et promouvoir l'économie circulaire.</p>
        </div>
    </section>

    <div class="container">
        <div class="events-grid">
            @foreach($events as $event)
                <div class="event-card">
                    <div class="event-type {{ $event->type }}">
                        @if($event->type == 'workshop') 🔧 Atelier de Réparation
                        @elseif($event->type == 'conference') 🎓 Conférence
                        @elseif($event->type == 'repair') ♻️ Atelier Créatif
                        @endif
                    </div>
                    <div class="event-content">
                        <h3 class="event-title">{{ $event->title }}</h3>
                        <div class="event-info">
                            <div class="event-info-item">📅 {{ \Carbon\Carbon::parse($event->date)->translatedFormat('l d F Y') }}</div>
                            <div class="event-info-item">⏰ {{ \Carbon\Carbon::parse($event->date)->format('H:i') }}</div>
                            <div class="event-info-item">📍 {{ $event->location }}</div>
                            <div class="event-info-item">👥 {{ $event->participations->count() }}/{{ $event->max_participants }} participants</div>
                        </div>
                        <button class="btn" onclick="openParticipationModal({{ $event->id }}, '{{ addslashes($event->title) }}')">Participer</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</main>

<!-- Modal d'inscription -->
<div id="participationModal" class="modal">
    <div class="modal-content">
        <button class="close-modal" onclick="closeParticipationModal()">&times;</button>
        <h2 id="modalEventTitle">Inscription à l'événement</h2>
        <form id="participationForm" method="POST" action="{{ route('participations.store') }}">
            @csrf
            <input type="hidden" name="event_id" id="modal_event_id">
            <div class="form-group">
                <label>Nom du participant</label>
                <input type="text" name="participant_name" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="participant_email" required>
            </div>
            <button type="submit" class="btn">Valider l'inscription</button>
            <button type="button" class="btn" style="background:#888;" onclick="closeParticipationModal()">Annuler</button>
        </form>
    </div>
</div>

<footer>
    <div class="container">
        <p>&copy; {{ date('Y') }} Waste To Product. Tous droits réservés. 🌱</p>
    </div>
</footer>

<script>
    function openParticipationModal(eventId, eventTitle){
        document.getElementById('participationModal').style.display='block';
        document.getElementById('modal_event_id').value=eventId;
        document.getElementById('modalEventTitle').innerText='Inscription à l\'événement : '+eventTitle;
    }
    function closeParticipationModal(){
        document.getElementById('participationModal').style.display='none';
    }
    window.onclick=function(event){
        var modal=document.getElementById('participationModal');
        if(event.target==modal){ closeParticipationModal(); }
    }
</script>
</body>
</html>
