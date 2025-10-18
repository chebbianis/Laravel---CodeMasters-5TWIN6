@extends('dashboard')

@section('content')
<h1 style="margin-bottom: 1.5rem;">Modifier Item</h1>

@if ($errors->any())
    <div style="background:#f8d7da;color:#842029;padding:1rem;border-radius:5px;margin-bottom:1.5rem;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>⚠️ {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data"
      style="max-width:700px;background:#fff;padding:2rem;border-radius:10px;box-shadow:0 5px 15px rgba(0,0,0,0.1);">
    @csrf
    @method('PUT')

<!-- Nom -->
    <div style="margin-bottom:1rem;">
        <label for="name" style="display:block;margin-bottom:0.5rem;font-weight:bold;">Nom</label>
        <input type="text" id="name" name="name" value="{{ $item->name ?? old('name') }}" placeholder="Nom de l'item"
               style="width:100%;padding:0.75rem;border:1px solid #ccc;border-radius:5px;" required>
    </div>

    <!-- Description -->
    <div style="margin-bottom:1rem;">
        <label for="description" style="display:block;margin-bottom:0.5rem;font-weight:bold;">Description</label>
        <textarea id="description" name="description" placeholder="Description de l'item" rows="4"
                  style="width:100%;padding:0.75rem;border:1px solid #ccc;border-radius:5px;">{{ $item->description ?? old('description') }}</textarea>
    </div>

    <!-- Catégorie -->
    <div style="margin-bottom:1rem;">
        <label for="category_id" style="display:block;margin-bottom:0.5rem;font-weight:bold;">Catégorie</label>
        <select id="category_id" name="category_id" style="width:100%;padding:0.75rem;border:1px solid #ccc;border-radius:5px;" required>
            <option value="">-- Sélectionner une catégorie --</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" 
                    {{ (isset($item) && $item->category_id == $category->id) ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Condition -->
    <div style="margin-bottom:1rem;">
        <label for="condition" style="display:block;margin-bottom:0.5rem;font-weight:bold;">Condition</label>
        <select id="condition" name="condition" style="width:100%;padding:0.75rem;border:1px solid #ccc;border-radius:5px;" required>
            <option value="">-- Sélectionner la condition --</option>
            <option value="bon" {{ (isset($item) && $item->condition=='bon') ? 'selected' : '' }}>Bon</option>
            <option value="moyen" {{ (isset($item) && $item->condition=='moyen') ? 'selected' : '' }}>Moyen</option>
            <option value="à réparer" {{ (isset($item) && $item->condition=='à réparer') ? 'selected' : '' }}>À réparer</option>
        </select>
    </div>

    <!-- Statut -->
    <div style="margin-bottom:1rem;">
        <label for="status" style="display:block;margin-bottom:0.5rem;font-weight:bold;">Statut</label>
        <select id="status" name="status" style="width:100%;padding:0.75rem;border:1px solid #ccc;border-radius:5px;" required>
            <option value="">-- Sélectionner le statut --</option>
            <option value="disponible" {{ (isset($item) && $item->status=='disponible') ? 'selected' : '' }}>Disponible</option>
            <option value="transformé" {{ (isset($item) && $item->status=='transformé') ? 'selected' : '' }}>Transformé</option>
            <option value="recyclé" {{ (isset($item) && $item->status=='recyclé') ? 'selected' : '' }}>Recyclé</option>
        </select>
    </div>

    <!-- Image -->
    <div style="margin-bottom:1rem;">
        <label for="image_url" style="display:block;margin-bottom:0.5rem;font-weight:bold;">Image</label>
        <input type="file" id="image_url" name="image_url" style="width:100%;padding:0.5rem;border:1px solid #ccc;border-radius:5px;">
        @if(isset($item) && $item->image_url)
            <p style="margin-top:0.5rem;">Image actuelle : <img src="{{ asset('storage/'.$item->image_url) }}" alt="Image" style="max-width:150px;"></p>
        @endif
    </div>


    <button type="submit"
            style="padding:0.75rem 1.5rem;background:#667eea;color:white;border:none;border-radius:5px;font-weight:bold;cursor:pointer;transition:all 0.3s;">
        Mettre à jour
    </button>
</form>
@endsection
