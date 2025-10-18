@extends('dashboard')

@section('content')
<div class="container" style="padding: 4rem 2rem;">

    <h1 style="text-align:center; margin-bottom:2rem; color:#333; font-size:2.5rem;">📦 Catalogue des Objets</h1>

    {{-- Barre de recherche --}}
    <div style="margin-bottom:2rem; text-align:center;">
        <input type="text" id="searchInput" placeholder="Rechercher un item..." 
               style="padding:0.75rem; width:50%; border:1px solid #ccc; border-radius:5px;">
    </div>

    {{-- Boutons de tri et filtre favoris --}}
    <div style="margin-bottom:2rem; text-align:center;">
        <button class="btn-sort" data-type="name" style="margin-right:1rem;">Trier par Nom</button>
        <button class="btn-sort" data-type="category" style="margin-right:1rem;">Trier par Catégorie</button>
        <button class="btn-sort" data-type="status" style="margin-right:1rem;">Trier par Statut</button>
        <button id="showFavorites" class="btn-sort">⭐ Mes favoris</button>
    </div>

    {{-- Statistiques (initialement cachées) --}}
    <div id="statsSection" style="display:none; flex-wrap:wrap; gap:2rem; justify-content:center; margin-bottom:3rem;">
        <div style="width:300px;">
            <h3 style="text-align:center;">Objets par Catégorie</h3>
            <canvas id="categoryChart"></canvas>
        </div>
        <div style="width:300px;">
            <h3 style="text-align:center;">Objets par Statut</h3>
            <canvas id="statusChart"></canvas>
        </div>
    </div>
    <div style="text-align:center; margin-bottom:2rem;">
        <button id="toggleStats" class="btn-sort">📊 Afficher/Masquer Statistiques</button>
    </div>

    {{-- Catalogue --}}
    <div id="items-grid" class="features-grid" style="display:grid; grid-template-columns:repeat(auto-fit,minmax(250px,1fr)); gap:2rem;">
        @foreach($items as $item)
        <div class="feature-card" 
             data-id="{{ $item->id }}"
             data-name="{{ strtolower($item->name) }}" 
             data-category="{{ strtolower($item->category->name ?? '') }}"
             data-status="{{ strtolower($item->status) }}"
             style="background:white; padding:1.8rem; border-radius:15px; box-shadow:0 10px 25px rgba(0,0,0,0.15); transition: transform 0.3s;">
            @if($item->image_url)
                <img src="{{ asset('storage/'.$item->image_url) }}" alt="{{ $item->name }}" 
                     style="width:100%; height:180px; object-fit:cover; border-radius:10px; margin-bottom:1rem;">
            @else
                <img src="https://via.placeholder.com/250x180" alt="Placeholder" 
                     style="width:100%; height:180px; object-fit:cover; border-radius:10px; margin-bottom:1rem;">
            @endif
            <h3>{{ $item->name }}</h3>
            <p><strong>Catégorie:</strong> {{ $item->category->name ?? 'N/A' }}</p>
            <p><strong>État:</strong> {{ $item->condition }}</p>
            <p><strong>Statut:</strong> {{ $item->status }}</p>

            {{-- Actions rapides --}}
            <div style="margin-top:1rem; text-align:center; display:flex; justify-content:space-around; gap:0.5rem;">
                <a href="{{ route('items.show', $item->id) }}" class="btn-action" title="Voir détails">👁️</a>
                @can('update', $item)
                    <a href="{{ route('items.edit', $item->id) }}" class="btn-action" title="Éditer">✏️</a>
                @endcan
                @can('delete', $item)
                    <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action" title="Supprimer" onclick="return confirm('Supprimer cet objet ?');">🗑️</button>
                    </form>
                @endcan
                <button class="btn-action btn-favorite" data-id="{{ $item->id }}" title="Ajouter aux favoris">⭐</button>
            </div>

            {{-- Checkbox comparaison --}}
            <div style="margin-top:1rem; text-align:center;">
                <input type="checkbox" class="compare-checkbox" data-id="{{ $item->id }}">
                <label>Comparer</label>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Modal comparaison --}}
    <div id="compareModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; 
         background:rgba(0,0,0,0.7); justify-content:center; align-items:center; z-index:2000;">
        <div style="background:white; padding:2rem; border-radius:15px; max-width:900px; width:90%; position:relative;">
            <span id="closeModal" style="position:absolute; top:1rem; right:1rem; cursor:pointer; font-size:1.5rem;">&times;</span>
            <h2 style="text-align:center; margin-bottom:1.5rem;">Comparaison des Objets</h2>
            <div id="compareContent" style="display:flex; gap:1rem; flex-wrap:wrap; justify-content:center;"></div>
        </div>
    </div>

</div>

