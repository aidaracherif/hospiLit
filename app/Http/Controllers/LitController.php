<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Lit;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
class LitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        

        $services = Service::all();
        $lits = Lit::with('service')->get();

        $disponibles = Lit::where('status', 'Disponible')->count();
        $occupes = Lit::where('status', 'Occupé')->count();
        $maintenance = Lit::where('status', 'En maintenance')->count();
        $reserves = Lit::where('status', 'Réservé')->count();
        return view('lits.index', compact('lits', 'services','disponibles', 'occupes', 'maintenance', 'reserves'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // return view("", compact(""));
        $services = Service::where('statut', 'Actif')->get();
        return view('lits.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'numero' => 'required|string|max:255',
            'serviceId'      => 'required|integer',
            'etage' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'dateOccupation' => 'required|string|max:255',
        ]);
        if ($validated['status'] !== 'Disponible') {
            $validated['dateOccupation'] = null;
        }
        Lit::create($validated);
        
        return redirect()->route('lits.index')
            ->with('success', 'Le lit a été ajouté avec succès.');
        
    }
    public function show($id)
{
    $lit = Lit::with('service')->find($id);

    if (!$lit) {
        return response()->json(['error' => 'Lit introuvable'], 404);
    }

    return response()->json($lit);
}
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lit $lit)
    {
        //
        // $lit = Lit::findOrFail($id);
        // return view('', [   
        //     'lit' => $lit,
        // ]);
        $lit = Lit::with('service')->find($lit->id);
        if (!$lit) {
            return response()->json(['error' => 'Lit introuvable'], 404);
        }
        $services = Service::where('statut', 'Actif')->get();
        
        return response()->json([
            'id' => $lit->id,
            'numero' => $lit->numero,
            'serviceId' => $lit->service_id,
            'etage' => $lit->etage,
            'status' => $lit->status,
            'dateOccupation' => $lit->dateOccupation,
            'services' => $services
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lit $lit)
    {
        
        $validated = $request->validate([
            'numero' => 'required|string|max:10|unique:lits,numero,' . $lit->id,
            'serviceId' => 'required|exists:services,id',
            'etage' => 'required|string|max:10',
            'status' => 'required|in:Disponible,Occupé,En maintenance',
            'dateOccupation' => 'nullable|date',
        ]);
        if ($validated['status'] !== 'Occupé') {
            $validated['dateOccupation'] = null;
        }
        
        $lit->update($validated);
        
        return redirect()->route('lits.index')
            ->with('success', 'Le lit a été mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lit $lit)
    {
        //
        // $lit = Lit::findOrFail($id);
        // $lit->delete();
        // return redirect()->route('lits.index')->with('success','');
        $lit->delete();
        
        return redirect()->route('lits.index')
            ->with('success', 'Le lit a été supprimé avec succès.');
    }

    public function getChartsData()
    {
        // Données pour le graphique de distribution des lits par service
        $distribution = DB::table('lits')
            ->join('services', 'lits.service_id', '=', 'services.id')
            ->select('services.nom', DB::raw('count(*) as total'))
            ->groupBy('services.nom')
            ->get();
            
        $distributionLabels = $distribution->pluck('nom')->toArray();
        $distributionData = $distribution->pluck('total')->toArray();
        
        // Données pour le graphique d'occupation par service
        $occupation = DB::table('lits')
            ->join('services', 'lits.service_id', '=', 'services.id')
            ->select(
                'services.nom',
                DB::raw('SUM(CASE WHEN lits.statut = "Occupé" THEN 1 ELSE 0 END) as occupied'),
                DB::raw('SUM(CASE WHEN lits.statut = "Disponible" THEN 1 ELSE 0 END) as available'),
                DB::raw('SUM(CASE WHEN lits.statut = "En maintenance" THEN 1 ELSE 0 END) as maintenance')
            )
            ->groupBy('services.nom')
            ->get();
            
        $occupationLabels = $occupation->pluck('nom')->toArray();
        $occupationOccupied = $occupation->pluck('occupied')->toArray();
        $occupationAvailable = $occupation->pluck('available')->toArray();
        $occupationMaintenance = $occupation->pluck('maintenance')->toArray();
        
        return response()->json([
            'distribution' => [
                'labels' => $distributionLabels,
                'data' => $distributionData
            ],
            'occupation' => [
                'labels' => $occupationLabels,
                'occupied' => $occupationOccupied,
                'available' => $occupationAvailable,
                'maintenance' => $occupationMaintenance
            ]
        ]);
    }
}
