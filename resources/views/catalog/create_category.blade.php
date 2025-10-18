@extends('dashboard')

@section('content')
<div style="max-width:600px; margin:auto; background:#fff; padding:2rem; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.08);">
    <h1 style="margin-bottom:1.5rem; font-size:1.5rem;">
        {{ isset($category) ? 'Modifier Catégorie' : 'Créer Catégorie' }}
    </h1>

    {{-- Affichage des erreurs --}}
    @if ($errors->any())
        <div style="margin-bottom:1rem; padding:1rem; background:#fee2e2; border:1px solid #fca5a5; border-radius:8px;">
            <ul style="margin:0; padding-left:1.2rem; color:#b91c1c;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($category) ? route('categories.update', $category->id) : route('categories.store') }}" method="POST">
        @csrf
        @if(isset($category)) @method('PUT') @endif

        <!-- Nom -->
        <div class="form-group" style="margin-bottom:1rem;">
            <label for="name" style="display:block; font-weight:500; margin-bottom:0.3rem;">Nom de la catégorie</label>
            <input type="text" id="name" name="name" 
                   value="{{ old('name', $category->name ?? '') }}" 
                   placeholder="Nom" required
                   style="width:100%; padding:0.8rem; border:2px solid #e2e8f0; border-radius:8px; font-size:1rem;">
        </div>

        <!-- Description -->
        <div class="form-group" style="margin-bottom:1rem;">
            <label for="description" style="display:block; font-weight:500; margin-bottom:0.3rem;">Description</label>
            <textarea id="description" name="description" placeholder="Description" rows="4"
                      style="width:100%; padding:0.8rem; border:2px solid #e2e8f0; border-radius:8px; font-size:1rem;">{{ old('description', $category->description ?? '') }}</textarea>
        </div>

        <!-- Couleur -->
        <div class="form-group" style="margin-bottom:1.5rem;">
            <label for="color_code" style="display:block; font-weight:500; margin-bottom:0.3rem;">Couleur</label>
            <input type="color" id="color_code" name="color_code" 
                   value="{{ old('color_code', $category->color_code ?? '#667eea') }}" required
                   style="width:60px; height:40px; border:none; cursor:pointer;">

            <div class="color-picker" style="display:flex; gap:0.5rem; margin-top:0.5rem;">
                @foreach(['#e3f2fd','#f3e5f5','#e8f5e8','#fff3e0','#e1f5fe','#f1f8e9','#667eea','#764ba2'] as $color)
                    <div onclick="document.getElementById('color_code').value='{{ $color }}'"
                         style="background: '{{ $color }}'; width:30px; height:30px; border-radius:50%; cursor:pointer; border:2px solid #ccc;">
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" 
                style="padding:0.8rem 2rem; background:#667eea; color:#fff; border:none; border-radius:10px; font-weight:500; cursor:pointer; transition:all 0.3s;">
            {{ isset($category) ? 'Mettre à jour' : 'Créer' }}
        </button>
    </form>
</div>
@endsection
