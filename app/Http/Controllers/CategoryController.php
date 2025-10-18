<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Afficher la liste des catégories
     */
    public function index()
    {
        $categories = Category::withCount('items')->orderBy('name')->get();
        return view('catalog.categories', compact('categories'));
    }

    /**
     * Créer une nouvelle catégorie
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'color_code' => 'required|string|max:7'
        ], [
            'name.required' => 'Le nom de la catégorie est obligatoire',
            'name.unique' => 'Cette catégorie existe déjà',
            'color_code.required' => 'La couleur est obligatoire'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'color_code' => $request->color_code
        ]);

        return redirect()->route('catalog.categories')
            ->with('success', 'Catégorie créée avec succès !');
    }

    /**
     * Mettre à jour une catégorie
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string',
            'color_code' => 'required|string|max:7'
        ], [
            'name.required' => 'Le nom de la catégorie est obligatoire',
            'name.unique' => 'Cette catégorie existe déjà',
            'color_code.required' => 'La couleur est obligatoire'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'color_code' => $request->color_code
        ]);

        return redirect()->route('catalog.categories')
            ->with('success', 'Catégorie modifiée avec succès !');
    }

    /**
     * Supprimer une catégorie
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Vérifier si la catégorie a des objets associés
        if ($category->items()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Impossible de supprimer cette catégorie car elle contient des objets.');
        }

        $category->delete();

        return redirect()->route('catalog.categories')
            ->with('success', 'Catégorie supprimée avec succès !');
    }
}
