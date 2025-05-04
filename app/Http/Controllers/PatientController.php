<?php

namespace App\Http\Controllers;

use App\Models\Hospitalization;
use App\Models\Lit;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Service;
use Carbon\Carbon;
class PatientController extends Controller
{
    
    public function index()
    {
        $patientsHospitalises = Hospitalization::where('status', 'Admis')->count();
        $admissionsToday = Hospitalization::whereDate('created_at', today())->count();
        $sortiesToday = Hospitalization::whereDate('dateSortie', today())->count();

        $dureeMoyenne = Hospitalization::whereNotNull('dateSortie')
        ->selectRaw('AVG(DATEDIFF(dateSortie, created_at)) as duree_moyenne')
        ->value('duree_moyenne');

        $hospitalizations = Hospitalization::with(['patient', 'service','lit'])->get();
        $services        = Service::all();
        $beds = Lit::all();

        return view('patients.index', compact('hospitalizations', 'services', 'beds','patientsHospitalises', 'admissionsToday' , 'sortiesToday','dureeMoyenne'), [
            'patients' => Patient::all(),
        ],
        [
            'patientsHospitalises' => $patientsHospitalises,
            'admissionsToday' => $admissionsToday,
            'sortiesToday' => $sortiesToday,
            'dureeMoyenne' => number_format($dureeMoyenne, 1)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("", compact(""));
    }

    public function store(Request $request)
{
    // Validation des données
    $validated = $request->validate([
        // Patient
        'nom'             => 'required|string|max:255',
        'prenom'          => 'required|string|max:255',
        'dateNaissance'   => 'nullable|date',
        'genre'           => 'nullable|string|max:100',
        'groupeSanguin'   => 'nullable|string',
        'tel'             => 'required|string',
        'email'           => 'nullable|email',
        'adresse'         => 'required|string',

        // Hospitalisation
        'serviceId'      => 'required|integer|exists:services,id',
        'litId'          => 'required|integer|exists:lits,id',
        'dateAdmission'  => 'nullable|date',
        'dateSortie'     => 'nullable|date',
        'status'          => 'required|string|in:Admis,En attente,Sorti,Transfere',
        'noteMedical'   => 'nullable|string',
    ]);

    // Enregistrement Patient
    $patient = Patient::create([
        'nom'             => $request->nom,
        'prenom'          => $request->prenom,
        'dateNaissance'   => $request->dateNaissance,
        'genre'           => $request->genre,
        'groupeSanguin'   => $request->groupeSanguin,
        'tel'             => $request->tel,
        'email'           => $request->email,
        'adresse'         => $request->adresse,
    ]);

    // Enregistrement Hospitalisation
    $hospitalization = Hospitalization::create([
        'patient_id'      => $patient->id,
        'serviceId'      => $request->serviceId,
        'litId'          => $request->litId,
        'dateAdmission'  => $request->dateAdmission,
        'dateSortie'     => $request->dateSortie,
        'status'          => $request->status,
        'noteMedical'   => $request->noteMedical,
    ]);

    // Mise à jour du statut du lit si Admis
    if ($request->status == 'Admis') {
        $lit = Lit::find($request->litId);
        $lit->status = 'Occupé';
        $lit->save();
    }

    return redirect()->route('patients.index')->with('success', 'Patient et hospitalisation enregistrés avec succès.');
    }


    
    // public function show($id)
    // {
    //     $patient = Patient::with(['hospitalizations' => function($query) {
    //         $query->with(['service', 'lit'])->orderBy('dateAdmission', 'desc');
    //     }])->findOrFail($id);
        
    //     // Récupérer la dernière hospitalisation
    //     $hosp = $patient->hospitalizations->first();
        
    //     if (!$hosp) {
    //         return response()->json([
    //             'error' => 'Ce patient n\'a pas d\'hospitalisation'
    //         ], 404);
    //     }

    //     return response()->json([
    //         'patient' => [
    //             'id' => $patient->id,
    //             'nom' => $patient->nom,
    //             'prenom' => $patient->prenom,
    //             'dateNaissance' => $patient->dateNaissance,
    //             'age' => Carbon::parse($patient->dateNaissance)->age,
    //             'genre' => $patient->genre,
    //             'groupeSanguin' => $patient->groupeSanguin,
    //             'tel' => $patient->tel ?? '-',
    //             'email' => $patient->email ?? '-',
    //             'adresse' => $patient->adresse ?? '-',
    //         ],
    //         'service' => [
    //             'nom' => $hosp->service->nom,
    //         ],
    //         'bed' => 'Lit ' . $hosp->lit->numero,
    //         'dateAdmission' => Carbon::parse($hosp->admission_date)->format('d/m/Y'),
    //         'dateSortie' => $hosp->date_sortie ? Carbon::parse($hosp->date_sortie)->format('d/m/Y') : null,
    //         'status' => $hosp->status,
    //         'noteMedical' => $patient->noteMedical ?? null,
    //     ]);
    // }


    public function show($id)
{
    $patient = Patient::with(['hospitalizations' => function($query) {
        $query->with(['service', 'lit'])->orderBy('dateAdmission', 'desc');
    }])->findOrFail($id);

    // Récupérer la dernière hospitalisation
    $hosp = $patient->hospitalizations->first();

    if (!$hosp) {
        return response()->json([
            'error' => 'Ce patient n\'a pas d\'hospitalisation'
        ], 404);
    }

    return response()->json([
        'patient' => [
            'id' => $patient->id,
            'nom' => $patient->nom,
            'prenom' => $patient->prenom,
            'dateNaissance' => $patient->dateNaissance,
            'age' => Carbon::parse($patient->dateNaissance)->age,
            'genre' => $patient->genre,
            'groupeSanguin' => $patient->groupeSanguin,
            'tel' => $patient->tel ?? '-',
            'email' => $patient->email ?? '-',
            'adresse' => $patient->adresse ?? '-',
        ],
        'hospitalization' => [
            'service' => $hosp->service->nom,
            'lit' =>  $hosp->lit->numero,
            'dateAdmission' => Carbon::parse($hosp->dateAdmission)->format('d/m/Y'),
            'dateSortie' => $hosp->dateSortie ? Carbon::parse($hosp->dateSortie)->format('d/m/Y') : null,
            'status' => $hosp->status,
            'noteMedical' => $hosp->noteMedical ?? null,
        ]
    ]);
}

//     public function edit($id)
// {
//     $patient = Patient::with(['hospitalizations' => function($query) {
//         $query->with(['service', 'lit'])->orderBy('dateAdmission', 'desc');
//     }])->findOrFail($id);

//     $hosp = $patient->hospitalizations->first();

//     $services = Service::pluck('nom', 'id');
//     $beds = Lit::all();

//     return response()->json([
//         'patient' => $patient,
//         'hosp' => $hosp ? [
//             'id' => $hosp->id,
//             'serviceId' => $hosp->serviceId,
//             'litId' => $hosp->litId,
//             'dateAdmission' => $hosp->dateAdmission,
//             'dateSortie' => $hosp->dateSortie,
//             'status' => $hosp->status,
//             'noteMedical' => $hosp->noteMedical,
//         ] : null,
//         'services' => $services,
//         'beds' => $beds->map(function($bed) {
//             return [
//                 'id' => $bed->id,
//                 'numero' => $bed->numero,
//                 'status' => $bed->status,
//             ];
//         }),
//     ]);
// }


public function edit($id)
{
    $patient = Patient::with(['hospitalizations' => function($query) {
        $query->with(['service', 'lit'])->orderBy('dateAdmission', 'desc');
    }])->findOrFail($id);

    $hosp = $patient->hospitalizations->first();

    $services = Service::pluck('nom', 'id');
    $beds = Lit::all();

    return response()->json([
        'patient' => $patient,
        'hosp' => $hosp ? [
            'id' => $hosp->id,
            'serviceId' => $hosp->service_id,
            'litId' => $hosp->lit_id,
            'dateAdmission' => $hosp->dateAdmission,
            'dateSortie' => $hosp->dateSortie,
            'status' => $hosp->status,
            'noteMedical' => $hosp->noteMedical,
        ] : null,
        'services' => $services,
        'beds' => $beds->map(function($bed) {
            return [
                'id' => $bed->id,
                'numero' => $bed->numero,
                'status' => $bed->status,
            ];
        }),
    ]);
}


    public function update(Request $request, string $id)
    {
        

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'dateNaissance' => 'required|date',
            'genre' => 'required|string|in:M,F,O',
            'groupeSanguin' => 'required|string',
            'tel' => 'nullable|string',
            'email' => 'nullable|email',
            'adresse' => 'nullable|string',
        
            // Hospitalisation
            'hospitalization_id' => 'required|exists:hospitalizations,id',
            'serviceId' => 'required|exists:services,id',
            'litId' => 'required|exists:lits,id',
            'dateAdmission' => 'required|date',
            'dateSortie' => 'nullable|date',
            'status' => 'required|string|in:Admis,En attente,Transfere,Sorti',
            'noteMedical' => 'nullable|string',
        ]);
        
        // Patient
        $patient = Patient::findOrFail($id);
        $patient->update($request->only(['nom', 'prenom', 'dateNaissance', 'genre', 'groupeSanguin', 'tel', 'email', 'adresse']));
        
        // Hospitalisation
        $hospitalization = Hospitalization::findOrFail($request->hospitalization_id);
        $hospitalization->update([
            'service_id' => $request->serviceId,
            'litId' => $request->litId,
            'dateAdmission' => $request->dateAdmission,
            'dateSortie' => $request->dateSortie,
            'status' => $request->status,
            'noteMedical' => $request->noteMedical,
        ]);
        
        return redirect()->back()->with('success', 'Patient et hospitalisation mis à jour avec succès!');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $patient = Patient::find($id);
        if ($patient) {
            $patient->delete();
            return redirect()->route('patients.index')->with('success', 'Patient deleted successfully.');
        } else {
            return redirect()->route('patients.index')->with('error', 'Patient not found.');
        }
        
    }   

    public function getBedsByService($serviceId)
    {
        $beds = Lit::where('serviceId', $serviceId)
                ->where('status', 'Disponible')
                ->get(['id', 'numero', 'status']);
        return response()->json($beds);
    }

}
