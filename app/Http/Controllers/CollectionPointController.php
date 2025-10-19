<?php

namespace App\Http\Controllers;

use App\Models\CollectionPoint;
use App\Models\User;
use Illuminate\Http\Request;

class CollectionPointController extends Controller
{
    // Affiche tous les points de collecte
    public function points()
    {
        $points = CollectionPoint::with('responsible')->get(); // récupère tous les points avec le responsable
        $users = User::all(); // pour le filtre responsable

        return view('collection.points', compact('points', 'users'));
    }

    // Formulaire de création
    public function create()
    {
        $users = User::all(); // pour choisir un responsable
        return view('collection.create', compact('users'));
    }

    // Enregistre un nouveau point
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'responsible_user_id' => 'required|exists:users,id',
            'opening_hours' => 'nullable|string|max:255',
            'contact_info' => 'nullable|string|max:255',
            'status' => 'required|in:active,saturated,closed',
        ]);

        CollectionPoint::create($request->all());

        return redirect()->route('collection.points')->with('success', 'Point de collecte ajouté !');
    }

    // Formulaire d'édition
    public function edit(CollectionPoint $collectionPoint)
    {
        $users = User::all();
        return view('collection.edit', compact('collectionPoint', 'users'));
    }

    // Met à jour un point existant
    public function update(Request $request, CollectionPoint $collectionPoint)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'responsible_user_id' => 'required|exists:users,id',
            'opening_hours' => 'nullable|string|max:255',
            'contact_info' => 'nullable|string|max:255',
            'status' => 'required|in:active,saturated,closed',
        ]);

        $collectionPoint->update($request->all());

        return redirect()->route('collection.points')->with('success', 'Point de collecte mis à jour !');
    }

    // Supprime un point
    public function destroy(CollectionPoint $collectionPoint)
    {
        $collectionPoint->delete();
        return redirect()->route('collection.points')->with('success', 'Point de collecte supprimé !');
    }
}
