<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personnel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $activeUsers   = Personnel::where('statut', 'Actif')->count();
        $inactiveUsers = Personnel::where('statut', 'Inactif')->count();
        $totalUsers    = Personnel::count();
        $users = Personnel::all();
        return view("users.index", compact('users','totalUsers','activeUsers','inactiveUsers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("users.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $rules = [
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'matricule' => 'required|string|max:255|unique:personnels',
        'tel' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:personnels',
        'adresse' => 'required|string|max:255',
        'role' => 'required|string|max:255',
        'password' => 'required|string|min:8|confirmed',
    ];

    if ($request->role === 'infirmier') {
        $rules['serviceId'] = 'required|integer';
    }

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $user = new Personnel();
    $user->nom = $request->nom;
    $user->prenom = $request->prenom;
    $user->matricule = $request->matricule;
    $user->tel = $request->tel;
    $user->email = $request->email;
    $user->adresse = $request->adresse;
    $user->role = $request->role;

    if ($request->role === 'infirmier') {
        $user->serviceId = $request->serviceId;
    } else {
        $user->serviceId = null;
    }

    $user->password = Hash::make($request->password);
    $user->save();

    return redirect()->route('users.index')->with('success', 'User created successfully.');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Personnel::find($id);
        
        if (!$user) {
            return response()->json([
                'error' => 'Utilisateur non trouvé'
            ], 404);
        }
        
        // Charger la relation de service si elle existe
        if ($user->ServiceId) {
            $user->load('service');
        }
        
        // Retourner l'utilisateur au format JSON
        return response()->json($user);
    }

/**
 * Renvoie les données pour éditer un utilisateur au format JSON pour AJAX
 */
    public function edit(string $id)
    {
        $user = Personnel::find($id);
        
        if (!$user) {
            return response()->json([
                'error' => 'Utilisateur non trouvé'
            ], 404);
        }
    
        // Récupérer la liste des services pour le select
        $services = \App\Models\Service::where('statut', 'Actif')->get(['id', 'nom']);
        
        // Préparer les données nécessaires pour le formulaire d'édition
        $data = $user->toArray();
        $data['services'] = $services;
        
        // Retourner les données au format JSON
        return response()->json($data);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Personnel::find($id);        
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string|max:255',
            
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->role = $request->role;
        $user->save();
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Personnel::find($id);
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.'); 
    }

    public function loginUser(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('home')->with('success', 'Logged in successfully');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logoutUser()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Logged out successfully');
    }
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function blockUser($id)
    {
        $user = Personnel::find($id);
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }
        $user->status = 'blocked';
        $user->save();
        return redirect()->route('users.index')->with('success', 'User blocked successfully.');
    }
    public function unblockUser($id)
    {
        $user = Personnel::find($id);
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }
        $user->status = 'active';
        $user->save();
        return redirect()->route('users.index')->with('success', 'User unblocked successfully.');
    }
   
}
