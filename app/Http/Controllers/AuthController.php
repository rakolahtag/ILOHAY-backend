<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Enregistrement d'un utilisateur
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'prenom'       => 'required|string|max:255',
            'cin'          => 'required|string|max:20|unique:users,cin',
            'telephone'    => 'required|string|max:20',
            'adresse'      => 'required|string|max:255',
            'pays_origine' => 'required|string|max:100',
            'nationalite'  => 'required|string|max:100',
            'genre'        => 'required|in:Homme,Femme,Autre',
            'email'        => 'required|string|email|max:255|unique:users',
            'password'     => 'required|string|min:6|confirmed',
            'role'         => 'required|in:stagiaire,participant,formateur', // ⚠️ pas admin ici !
        ]);

        $user = User::create([
            'name'         => $validated['name'],
            'prenom'       => $validated['prenom'],
            'cin'          => $validated['cin'],
            'telephone'    => $validated['telephone'],
            'adresse'      => $validated['adresse'],
            'pays_origine' => $validated['pays_origine'],
            'nationalite'  => $validated['nationalite'],
            'genre'        => $validated['genre'],
            'email'        => $validated['email'],
            'password'     => Hash::make($validated['password']),
            'role'         => $validated['role'], // pas admin car bloqué au register
        ]);

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
            'user'    => $user, // inclut role, prenom, etc.
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
}
