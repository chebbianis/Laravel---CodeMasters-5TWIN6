<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\PartnerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('partners.index');
    }

    /**
     * Display public partners page for visitors.
     */
    public function publicPartners()
    {
        $partners = Partner::with(['type'])
                          ->where('is_active', true)
                          ->get();
        
        $partnerTypes = PartnerType::all();
        $totalPartners = Partner::count();
        $activePartners = Partner::where('is_active', true)->count();

        return view('partners.public', compact('partners', 'partnerTypes', 'totalPartners', 'activePartners'));
    }

    /**
     * Display the partners list page.
     */
    public function list()
    {
        $partners = Partner::with(['type', 'creator'])->paginate(12);
        $partnerTypes = PartnerType::all();
        return view('partners.list', compact('partners', 'partnerTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $partnerTypes = PartnerType::all();
        return view('partners.create', compact('partnerTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'type_id' => 'required|exists:partner_types,id',
            'contact_email' => 'required|email|max:100',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'created_by' => 'required|integer|exists:users,id'
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        Partner::create($validated);

        return redirect()->route('partners.list')
                        ->with('success', 'Partenaire créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Partner $partner)
    {
        $partner->load(['type', 'creator']);
        return view('partners.show', compact('partner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Partner $partner)
    {
        $partnerTypes = PartnerType::all();
        return view('partners.edit', compact('partner', 'partnerTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Partner $partner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'type_id' => 'required|exists:partner_types,id',
            'contact_email' => 'required|email|max:100',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'website' => 'nullable|url|max:255'
        ]);

        // Traiter le checkbox is_active séparément
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $partner->update($validated);

        return redirect()->route('partners.list')
                        ->with('success', 'Partenaire mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partner $partner)
    {
        $partner->delete();

        return redirect()->route('partners.list')
                        ->with('success', 'Partenaire supprimé avec succès.');
    }

    /**
     * Get partners data for API requests.
     */
    public function getPartnersData(Request $request)
    {
        $query = Partner::with(['type', 'creator']);

        // Filtrage par type
        if ($request->filled('type')) {
            $query->whereHas('type', function($q) use ($request) {
                $q->where('name', $request->type);
            });
        }

        // Filtrage par statut
        if ($request->filled('status')) {
            $status = $request->status === 'active' ? 1 : 0;
            $query->where('is_active', $status);
        }

        // Recherche par nom
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $partners = $query->get();

        return response()->json($partners);
    }
}
