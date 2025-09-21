<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Stagiaire;
use App\Models\Participant;
use App\Models\Formateur;

class AuthController extends Controller
{
    /**
     * Enregistrement d'un utilisateur
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'nom'         => 'required|string|max:255',
            'prenom'      => 'required|string|max:255',
            'email'       => 'required|string|email|max:255|unique:users',
            'password'    => 'required|string|min:6|confirmed',
            'cin'         => 'nullable|string|max:20|unique:users,cin',
            'telephone'   => 'nullable|string|max:20',
            'adresse'     => 'nullable|string|max:255',
            'pays_origine'=> 'nullable|string|max:100',
            'nationalite' => 'nullable|string|max:100',
            'genre'       => 'nullable|in:masculin,feminin,autre',
            'role'        => 'required|in:stagiaire,participant,formateur',

            'etablissement'     => 'required_if:role,stagiaire|string|max:255',
            'niveau_en_classe'  => 'required_if:role,stagiaire|string|max:255',
            'entite_origine'    => 'required_if:role,participant|string|max:255',
            'specialite'        => 'required_if:role,formateur|string|max:255',
        ]);

        $user = User::create([
            'nom'         => $validated['nom'],
            'prenom'      => $validated['prenom'],
            'cin'         => $validated['cin'],
            'telephone'   => $validated['telephone'],
            'adresse'     => $validated['adresse'],
            'pays_origine'=> $validated['pays_origine'],
            'nationalite' => $validated['nationalite'],
            'genre'       => $validated['genre'],
            'email'       => $validated['email'],
            'password'    => Hash::make($validated['password']),
            'role'        => $validated['role'], // pas admin car bloqué au register
        ]);

        // Création d’un enregistrement spécifique selon le rôle
        if ($validated['role'] === 'stagiaire') {
            Stagiaire::create([
                'user_id'          => $user->id,
                'etablissement'    => $validated['etablissement'],
                'niveau_en_classe' => $validated['niveau_en_classe'],
            ]);
        } elseif ($validated['role'] === 'participant') {
            Participant::create([
                'user_id'        => $user->id,
                'entite_origine' => $validated['entite_origine'],
            ]);
        } elseif ($validated['role'] === 'formateur') {
            Formateur::create([
                'user_id'   => $user->id,
                'specialite'=> $validated['specialite'],
            ]);
        }

        return response()->json([
            'message' => 'Utilisateur créé avec succès',
            'user'    => $user,
        ], 201);
    }

    /**
     * Connexion
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Les identifiants sont incorrects.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Connexion réussie',
            'token'   => $token,
            'user' => [
                'id' => $user->id,
                'nom' => $user->nom,
                'prenom' => $user->prenom,
                'email' => $user->email,
                'role' => $user->role, // ✅ important
            ], // inclut role, prenom, etc.
        ]);
    }

    /**
     * Déconnexion
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Déconnexion réussie',
        ]);
    }

    /**
     * Récupérer les infos du user connecté
     */
    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Mise à jour profil (corrigé avec "nom")
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'nom'  => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id), // email unique sauf celui de l’utilisateur
            ],
        ]);

        $user->update([
            'nom'  => $request->name,
            'email' => $request->email,
        ]);

        return response()->json($user);
    }

        
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = $request->user();
        $path = $request->file('photo')->store('photos', 'public');

        $user->update(['photo' => $path]);

        return response()->json([
            'message' => 'Photo mise à jour avec succès',
            'photo' => $path,
        ]);
    }
}
