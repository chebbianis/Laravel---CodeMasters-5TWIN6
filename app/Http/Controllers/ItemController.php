<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Afficher la liste des objets
     */
    public function index()
    {
        $items = Item::with('category')->orderBy('created_at', 'desc')->get();
        $categories = Category::orderBy('name')->get();
        return view('catalog.items', compact('items', 'categories'));
    }

    /**
     * Créer un nouvel objet
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'condition' => 'required|in:bon,moyen,à réparer',
            'status' => 'required|in:disponible,transformé,recyclé',
            'image_url' => 'nullable|url',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'name.required' => 'Le nom de l\'objet est obligatoire',
            'category_id.required' => 'La catégorie est obligatoire',
            'category_id.exists' => 'La catégorie sélectionnée n\'existe pas',
            'condition.required' => 'L\'état de l\'objet est obligatoire',
            'status.required' => 'Le statut est obligatoire',
            'image_file.image' => 'Le fichier doit être une image',
            'image_file.mimes' => 'L\'image doit être au format jpeg, png, jpg ou gif',
            'image_file.max' => 'L\'image ne doit pas dépasser 2 Mo'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Gérer l'upload d'image
        $imageUrl = $request->image_url;
        if ($request->hasFile('image_file')) {
            $image = $request->file('image_file');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('items', $imageName, 'public');
            $imageUrl = Storage::url($imagePath);
        }

        Item::create([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'condition' => $request->condition,
            'status' => $request->status,
            'image_url' => $imageUrl,
            'created_by' => Auth::id()
        ]);

        return redirect()->route('catalog.items')
            ->with('success', 'Objet créé avec succès !');
    }

    /**
     * Mettre à jour un objet
     */
    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'condition' => 'required|in:bon,moyen,à réparer',
            'status' => 'required|in:disponible,transformé,recyclé',
            'image_url' => 'nullable|url',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'name.required' => 'Le nom de l\'objet est obligatoire',
            'category_id.required' => 'La catégorie est obligatoire',
            'category_id.exists' => 'La catégorie sélectionnée n\'existe pas',
            'condition.required' => 'L\'état de l\'objet est obligatoire',
            'status.required' => 'Le statut est obligatoire',
            'image_file.image' => 'Le fichier doit être une image',
            'image_file.mimes' => 'L\'image doit être au format jpeg, png, jpg ou gif',
            'image_file.max' => 'L\'image ne doit pas dépasser 2 Mo'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Gérer l'upload d'image
        $imageUrl = $request->image_url;
        if ($request->hasFile('image_file')) {
            // Supprimer l'ancienne image si elle existe et qu'elle n'est pas une URL externe
            if ($item->image_url && !filter_var($item->image_url, FILTER_VALIDATE_URL)) {
                $oldImagePath = str_replace('/storage/', '', $item->image_url);
                Storage::disk('public')->delete($oldImagePath);
            }
            
            $image = $request->file('image_file');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('items', $imageName, 'public');
            $imageUrl = Storage::url($imagePath);
        }

        $item->update([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'condition' => $request->condition,
            'status' => $request->status,
            'image_url' => $imageUrl
        ]);

        return redirect()->route('catalog.items')
            ->with('success', 'Objet modifié avec succès !');
    }

    /**
     * Supprimer un objet
     */
    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return redirect()->route('catalog.items')
            ->with('success', 'Objet supprimé avec succès !');
    }

    /**
     * Afficher la page publique du catalogue
     */
    public function publicCatalog()
    {
        $items = Item::with('category')->orderBy('created_at', 'desc')->get();
        $categories = Category::withCount('items')->orderBy('name')->get();
        
        $totalItems = $items->count();
        $availableItems = $items->where('status', 'disponible')->count();
        $transformedItems = $items->where('status', 'transformé')->count();
        
        return view('catalog.public', compact('items', 'categories', 'totalItems', 'availableItems', 'transformedItems'));
    }

    /**
     * Afficher la page d'index du catalogue (vue d'ensemble)
     */
    public function catalogIndex()
    {
        $totalItems = Item::count();
        $availableItems = Item::where('status', 'disponible')->count();
        $inRepairItems = Item::where('condition', 'à réparer')->count();
        $transformedItems = Item::where('status', 'transformé')->count();
        $totalCategories = Category::count();

        // Données pour les graphiques
        $statusData = [
            'disponible' => Item::where('status', 'disponible')->count(),
            'transformé' => Item::where('status', 'transformé')->count(),
            'recyclé' => Item::where('status', 'recyclé')->count(),
        ];

        $conditionData = [
            'bon' => Item::where('condition', 'bon')->count(),
            'moyen' => Item::where('condition', 'moyen')->count(),
            'à réparer' => Item::where('condition', 'à réparer')->count(),
        ];

        // Données par catégorie
        $categories = Category::withCount('items')->get();
        $categoryData = $categories->mapWithKeys(function ($category) {
            return [$category->name => $category->items_count];
        })->toArray();

        return view('catalog.index', compact(
            'totalItems',
            'availableItems',
            'inRepairItems',
            'transformedItems',
            'totalCategories',
            'statusData',
            'conditionData',
            'categoryData'
        ));
    }
}
