<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Afficher le formulaire de connexion
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    /**
     * Traiter la connexion
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:4'
        ], [
            'email.required' => 'L\'adresse email est obligatoire',
            'email.email' => 'L\'adresse email doit être valide',
            'password.required' => 'Le mot de passe est obligatoire',
            'password.min' => 'Le mot de passe doit contenir au moins 4 caractères'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            // Mettre à jour la dernière connexion
            Auth::user()->update(['last_login' => now()]);
            
            return redirect()->route('home')
                ->with('success', 'Bienvenue ' . Auth::user()->first_name . ' !');
        }

        return redirect()->back()
            ->withErrors(['email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.'])
            ->withInput($request->except('password'));
    }

    /**
     * Afficher le formulaire d'inscription
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.register');
    }

    /**
     * Traiter l'inscription
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|max:100|unique:users,email',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'password' => 'required|string|min:4|confirmed',
        ], [
            'username.required' => 'Le nom d\'utilisateur est obligatoire',
            'username.unique' => 'Ce nom d\'utilisateur est déjà utilisé',
            'email.required' => 'L\'adresse email est obligatoire',
            'email.email' => 'L\'adresse email doit être valide',
            'email.unique' => 'Cette adresse email est déjà utilisée',
            'first_name.required' => 'Le prénom est obligatoire',
            'last_name.required' => 'Le nom est obligatoire',
            'password.required' => 'Le mot de passe est obligatoire',
            'password.min' => 'Le mot de passe doit contenir au moins 4 caractères',
            'password.confirmed' => 'Les mots de passe ne correspondent pas'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        // Créer le rôle "user" s'il n'existe pas
        $userRole = Role::firstOrCreate(
            ['name' => 'user'],
            ['description' => 'Utilisateur standard avec accès de base']
        );

        // Créer aussi le rôle admin s'il n'existe pas (pour usage futur)
        Role::firstOrCreate(
            ['name' => 'admin'],
            ['description' => 'Administrateur avec tous les privilèges']
        );

        // Créer l'utilisateur
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'password' => Hash::make($request->password),
            'role_id' => $userRole->id,
            'is_active' => true,
            'last_login' => now()
        ]);

        // Connecter automatiquement l'utilisateur
        Auth::login($user);

        return redirect()->route('home')
            ->with('success', 'Inscription réussie ! Bienvenue ' . $user->first_name . ' !');
    }

    /**
     * Déconnexion
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }

    /**
     * Créer un admin (pour usage interne uniquement)
     * Cette méthode ne doit être accessible que par un admin existant
     */
    public function createAdmin(Request $request)
    {
        // Vérifier que l'utilisateur actuel est un admin
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Accès non autorisé');
        }

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|max:100|unique:users,email',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'password' => 'required|string|min:4|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            ['description' => 'Administrateur avec tous les privilèges']
        );

        $admin = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'password' => Hash::make($request->password),
            'role_id' => $adminRole->id,
            'is_active' => true
        ]);

        return redirect()->back()
            ->with('success', 'Administrateur créé avec succès.');
    }
}
