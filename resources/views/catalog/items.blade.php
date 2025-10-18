@extends('dashboard')
@section('content')
<div class="page-header" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;">
    <h1 style="font-size:2rem;font-weight:700;color:#333;">Catalogue des Objets</h1>
    <a href="{{ route('items.create') }}" style="padding:0.5rem 1rem;background:#007bff;color:white;border-radius:6px;text-decoration:none;font-weight:500;transition:0.3s;">+ Ajouter un Item</a>
</div>
@if(session('success'))
    <div style="margin-bottom:1.5rem;padding:1rem;border-radius:8px;background:#d4edda;color:#155724;font-weight:500;">
        {{ session('success') }}
    </div>
@endif

<div class="items-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:1.5rem;">
    @foreach($items as $item)
        <div class="item-card" style="border:1px solid #e0e0e0;border-radius:8px;padding:1rem;box-shadow:0 2px 8px rgba(0,0,0,0.05);transition:0.3s;display:flex;flex-direction:column;justify-content:space-between;">
            <div>
                @if($item->image_url)
                    <img src="{{ asset('storage/'.$item->image_url) }}" alt="{{ $item->name }}" style="width:100%;height:180px;object-fit:cover;border-radius:6px;margin-bottom:1rem;">
                @else
                    <img src="https://via.placeholder.com/300x180" alt="Placeholder" style="width:100%;height:180px;object-fit:cover;border-radius:6px;margin-bottom:1rem;">
                @endif
                <h3 style="font-size:1.2rem;font-weight:600;color:#333;margin-bottom:0.5rem;">{{ $item->name }}</h3>
                <p style="font-size:0.9rem;color:#555;margin-bottom:0.5rem;">{{ $item->description ?? 'Pas de description' }}</p>
                <p style="font-size:0.85rem;color:#666;margin-bottom:0.3rem;"><strong>Catégorie:</strong> {{ $item->category->name ?? 'N/A' }}</p>
                <p style="font-size:0.85rem;color:#666;margin-bottom:0.3rem;"><strong>Condition:</strong> {{ $item->condition }}</p>
                <p style="font-size:0.85rem;color:#666;margin-bottom:0.8rem;"><strong>Statut:</strong> {{ $item->status }}</p>
            </div>
            <div style="display:flex;justify-content:space-between;">
                <a href="{{ route('items.edit', $item->id) }}" style="padding:0.4rem 0.8rem;background:#ffc107;color:white;border-radius:5px;text-decoration:none;font-size:0.85rem;transition:0.3s;">Modifier</a>
                <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="margin:0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Supprimer cet item ?')" style="padding:0.4rem 0.8rem;background:#dc3545;color:white;border:none;border-radius:5px;font-size:0.85rem;cursor:pointer;transition:0.3s;">Supprimer</button>
                </form>
            </div>
        </div>
    @endforeach
</div>

<style>
.items-grid .item-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
a:hover {
    opacity: 0.85;
}
button:hover {
    opacity: 0.85;
}
</style>
@endsection
