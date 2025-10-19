<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\CollectionPoint;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    // Afficher la liste de tous les dépôts avec les données nécessaires pour le formulaire
    public function index()
    {
        $deposits = Deposit::with(['collectionPoint', 'item', 'depositor'])->get();
        $points = CollectionPoint::all();
        $items = Item::all();
        $users = User::all();

        return view('collection.deposits', compact('deposits', 'points', 'items', 'users'));
    }

    // Afficher le formulaire de création (optionnel si tu as tout dans la page index)
    public function create()
    {
        $points = CollectionPoint::all();
        $items = Item::all();
        $users = User::all();

        return view('collection.create_deposit', compact('points', 'items', 'users'));
    }

    // Enregistrer un nouveau dépôt
    public function store(Request $request)
    {
        $request->validate([
            'point_id' => 'required|exists:collection_points,id',
            'item_id' => 'required|exists:items,id',
            'deposit_date' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        Deposit::create([
            'point_id' => $request->point_id,
            'item_id' => $request->item_id,
            'depositor_user_id' => auth()->user()->id, // <- automatiquement
            'deposit_date' => $request->deposit_date,
            'quantity' => $request->quantity,
            'notes' => $request->notes,
        ]);

        return redirect()->route('collection.deposits')->with('success', 'Dépôt enregistré avec succès !');
    }


    // Formulaire d’édition
    public function edit(Deposit $deposit)
    {
        $points = CollectionPoint::all();
        $items = Item::all();
        $users = User::all();

        return view('collection.edit_deposit', compact('deposit', 'points', 'items', 'users'));
    }

    // Mise à jour d’un dépôt
    public function update(Request $request, Deposit $deposit)
    {
        $request->validate([
            'point_id' => 'required|exists:collection_points,id',
            'item_id' => 'required|exists:items,id',
            'depositor_user_id' => 'required|exists:users,id',
            'deposit_date' => 'required|date',
            'quantity' => 'required|numeric|min:1',
            'notes' => 'nullable|string|max:255',
        ]);

        $deposit->update($request->all());

        return redirect()->route('collection.deposits')->with('success', 'Dépôt mis à jour avec succès !');
    }

    // Supprimer un dépôt
    public function destroy(Deposit $deposit)
    {
        $deposit->delete();
        return redirect()->route('collection.deposits')->with('success', 'Dépôt supprimé avec succès !');
    }
}
