<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Types de Partenaires - Waste To Product</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }

        .header p {
            color: #666;
            font-size: 1.1rem;
        }

        .actions-bar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #f8f9fa;
            color: #495057;
            border: 1px solid #dee2e6;
        }

        .btn-secondary:hover {
            background: #e9ecef;
            transform: translateY(-1px);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            color: white;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
        }

        .btn-edit {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
            color: white;
            padding: 8px 16px;
            font-size: 0.85rem;
        }

        .btn-edit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.4);
        }

        .btn-small {
            padding: 6px 12px;
            font-size: 0.8rem;
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
            box-shadow: none !important;
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .type-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .type-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .type-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .type-name {
            font-size: 1.4rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 5px;
        }

        .partners-count {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            min-width: 60px;
            text-align: center;
        }

        .type-description {
            color: #666;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .type-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            color: #764ba2;
            transform: translateX(-5px);
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: none;
            font-weight: 500;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background: white;
            margin: 5% auto;
            padding: 0;
            border-radius: 15px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: modalSlideIn 0.3s ease;
        }

        @keyframes modalSlideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            padding: 25px 30px 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d3748;
            margin: 0;
        }

        .modal-body {
            padding: 25px 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        .modal-footer {
            padding: 20px 30px 25px;
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            line-height: 1;
            padding: 0 5px;
        }

        .close:hover {
            color: #000;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .empty-state h3 {
            color: #666;
            font-size: 1.3rem;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #999;
            margin-bottom: 25px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #666;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .header h1 {
                font-size: 2rem;
            }

            .actions-bar {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }

            .cards-grid {
                grid-template-columns: 1fr;
            }

            .type-actions {
                justify-content: center;
            }

            .modal-content {
                margin: 10% auto;
                width: 95%;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('partners.index') }}" class="back-link">
            ← Retour aux partenaires
        </a>

        <div class="header">
            <h1>Types de Partenaires</h1>
            <p>Gérez les différents types de partenaires de votre écosystème</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Statistiques -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ count($partnerTypes) }}</div>
                <div class="stat-label">Types créés</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $partnerTypes->sum('partners_count') }}</div>
                <div class="stat-label">Partenaires total</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $partnerTypes->where('partners_count', 0)->count() }}</div>
                <div class="stat-label">Types inutilisés</div>
            </div>
        </div>

        <div class="actions-bar">
            <div>
                <span style="color: #666; font-weight: 600;">{{ count($partnerTypes) }} type(s) de partenaire</span>
            </div>
            <button class="btn btn-primary" onclick="openCreateModal()">
                + Nouveau Type
            </button>
        </div>

        @if(count($partnerTypes) > 0)
            <div class="cards-grid">
                @foreach($partnerTypes as $type)
                    <div class="type-card">
                        <div class="type-header">
                            <div>
                                <div class="type-name">{{ $type->name }}</div>
                            </div>
                            <div class="partners-count">
                                {{ $type->partners_count }} partenaire(s)
                            </div>
                        </div>
                        
                        <div class="type-description">
                            {{ $type->description }}
                        </div>

                        <div class="type-actions">
                            <button class="btn btn-edit btn-small" onclick="editType({{ $type->id }})">
                                ✏️ Modifier
                            </button>
                            <button class="btn btn-danger btn-small" onclick="deleteType({{ $type->id }}, '{{ $type->name }}')" 
                                    {{ $type->partners_count > 0 ? 'disabled' : '' }}
                                    title="{{ $type->partners_count > 0 ? 'Impossible de supprimer: ce type est utilisé par des partenaires' : 'Supprimer ce type' }}">
                                🗑️ Supprimer
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <h3>Aucun type de partenaire</h3>
                <p>Commencez par créer votre premier type de partenaire pour organiser vos partenariats.</p>
                <button class="btn btn-primary" onclick="openCreateModal()">
                    Créer le premier type
                </button>
            </div>
        @endif
    </div>

    <!-- Modal Création/Modification -->
    <div id="typeModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="modalTitle">Nouveau Type de Partenaire</h2>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <form id="typeForm" method="POST">
                @csrf
                <div id="methodField"></div>
                
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="form-label">Nom du type *</label>
                        <input type="text" id="name" name="name" class="form-input" required maxlength="50" 
                               placeholder="Ex: Recycleur, Distributeur, Transformateur...">
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">Description *</label>
                        <textarea id="description" name="description" class="form-input form-textarea" required
                                  placeholder="Décrivez le rôle et les activités de ce type de partenaire..."></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <span id="submitText">Enregistrer</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Variables globales
        let currentTypeId = null;
        const modal = document.getElementById('typeModal');
        const form = document.getElementById('typeForm');
        const modalTitle = document.getElementById('modalTitle');
        const methodField = document.getElementById('methodField');
        const submitText = document.getElementById('submitText');

        // Ouvrir modal de création
        function openCreateModal() {
            currentTypeId = null;
            modalTitle.textContent = 'Nouveau Type de Partenaire';
            submitText.textContent = 'Créer';
            form.action = '{{ route("partner-types.store") }}';
            methodField.innerHTML = '';
            
            // Reset form
            document.getElementById('name').value = '';
            document.getElementById('description').value = '';
            
            modal.style.display = 'block';
            document.getElementById('name').focus();
        }

        // Modifier un type
        async function editType(id) {
            currentTypeId = id;
            
            try {
                const response = await fetch(`/partner-types/${id}/edit`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                if (!response.ok) {
                    throw new Error('Erreur lors du chargement');
                }
                
                const type = await response.json();
                
                modalTitle.textContent = 'Modifier le Type';
                submitText.textContent = 'Mettre à jour';
                form.action = `/partner-types/${id}`;
                methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                
                document.getElementById('name').value = type.name;
                document.getElementById('description').value = type.description;
                
                modal.style.display = 'block';
                document.getElementById('name').focus();
            } catch (error) {
                console.error('Erreur:', error);
                alert('Erreur lors du chargement des données');
            }
        }

        // Supprimer un type
        async function deleteType(id, name) {
            if (!confirm(`Êtes-vous sûr de vouloir supprimer le type "${name}" ?\n\nCette action est irréversible.`)) {
                return;
            }

            try {
                const response = await fetch(`/partner-types/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });

                // Vérifier si la réponse est ok
                if (!response.ok) {
                    console.error('Erreur HTTP:', response.status, response.statusText);
                    // Essayer de lire le message d'erreur
                    try {
                        const errorData = await response.json();
                        alert(errorData.message || `Erreur HTTP ${response.status}: ${response.statusText}`);
                    } catch (e) {
                        alert(`Erreur HTTP ${response.status}: ${response.statusText}`);
                    }
                    return;
                }

                // Tenter de parser la réponse JSON
                let result;
                try {
                    result = await response.json();
                } catch (e) {
                    console.error('Erreur parsing JSON:', e);
                    // Si on ne peut pas parser le JSON, considérer que c'est un succès
                    console.log('Suppression probablement réussie, rechargement de la page...');
                    location.reload();
                    return;
                }

                if (result.success) {
                    // Animation de disparition avant rechargement
                    const card = event.target.closest('.type-card');
                    if (card) {
                        card.style.transition = 'all 0.3s ease';
                        card.style.transform = 'scale(0.8)';
                        card.style.opacity = '0';
                        setTimeout(() => {
                            location.reload();
                        }, 300);
                    } else {
                        location.reload();
                    }
                } else {
                    alert(result.message || 'Erreur lors de la suppression');
                }
            } catch (error) {
                console.error('Erreur réseau ou autre:', error);
                // En cas d'erreur réseau, vérifier si la suppression a quand même eu lieu
                if (confirm('Une erreur s\'est produite. Voulez-vous actualiser la page pour vérifier si la suppression a eu lieu ?')) {
                    location.reload();
                } else {
                    alert('Erreur lors de la suppression: ' + error.message);
                }
            }
        }

        // Fermer modal
        function closeModal() {
            modal.style.display = 'none';
        }

        // Fermer modal en cliquant à l'extérieur
        window.onclick = function(event) {
            if (event.target === modal) {
                closeModal();
            }
        }

        // Fermer modal avec Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && modal.style.display === 'block') {
                closeModal();
            }
        });

        // Gestion du formulaire
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Désactiver le bouton de soumission
            const submitBtn = document.querySelector('#typeForm button[type="submit"]');
            const originalText = submitText.textContent;
            submitBtn.disabled = true;
            submitText.textContent = 'Enregistrement...';
            
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    // Fermer la modal avec animation
                    modal.style.opacity = '0';
                    setTimeout(() => {
                        location.reload();
                    }, 200);
                } else {
                    return response.json().then(data => {
                        throw new Error(data.message || 'Erreur de validation');
                    });
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de l\'enregistrement: ' + error.message);
                
                // Réactiver le bouton
                submitBtn.disabled = false;
                submitText.textContent = originalText;
            });
        });

        // Animation d'entrée des cartes
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.type-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>