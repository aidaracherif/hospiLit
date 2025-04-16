<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // Affiche tous les services
    public function index()
    {
        $activeServices   = Service::where('statut', 'Actif')->count();
        $inactiveServices = Service::where('statut', 'Inactif')->count();
        $totalBeds        = Service::sum('nombreLit');
        $services = Service::all();
        return view('services.services', compact('activeServices', 'inactiveServices', 'totalBeds','services')); // ⬅️ Ici, on retourne une vue Blade
    }


    // Ajoute un nouveau service
    public function store(Request $request)
{
    $validated = $request->validate([
        'nom'         => 'required|string|max:255',
        'nombreLit'   => 'required|integer',
        'responsable' => 'nullable|string|max:255',
        'etage'       => 'nullable|string|max:100',
        'description' => 'nullable|string',
        'statut'      => 'required|in:Actif,Inactif',
    ]);

    // Crée un service (en vérifiant que le modèle a bien un id auto-incrémenté)
    $service = Service::create($validated);

    // Redirige ou retourne une réponse (selon que tu utilises AJAX ou non)
    return redirect()->back()->with('success', 'Service ajouté avec succès !');
}

    public function show(Service $service)
    {
        if (request()->ajax()) {
            return response()->json($service);
        }
        return view('services.show', compact('service'));
    }
    

    public function update(Request $request, $id)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'nombreLit' => 'required|integer|min:1',
        'responsable' => 'nullable|string|max:255', // Changer à nullable si ce n'est pas obligatoire
        'etage' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:1000', // Augmenter la limite pour les descriptions longues
        'statut' => 'required|string|in:Actif,Inactif', // Limiter aux valeurs possibles
    ]);
    
    $service = Service::findOrFail($id);
    $service->update($request->only([
        'nom', 'nombreLit', 'responsable', 'etage', 'description', 'statut'
    ]));
    
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Service mis à jour avec succès'
        ]);
    }
    
    return redirect()->route('services.index')->with('success', 'Service mis à jour avec succès');
}
 
    public function edit(Service $service)
    {
        if (request()->ajax()) {
            return response()->json($service);
        }
        return view('services.edit', compact('service'));
    }


    // Supprime un service
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('services.index')->with('success','Supprime avec succes');
    }
}
