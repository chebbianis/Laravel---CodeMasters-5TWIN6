<?php

namespace App\Http\Controllers;

use App\Models\PartnerType;
use Illuminate\Http\Request;

class PartnerTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partnerTypes = PartnerType::withCount('partners')->get();
        return view('partners.types', compact('partnerTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('partners.types-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:partner_types,name',
            'description' => 'required|string'
        ]);

        PartnerType::create($validated);

        return redirect()->route('partners.types')
                        ->with('success', 'Type de partenaire créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PartnerType $partnerType)
    {
        $partnerType->loadCount('partners');
        return response()->json($partnerType);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PartnerType $partnerType)
    {
        return response()->json($partnerType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PartnerType $partnerType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:partner_types,name,' . $partnerType->id,
            'description' => 'required|string'
        ]);

        $partnerType->update($validated);

        return redirect()->route('partners.types')
                        ->with('success', 'Type de partenaire mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PartnerType $partnerType)
    {
        try {
            // Vérifier s'il y a des partenaires associés
            if ($partnerType->partners()->count() > 0) {
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Impossible de supprimer ce type car il est utilisé par des partenaires.'
                    ], 400);
                }
                
                return redirect()->route('partners.types')
                    ->with('error', 'Impossible de supprimer ce type car il est utilisé par des partenaires.');
            }

            $partnerType->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Type de partenaire supprimé avec succès.'
                ]);
            }

            return redirect()->route('partners.types')
                ->with('success', 'Type de partenaire supprimé avec succès.');
                
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('partners.types')
                ->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }
}
