@extends('dashboard')

@section('content')
<h1>Items dans la catégorie : {{ $category->name }}</h1>

@if($items->count())
    <ul>
        @foreach($items as $item)
            <li>
                <strong>{{ $item->name }}</strong> - {{ $item->description }}
                @if($item->image_url)
                    <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}" width="100">
                @endif
            </li>
        @endforeach
    </ul>
@else
    <p>Aucun item dans cette catégorie.</p>
@endif

<a href="{{ route('items.index') }}">Retour à tous les items</a>
@endsection
