<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class HomeController extends Controller
{
    public function catalogueUser()
    {
        // Récupère tous les items avec leur catégorie
        $items = Item::with('category')->get();

        // --- Statistiques ---
        $byCategory = $items->groupBy(fn($item) => $item->category->name ?? 'N/A')
                             ->map(fn($group) => $group->count())
                             ->toArray(); // conversion en tableau
        $byStatus = $items->groupBy('status')
                          ->map(fn($group) => $group->count())
                          ->toArray(); // conversion en tableau

        $stats = [
            'by_category' => $byCategory,
            'by_status' => $byStatus,
        ];

        return view('catalogue_user', compact('items', 'stats'));
    }
}
