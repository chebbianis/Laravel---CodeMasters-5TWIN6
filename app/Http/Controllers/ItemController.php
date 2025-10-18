<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    // Affiche tous les items
    public function index()
    {
        $items = Item::with('category', 'creator')->get();
        return view('catalog.items', compact('items'));
    }

    // Formulaire de création
    public function create()
    {
        $categories = Category::all();
        return view('catalog.create_item', compact('categories'));
    }

    // Stockage d’un nouvel item
    public function store(ItemRequest $request)
    {
        $data = $request->validated();

        // Upload image si présente
        if ($request->hasFile('image_url')) {
            $data['image_url'] = $request->file('image_url')->store('items', 'public');
        }

        Item::create($data);

        return redirect()->route('items.index')->with('success', 'Item créé avec succès !');
    }

    // Formulaire d’édition
    public function edit(Item $item)
    {
        $categories = Category::all();
        return view('catalog.edit_item', compact('item', 'categories'));
    }

    // Mise à jour d’un item
    public function update(ItemRequest $request, Item $item)
    {
        $data = $request->validated();

        // Upload nouvelle image si présente
        if ($request->hasFile('image_url')) {
            // Supprimer l’ancienne image si elle existe
            if ($item->image_url && Storage::disk('public')->exists($item->image_url)) {
                Storage::disk('public')->delete($item->image_url);
            }
            $data['image_url'] = $request->file('image_url')->store('items', 'public');
        }

        $item->update($data);

        return redirect()->route('items.index')->with('success', 'Item mis à jour avec succès !');
    }
  
    // Suppression d’un item
    public function destroy(Item $item)
    {
        if ($item->image_url && Storage::disk('public')->exists($item->image_url)) {
            Storage::disk('public')->delete($item->image_url);
        }

        $item->delete();

        return redirect()->route('items.index')->with('success', 'Item supprimé avec succès !');
    }

    // Affiche les items d’une catégorie
    public function itemsByCategory($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $items = Item::where('category_id', $categoryId)
                     ->with('category', 'creator')
                     ->get();

        return view('catalog.items_by_category', compact('category', 'items'));
    }

    // Catalogue pour l’utilisateur
    public function catalogueUser()
    {
        $items = Item::with('category', 'creator')->get();
        return view('catalog.items', compact('items'));
    }
}