<style>
.feature-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.25); }
.btn-sort { padding:0.5rem 1rem; background:#667eea; color:white; border:none; border-radius:5px; cursor:pointer; margin-bottom:0.5rem; }
.btn-sort:hover { background:#556cd6; }
.compare-card { border:1px solid #ccc; padding:1rem; border-radius:10px; width:250px; }
.btn-action { background:#f5f5f5; border:none; border-radius:5px; padding:0.4rem 0.6rem; cursor:pointer; font-size:1.1rem; transition:0.2s; }
.btn-action:hover { background:#e2e2e2; }
.btn-favorite.active { color: gold; }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const itemsGrid = document.getElementById('items-grid');
    const cards = Array.from(itemsGrid.querySelectorAll('.feature-card'));
    const searchInput = document.getElementById('searchInput');
    const statusOrder = ['disponible', 'transformé', 'recyclé'];

    // --- Recherche ---
    searchInput.addEventListener('input', () => {
        const query = searchInput.value.toLowerCase();
        cards.forEach(card => {
            const name = card.dataset.name;
            const category = card.dataset.category;
            const status = card.dataset.status;
            card.style.display = (name.includes(query) || category.includes(query) || status.includes(query)) ? '' : 'none';
        });
    });

    // --- Tri ---
    document.querySelectorAll('.btn-sort').forEach(btn => {
        btn.addEventListener('click', () => {
            const type = btn.dataset.type;
            if(type){
                let sorted = [...cards];
                if(type === 'name') sorted.sort((a,b) => a.dataset.name.localeCompare(b.dataset.name));
                else if(type === 'category') sorted.sort((a,b) => a.dataset.category.localeCompare(b.dataset.category));
                else if(type === 'status') sorted.sort((a,b) => statusOrder.indexOf(a.dataset.status) - statusOrder.indexOf(b.dataset.status));
                sorted.forEach(c => itemsGrid.appendChild(c));
            }
        });
    });

    // --- Favoris ---
    const favoriteButtons = document.querySelectorAll('.btn-favorite');
    let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
    favoriteButtons.forEach(btn => { if(favorites.includes(btn.dataset.id)) btn.classList.add('active'); });
    favoriteButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            if(favorites.includes(id)){
                favorites = favorites.filter(f => f !== id);
                btn.classList.remove('active');
            } else {
                favorites.push(id);
                btn.classList.add('active');
            }
            localStorage.setItem('favorites', JSON.stringify(favorites));
        });
    });
    document.getElementById('showFavorites').addEventListener('click', () => {
        cards.forEach(card => {
            card.style.display = favorites.includes(card.dataset.id) ? '' : 'none';
        });
    });

    // --- Comparaison ---
    const compareModal = document.getElementById('compareModal');
    const compareContent = document.getElementById('compareContent');
    const closeModal = document.getElementById('closeModal');
    const selectedIds = [];
    document.querySelectorAll('.compare-checkbox').forEach(cb => {
        cb.addEventListener('change', (e) => {
            const id = e.target.dataset.id;
            if(e.target.checked) selectedIds.push(id);
            else selectedIds.splice(selectedIds.indexOf(id),1);

            if(selectedIds.length > 0){
                compareContent.innerHTML = '';
                selectedIds.slice(0,3).forEach(id => {
                    const card = cards.find(c => c.dataset.id === id);
                    compareContent.innerHTML += `<div class="compare-card">${card.innerHTML}</div>`;
                });
                compareModal.style.display = 'flex';
            } else { compareModal.style.display = 'none'; }
        });
    });
    closeModal.addEventListener('click', () => { compareModal.style.display = 'none'; });

    // --- Statistiques ---
    const statsSection = document.getElementById('statsSection');
    const toggleStats = document.getElementById('toggleStats');
    toggleStats.addEventListener('click', () => { statsSection.style.display = statsSection.style.display === 'flex' ? 'none' : 'flex'; });

    const categoryLabels = JSON.parse('@json(array_keys($stats["by_category"]))');
    const categoryData   = JSON.parse('@json(array_values($stats["by_category"]))');
    const statusLabels   = JSON.parse('@json(array_keys($stats["by_status"]))');
    const statusData     = JSON.parse('@json(array_values($stats["by_status"]))');

    new Chart(document.getElementById('categoryChart'), {
        type: 'pie',
        data: { labels: categoryLabels, datasets: [{ data: categoryData, backgroundColor: ['#667eea','#764ba2','#f6ad55','#48bb78','#e53e3e'] }] }
    });
    new Chart(document.getElementById('statusChart'), {
        type: 'bar',
        data: { labels: statusLabels, datasets: [{ data: statusData, backgroundColor: ['#48bb78','#f6ad55','#e53e3e'] }] },
        options: { responsive:true, scales:{ y:{ beginAtZero:true } } }
    });
});
</script>
@endsection
