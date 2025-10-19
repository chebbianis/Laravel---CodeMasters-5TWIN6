<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vue Carte - Partenaires</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 2rem;
        }

        .container {
            max-width: 1600px;
            margin: 0 auto;
        }

        .header {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            color: #333;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn-back {
            padding: 0.8rem 1.5rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: transform 0.3s;
        }

        .btn-back:hover {
            transform: translateY(-2px);
        }

        .map-layout {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 2rem;
            min-height: 600px;
        }

        .sidebar-filters {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            max-height: 800px;
            overflow-y: auto;
        }

        .sidebar-filters h3 {
            color: #333;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-group {
            margin-bottom: 1.5rem;
        }

        .filter-group label {
            display: block;
            color: #555;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .filter-group input,
        .filter-group select {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
        }

        .filter-group input:focus,
        .filter-group select:focus {
            outline: none;
            border-color: #667eea;
        }

        .checkbox-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .checkbox-group label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: normal;
            cursor: pointer;
        }

        .checkbox-group input[type="checkbox"] {
            width: auto;
        }

        .btn-filter {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .btn-reset {
            width: 100%;
            padding: 0.8rem;
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 0.5rem;
            transition: all 0.3s;
        }

        .btn-reset:hover {
            background: #f8f9fa;
        }

        .map-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            overflow: hidden;
            position: relative;
            min-height: 800px;
        }

        #map {
            height: 800px;
            width: 100%;
            position: relative;
            z-index: 1;
        }

        .results-count {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: white;
            padding: 0.8rem 1.2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            font-weight: 600;
            color: #333;
        }
        
        .loading-indicator {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 2rem 3rem;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            z-index: 2000;
            text-align: center;
        }
        
        .loading-indicator.hidden {
            display: none;
        }
        
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .progress-text {
            color: #333;
            font-weight: 600;
            margin-top: 0.5rem;
        }
        
        .geocode-stats {
            margin-top: 1rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
            font-size: 0.85rem;
        }
        
        .geocode-stats .stat-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }
        
        .geocode-stats .stat-value {
            font-weight: 700;
            color: #667eea;
        }

        .partner-list {
            margin-top: 1.5rem;
            max-height: 400px;
            overflow-y: auto;
        }

        .partner-item {
            padding: 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .partner-item:hover {
            background: #f8f9fa;
            border-color: #667eea;
        }

        .partner-item h4 {
            color: #333;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .partner-item .type-badge {
            display: inline-block;
            padding: 0.2rem 0.6rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .type-ong { background: #d4edda; color: #155724; }
        .type-municipalite { background: #cce5ff; color: #004085; }
        .type-entreprise { background: #fff3cd; color: #856404; }
        .type-association { background: #d1ecf1; color: #0c5460; }
        .type-etablissement { background: #e2e3f0; color: #383d41; }

        .toggle-view {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .toggle-btn {
            flex: 1;
            padding: 0.8rem;
            border: 2px solid #e2e8f0;
            background: white;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
        }

        .toggle-btn.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-color: #667eea;
        }

        @media (max-width: 1024px) {
            .map-layout {
                grid-template-columns: 1fr;
            }

            .sidebar-filters {
                max-height: none;
            }

            #map {
                height: 500px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>
                <span>🗺️</span>
                Carte Interactive des Partenaires
            </h1>
            <a href="{{ route('partners.list') }}" class="btn-back">← Retour à la Liste</a>
        </div>

        <div class="map-layout">
            <!-- Sidebar avec filtres -->
            <div class="sidebar-filters">
                <h3>🔍 Filtres de Recherche</h3>

                <div class="toggle-view">
                    <button class="toggle-btn active" onclick="showMap()">🗺️ Carte</button>
                    <button class="toggle-btn" onclick="showList()">📋 Liste</button>
                </div>

                <div class="filter-group">
                    <label for="searchInput">Rechercher</label>
                    <input type="text" id="searchInput" placeholder="Nom du partenaire...">
                </div>

                <div class="filter-group">
                    <label>Type de Partenaire</label>
                    <div class="checkbox-group">
                        @foreach($partnerTypes as $type)
                        <label>
                            <input type="checkbox" class="type-filter" value="{{ $type->name }}" checked>
                            {{ $type->name }}
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="filter-group">
                    <label>Statut</label>
                    <div class="checkbox-group">
                        <label>
                            <input type="checkbox" id="showActive" checked>
                            Actifs
                        </label>
                        <label>
                            <input type="checkbox" id="showInactive">
                            Inactifs
                        </label>
                    </div>
                </div>

                <div class="filter-group">
                    <label>Moyens de Contact</label>
                    <div class="checkbox-group">
                        <label>
                            <input type="checkbox" id="hasEmail" checked>
                            Avec Email
                        </label>
                        <label>
                            <input type="checkbox" id="hasPhone">
                            Avec Téléphone
                        </label>
                        <label>
                            <input type="checkbox" id="hasWebsite">
                            Avec Site Web
                        </label>
                    </div>
                </div>

                <button class="btn-filter" onclick="applyFilters()">Appliquer les Filtres</button>
                <button class="btn-reset" onclick="resetFilters()">Réinitialiser</button>

                <div class="geocode-stats" id="geocodeStats" style="display: none;">
                    <h4 style="margin-bottom: 0.8rem; color: #333;">📊 Statistiques de Géolocalisation</h4>
                    <div class="stat-item">
                        <span>Adresses géocodées:</span>
                        <span class="stat-value" id="geocodedStat">0</span>
                    </div>
                    <div class="stat-item">
                        <span>Positions par défaut:</span>
                        <span class="stat-value" id="fallbackStat">0</span>
                    </div>
                    <div class="stat-item">
                        <span>Total:</span>
                        <span class="stat-value" id="totalStat">0</span>
                    </div>
                </div>

                <div class="partner-list">
                    <h4 style="margin-bottom: 1rem; color: #333;">Résultats (<span id="count">{{ $partners->count() }}</span>)</h4>
                    <div id="partnersList">
                        @foreach($partners as $partner)
                        <div class="partner-item" onclick="focusPartner({{ $partner->id }})">
                            <h4>{{ $partner->name }}</h4>
                            <span class="type-badge type-{{ strtolower(str_replace([' ', 'é'], ['', 'e'], $partner->type->name ?? '')) }}">
                                {{ $partner->type->name ?? 'N/A' }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Carte -->
            <div class="map-container">
                <div class="loading-indicator" id="loadingIndicator">
                    <div class="spinner"></div>
                    <h3>Géolocalisation en cours...</h3>
                    <p class="progress-text"><span id="progressText">0</span> / <span id="totalCount">0</span> partenaires traités</p>
                </div>
                
                <div class="results-count">
                    <span id="mapCount">{{ $partners->count() }}</span> partenaire(s) trouvé(s)
                </div>
                <div id="map"></div>
            </div>
        </div>
    </div>

    <script>
        // Attendre que le DOM soit complètement chargé
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🚀 Initialisation de la carte...');
            console.log('📊 Nombre de partenaires:', {{ $partners->count() }});
            
            // Initialiser la carte
            const map = L.map('map').setView([48.8566, 2.3522], 6); // Centré sur Paris
            
            console.log('✅ Carte Leaflet créée');

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: ' &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            
            console.log('✅ Tuiles OpenStreetMap ajoutées');

            // Couleurs par type
            const typeColors = {
                'ONG': '#28a745',
                'Municipalité': '#007bff',
                'Entreprise': '#ffc107',
                'Association': '#17a2b8',
                'Établissement Public': '#6f42c1'
            };

            // Markers des partenaires
            const markers = [];
            
            // Cache pour les coordonnées géocodées
            const geocodeCache = {};
            
            // Fonction de géocodage avec cache
            async function geocodeAddress(address, partnerId) {
            if (!address || address.trim() === '') {
                return null;
            }
            
            // Vérifier le cache
            if (geocodeCache[address]) {
                return geocodeCache[address];
            }
            
            try {
                // Utiliser l'API Nominatim (gratuite, pas de clé requise)
                const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}&limit=1`;
                const response = await fetch(url, {
                    headers: {
                        'User-Agent': 'WasteManagement/1.0'
                    }
                });
                
                const data = await response.json();
                
                if (data && data.length > 0) {
                    const coords = {
                        lat: parseFloat(data[0].lat),
                        lng: parseFloat(data[0].lon)
                    };
                    geocodeCache[address] = coords;
                    return coords;
                }
            } catch (error) {
                console.error('Erreur de géocodage pour', address, ':', error);
            }
            
            return null;
            }
            
            // Fonction pour créer un marqueur
            function createMarker(partnerId, lat, lng, partnerData) {
            const marker = L.circleMarker([lat, lng], {
                radius: 10,
                fillColor: typeColors[partnerData.type] || '#6f42c1',
                color: '#fff',
                weight: 2,
                opacity: 1,
                fillOpacity: 0.8
            }).addTo(map);

            marker.bindPopup(`
                <div style="padding: 0.5rem;">
                    <h4 style="margin-bottom: 0.5rem;">${partnerData.name}</h4>
                    <p style="margin-bottom: 0.3rem;"><strong>Type:</strong> ${partnerData.type}</p>
                    <p style="margin-bottom: 0.3rem;"><strong>Adresse:</strong> ${partnerData.address || 'N/A'}</p>
                    <p style="margin-bottom: 0.3rem;"><strong>Email:</strong> ${partnerData.email}</p>
                    ${partnerData.phone ? `<p style="margin-bottom: 0.3rem;"><strong>Tél:</strong> ${partnerData.phone}</p>` : ''}
                    ${partnerData.website ? `<p style="margin-bottom: 0.3rem;"><strong>Web:</strong> <a href="${partnerData.website}" target="_blank">Visiter</a></p>` : ''}
                </div>
            `);

            markers.push({
                id: partnerId,
                marker: marker,
                name: partnerData.name,
                type: partnerData.type,
                active: partnerData.active,
                hasEmail: partnerData.hasEmail,
                hasPhone: partnerData.hasPhone,
                hasWebsite: partnerData.hasWebsite
            });
            }
            
            // Charger et géocoder tous les partenaires
            const partners = [
            @foreach($partners as $partner)
            {
                id: {{ $partner->id }},
                name: '{{ addslashes($partner->name) }}',
                type: '{{ $partner->type->name ?? 'N/A' }}',
                address: '{{ addslashes($partner->address ?? '') }}',
                email: '{{ $partner->contact_email }}',
                phone: '{{ $partner->phone ?? '' }}',
                website: '{{ $partner->website ?? '' }}',
                active: {{ $partner->is_active ? 'true' : 'false' }},
                hasEmail: {{ $partner->contact_email ? 'true' : 'false' }},
                hasPhone: {{ $partner->phone ? 'true' : 'false' }},
                hasWebsite: {{ $partner->website ? 'true' : 'false' }}
            }{{ !$loop->last ? ',' : '' }}
            @endforeach
            ];
            
            // Fonction pour initialiser la carte avec géocodage RÉEL
            async function initializeMap() {
                let geocodedCount = 0;
                let fallbackCount = 0;
                
                const loadingIndicator = document.getElementById('loadingIndicator');
                const progressText = document.getElementById('progressText');
                const totalCount = document.getElementById('totalCount');
                
                // Afficher l'indicateur de chargement
                loadingIndicator.classList.remove('hidden');
                totalCount.textContent = partners.length;
                
                // IMPORTANT: Forcer la carte à se redimensionner correctement
                setTimeout(() => {
                    map.invalidateSize();
                }, 50);
                
                console.log('🌍 Début du géocodage des adresses...');
                
                // Traiter les partenaires un par un pour le géocodage
                for (let i = 0; i < partners.length; i++) {
                    const partner = partners[i];
                    
                    // Mettre à jour la progression
                    progressText.textContent = i + 1;
                    
                    let coords = null;
                    
                    // Essayer de géocoder l'adresse si elle existe
                    if (partner.address && partner.address.trim() !== '') {
                        console.log(`📍 Géocodage: ${partner.name} - ${partner.address}`);
                        coords = await geocodeAddress(partner.address, partner.id);
                        
                        // Attendre 1 seconde entre chaque requête pour respecter les limites de l'API
                        if (i < partners.length - 1) {
                            await new Promise(resolve => setTimeout(resolve, 1000));
                        }
                    }
                    
                    // Si le géocodage a échoué ou pas d'adresse, utiliser une position par défaut
                    if (!coords) {
                        console.log(`⚠️ Pas d'adresse ou échec pour: ${partner.name}`);
                        coords = {
                            lat: 48.8566 + (Math.random() - 0.5) * 5,
                            lng: 2.3522 + (Math.random() - 0.5) * 5
                        };
                        fallbackCount++;
                    } else {
                        console.log(`✅ Géocodé: ${partner.name} -> ${coords.lat}, ${coords.lng}`);
                        geocodedCount++;
                    }
                    
                    // Créer le marqueur
                    createMarker(partner.id, coords.lat, coords.lng, partner);
                }
                
                // Cacher l'indicateur de chargement
                loadingIndicator.classList.add('hidden');
                
                // Mettre à jour les compteurs
                document.getElementById('mapCount').textContent = partners.length;
                document.getElementById('count').textContent = partners.length;
                
                // Ajuster la vue pour inclure tous les marqueurs
                if (markers.length > 0) {
                    const group = L.featureGroup(markers.map(m => m.marker));
                    map.fitBounds(group.getBounds().pad(0.1));
                }
                
                // Forcer à nouveau le recalcul de la taille
                setTimeout(() => {
                    map.invalidateSize();
                }, 200);
                
                // Afficher les statistiques
                console.log(`✅ Géocodage terminé:`);
                console.log(`   📍 ${geocodedCount} adresses géocodées avec succès`);
                console.log(`   📌 ${fallbackCount} positions par défaut`);
                console.log(`   🗺️ Total: ${partners.length} partenaires`);
                
                // Afficher les stats dans la sidebar
                document.getElementById('geocodedStat').textContent = geocodedCount;
                document.getElementById('fallbackStat').textContent = fallbackCount;
                document.getElementById('totalStat').textContent = partners.length;
                document.getElementById('geocodeStats').style.display = 'block';
                
                // Afficher un message de succès
                if (geocodedCount > 0) {
                    const successMsg = document.createElement('div');
                    successMsg.style.cssText = `
                        position: fixed;
                        top: 2rem;
                        right: 2rem;
                        background: #28a745;
                        color: white;
                        padding: 1rem 1.5rem;
                        border-radius: 8px;
                        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
                        z-index: 3000;
                        font-weight: 600;
                    `;
                    successMsg.innerHTML = `
                        ✅ ${geocodedCount} adresse(s) géolocalisée(s) !
                    `;
                    document.body.appendChild(successMsg);
                    
                    setTimeout(() => {
                        successMsg.remove();
                    }, 5000);
                }
            }
            
            // Initialiser la carte au chargement
            initializeMap();

            // Rendre les fonctions globales pour les événements onclick
            window.focusPartner = function(id) {
            const markerData = markers.find(m => m.id === id);
            if (markerData) {
                map.setView(markerData.marker.getLatLng(), 12);
                markerData.marker.openPopup();
            }
            };

            window.applyFilters = function() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const typeFilters = Array.from(document.querySelectorAll('.type-filter:checked')).map(cb => cb.value);
            const showActive = document.getElementById('showActive').checked;
            const showInactive = document.getElementById('showInactive').checked;
            const hasEmail = document.getElementById('hasEmail').checked;
            const hasPhone = document.getElementById('hasPhone').checked;
            const hasWebsite = document.getElementById('hasWebsite').checked;

            let visibleCount = 0;

            markers.forEach(markerData => {
                let visible = true;

                // Filtre par nom
                if (searchTerm && !markerData.name.toLowerCase().includes(searchTerm)) {
                    visible = false;
                }

                // Filtre par type
                if (!typeFilters.includes(markerData.type)) {
                    visible = false;
                }

                // Filtre par statut
                if (!showActive && markerData.active) visible = false;
                if (!showInactive && !markerData.active) visible = false;

                // Filtres contact
                if (hasEmail && !markerData.hasEmail) visible = false;
                if (hasPhone && !markerData.hasPhone) visible = false;
                if (hasWebsite && !markerData.hasWebsite) visible = false;

                if (visible) {
                    markerData.marker.addTo(map);
                    visibleCount++;
                } else {
                    map.removeLayer(markerData.marker);
                }
            });

            document.getElementById('count').textContent = visibleCount;
            document.getElementById('mapCount').textContent = visibleCount;
            };

            window.resetFilters = function() {
            document.getElementById('searchInput').value = '';
            document.querySelectorAll('.type-filter').forEach(cb => cb.checked = true);
            document.getElementById('showActive').checked = true;
            document.getElementById('showInactive').checked = false;
            document.getElementById('hasEmail').checked = false;
            document.getElementById('hasPhone').checked = false;
            document.getElementById('hasWebsite').checked = false;
            applyFilters();
            };

            window.showMap = function() {
            document.querySelector('.toggle-btn.active').classList.remove('active');
            event.target.classList.add('active');
            // Implémentation future
            };

            window.showList = function() {
            document.querySelector('.toggle-btn.active').classList.remove('active');
            event.target.classList.add('active');
            // Implémentation future
            };

            // Recherche en temps réel
            document.getElementById('searchInput').addEventListener('input', applyFilters);
            
            // Forcer le recalcul de la taille lors du redimensionnement
            window.addEventListener('resize', () => {
                map.invalidateSize();
            });
            
            // S'assurer que la carte est correctement dimensionnée
            setTimeout(() => {
                map.invalidateSize();
            }, 500);
        
        }); // Fin du DOMContentLoaded
    </script>
</body>
</html>
