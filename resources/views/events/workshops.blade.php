<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ateliers et Conférences - Waste To Product</title>
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
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            overflow-y: auto;
        }
        
        .sidebar-header {
            text-align: center;
            padding: 0 1rem 2rem;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        
        .sidebar-nav {
            padding: 2rem 0;
        }
        
        .sidebar-nav a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 1rem 2rem;
            transition: background 0.3s;
            border-left: 3px solid transparent;
        }
        
        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background: rgba(255,255,255,0.1);
            border-left-color: white;
        }
        
        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 2rem;
        }
        
        .page-header {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .page-header h1 {
            color: #333;
            font-size: 2.2rem;
        }
        
        .btn {
            padding: 12px 24px;
            background: linear-gradient(135deg, #9C27B0 0%, #E91E63 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: transform 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        }
        
        /* Filters */
        .filters {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .filter-group label {
            font-weight: 500;
            color: #333;
        }
        
        .filter-group select,
        .filter-group input {
            padding: 8px 12px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
        }
        
        /* Events Grid */
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
        }
        
        .event-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        
        .event-card:hover {
            transform: translateY(-5px);
        }
        
        .event-card .event-type {
            padding: 1rem;
            color: white;
            text-align: center;
            font-weight: 600;
        }
        
        .event-type.workshop {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        }
        
        .event-type.conference {
            background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
        }
        
        .event-type.repair {
            background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%);
        }
        
        .event-card .event-content {
            padding: 2rem;
        }
        
        .event-card .event-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1rem;
        }
        
        .event-info {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
            margin-bottom: 2rem;
        }
        
        .event-info-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #666;
        }
        
        .event-actions {
            display: flex;
            gap: 1rem;
        }
        
        .btn-edit {
            background: #17a2b8;
            flex: 1;
        }
        
        .btn-delete {
            background: #dc3545;
            flex: 1;
        }
        
        /* Add Event Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            z-index: 1000;
        }
        
        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 3rem;
            border-radius: 16px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .modal h2 {
            margin-bottom: 2rem;
            color: #333;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #333;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
        }
        
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }
        
        .btn-cancel {
            background: #6c757d;
        }
        
        .close-modal {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: 2rem;
            cursor: pointer;
            color: #999;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
            
            .page-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .filters {
                flex-direction: column;
            }
            
            .events-grid {
                grid-template-columns: 1fr;
            }
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
            <a href="{{ route('events.workshops') }}" class="active">Ateliers & Conférences</a>
            <a href="{{ route('events.participations') }}">Inscriptions</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Ateliers et Conférences</h1>
            <button class="btn btn-success" onclick="openAddModal()">+ Nouvel Événement</button>
        </div>

        <!-- Filters -->
        <div class="filters">
            <div class="filter-group">
                <label>Type d'événement</label>
                <select>
                    <option value="">Tous les types</option>
                    <option value="workshop">Atelier</option>
                    <option value="conference">Conférence</option>
                    <option value="repair">Repair Café</option>
                </select>
            </div>
            <div class="filter-group">
                <label>Statut</label>
                <select>
                    <option value="">Tous les statuts</option>
                    <option value="planned">Planifié</option>
                    <option value="ongoing">En cours</option>
                    <option value="completed">Terminé</option>
                </select>
            </div>
            <div class="filter-group">
                <label>Date début</label>
                <input type="date">
            </div>
            <div class="filter-group">
                <label>Date fin</label>
                <input type="date">
            </div>
        </div>

        <!-- Events Grid -->
        <div class="events-grid">
            <!-- Atelier de Réparation -->
            <div class="event-card">
                <div class="event-type workshop">🔧 ATELIER DE RÉPARATION</div>
                <div class="event-content">
                    <h3 class="event-title">Repair Café - Électroménager</h3>
                    <div class="event-info">
                        <div class="event-info-item">
                            <span>📅</span>
                            <span>Samedi 15 Février 2025</span>
                        </div>
                        <div class="event-info-item">
                            <span>⏰</span>
                            <span>14h00 - 17h00</span>
                        </div>
                        <div class="event-info-item">
                            <span>📍</span>
                            <span>Centre Communautaire - Salle A</span>
                        </div>
                        <div class="event-info-item">
                            <span>👥</span>
                            <span>15/20 participants</span>
                        </div>
                    </div>
                    <div class="event-actions">
                        <button class="btn btn-edit">Modifier</button>
                        <button class="btn btn-delete">Supprimer</button>
                    </div>
                </div>
            </div>

            <!-- Conférence -->
            <div class="event-card">
                <div class="event-type conference">🎓 CONFÉRENCE</div>
                <div class="event-content">
                    <h3 class="event-title">Économie Circulaire : Défis et Opportunités</h3>
                    <div class="event-info">
                        <div class="event-info-item">
                            <span>📅</span>
                            <span>Mercredi 20 Février 2025</span>
                        </div>
                        <div class="event-info-item">
                            <span>⏰</span>
                            <span>18h30 - 20h30</span>
                        </div>
                        <div class="event-info-item">
                            <span>📍</span>
                            <span>Amphithéâtre Université</span>
                        </div>
                        <div class="event-info-item">
                            <span>👥</span>
                            <span>45/80 participants</span>
                        </div>
                    </div>
                    <div class="event-actions">
                        <button class="btn btn-edit">Modifier</button>
                        <button class="btn btn-delete">Supprimer</button>
                    </div>
                </div>
            </div>

            <!-- Atelier Upcycling -->
            <div class="event-card">
                <div class="event-type repair">♻️ ATELIER CRÉATIF</div>
                <div class="event-content">
                    <h3 class="event-title">Upcycling : Transformez vos déchets</h3>
                    <div class="event-info">
                        <div class="event-info-item">
                            <span>📅</span>
                            <span>Samedi 25 Février 2025</span>
                        </div>
                        <div class="event-info-item">
                            <span>⏰</span>
                            <span>10h00 - 16h00</span>
                        </div>
                        <div class="event-info-item">
                            <span>📍</span>
                            <span>Fablab Local</span>
                        </div>
                        <div class="event-info-item">
                            <span>👥</span>
                            <span>8/12 participants</span>
                        </div>
                    </div>
                    <div class="event-actions">
                        <button class="btn btn-edit">Modifier</button>
                        <button class="btn btn-delete">Supprimer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Event Modal -->
    <div id="addEventModal" class="modal">
        <div class="modal-content">
            <button class="close-modal" onclick="closeAddModal()">&times;</button>
            <h2>Créer un Nouvel Événement</h2>
            
            <form>
                <div class="form-group">
                    <label>Titre de l'événement</label>
                    <input type="text" placeholder="Ex: Repair Café - Vélos" required>
                </div>
                
                <div class="form-group">
                    <label>Type d'événement</label>
                    <select required>
                        <option value="">Choisir un type</option>
                        <option value="workshop">Atelier</option>
                        <option value="conference">Conférence</option>
                        <option value="repair">Repair Café</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Description</label>
                    <textarea placeholder="Description détaillée de l'événement..." required></textarea>
                </div>
                
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" required>
                </div>
                
                <div class="form-group">
                    <label>Heure de début</label>
                    <input type="time" required>
                </div>
                
                <div class="form-group">
                    <label>Heure de fin</label>
                    <input type="time" required>
                </div>
                
                <div class="form-group">
                    <label>Lieu</label>
                    <input type="text" placeholder="Adresse ou nom du lieu" required>
                </div>
                
                <div class="form-group">
                    <label>Nombre maximum de participants</label>
                    <input type="number" min="1" placeholder="20" required>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-cancel" onclick="closeAddModal()">Annuler</button>
                    <button type="submit" class="btn btn-success">Créer l'Événement</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('addEventModal').style.display = 'block';
        }
        
        function closeAddModal() {
            document.getElementById('addEventModal').style.display = 'none';
        }
        
        // Fermer la modal en cliquant en dehors
        window.onclick = function(event) {
            const modal = document.getElementById('addEventModal');
            if (event.target === modal) {
                closeAddModal();
            }
        }
    </script>
</body>
</html>
