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
        $users = Personnel::all();
        return view("users.index", compact("users"));
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
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'matricule' => 'required|string|max:255|unique:users',
            'tel' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'adresse' => 'required|string|max:255',
            'serviceId' => 'required|integer',
            'role' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ])
        ->after(function ($validator) {
            if ($validator->errors()->has('email')) {
                $validator->errors()->add('email', 'The email has already been taken.');
            }
        });
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
        if ($user->role == 'urgentiste') {
            $user->serviceId = null; // Set serviceId to null for admin role
        }else {
            $user->serviceId = $request->serviceId;
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
            return redirect()->route('users.index')->with('error', 'User not found.');
        }
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Personnel::find($id);
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }
        return view('users.edit', compact('user'));
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
