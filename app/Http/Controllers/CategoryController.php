<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    // 📌 Liste des catégories
    public function index()
    {
        $categories = Category::all();
        return view('catalog.categories', compact('categories'));
    }

    // 📌 Formulaire de création
    public function create()
    {
        return view('catalog.create-category');
    }

    // 📌 Enregistrement d’une nouvelle catégorie
    public function store(Request $request)
    {
        // ✅ Création du validateur
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color_code' => 'required|string|max:7',
        ], [
            'name.required' => 'Le nom de la catégorie est obligatoire.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'color_code.required' => 'Le code couleur est obligatoire.',
            'color_code.max' => 'Le code couleur doit contenir 7 caractères (ex: #FFFFFF).',
        ]);

        // ✅ Vérifie la validation
        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        // ✅ Crée la catégorie à partir des données validées
        $data = $validator->validated();

        Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Catégorie créée avec succès !');
    }

    // 📌 Formulaire d’édition
    public function edit(Category $category)
    {
        return view('catalog.create-category', compact('category'));
    }

    // 📌 Mise à jour d’une catégorie
    public function update(Request $request, Category $category)
    {
        // ✅ Création du validateur
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color_code' => 'required|string|max:7',
        ], [
            'name.required' => 'Le nom de la catégorie est obligatoire.',
            'color_code.required' => 'Le code couleur est obligatoire.',
        ]);

        // ✅ Vérifie les erreurs
        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        $data = $validator->validated();

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Catégorie mise à jour avec succès !');
    }

    // 📌 Affiche les items d’une catégorie
    public function showItems(Category $category)
    {
        $items = $category->items()->with('creator')->get();
        return view('catalog.items_by_category', compact('category', 'items'));
    }

    // 📌 Suppression d’une catégorie
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Catégorie supprimée avec succès !');
    }
}
