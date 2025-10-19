<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Afficher la liste des utilisateurs avec leurs rôles
     */
    public function index()
    {
        $users = User::with('role')->orderBy('created_at', 'desc')->get();
        $roles = Role::all();
        
        return view('users.manage', compact('users', 'roles'));
    }

    /**
     * Changer le rôle d'un utilisateur
     */
    public function changeRole(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'role_id' => 'required|exists:roles,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Rôle invalide'
                ], 400);
            }

            $user = User::findOrFail($id);
            
            // Empêcher de modifier son propre rôle
            if ($user->id === auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous ne pouvez pas modifier votre propre rôle'
                ], 403);
            }
            
            $oldRole = $user->role->name;
            $user->role_id = $request->role_id;
            $user->save();
            
            $newRole = Role::find($request->role_id)->name;
            
            return response()->json([
                'success' => true,
                'message' => "Rôle modifié de '{$oldRole}' à '{$newRole}'",
                'new_role' => $newRole
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la modification du rôle'
            ], 500);
        }
    }

    /**
     * Activer/Désactiver un utilisateur
     */
    public function toggleStatus($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Empêcher de désactiver son propre compte
            if ($user->id === auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous ne pouvez pas désactiver votre propre compte'
                ], 403);
            }
            
            $user->is_active = !$user->is_active;
            $user->save();
            
            return response()->json([
                'success' => true,
                'message' => $user->is_active ? 'Utilisateur activé' : 'Utilisateur désactivé',
                'is_active' => $user->is_active
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la modification du statut'
            ], 500);
        }
    }

    /**
     * Supprimer un utilisateur
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Empêcher de supprimer son propre compte
            if ($user->id === auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous ne pouvez pas supprimer votre propre compte'
                ], 403);
            }
            
            $username = $user->username;
            $user->delete();
            
            return response()->json([
                'success' => true,
                'message' => "Utilisateur '{$username}' supprimé avec succès"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression'
            ], 500);
        }
    }
}
