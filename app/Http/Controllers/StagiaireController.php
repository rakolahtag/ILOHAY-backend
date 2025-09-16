<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stagiaire;

class StagiaireController extends Controller
{
   // Liste tous les stagiaires
    public function index()
    {
        return response()->json(Stagiaire::all());
    }

    // Ajouter un stagiaire
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:stagiaires,email',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'genre' => 'required|in:masculin,feminin',
            'cin' => 'required|string|unique:stagiaires,cin',
        ]);

        $stagiaire = Stagiaire::create($validated);

        return response()->json([
            'message' => 'Stagiaire créé avec succès',
            'data' => $stagiaire
        ], 201);
    }


    // Récupérer un stagiaire
    public function show($id)
    {
        return response()->json(Stagiaire::findOrFail($id));
    }

    // Mettre à jour
    public function update(Request $request, $id)
    {
        $stagiaire = Stagiaire::findOrFail($id);
        $stagiaire->update($request->all());
        return response()->json($stagiaire);
    }

    // Supprimer
    public function destroy($id)
    {
        Stagiaire::destroy($id);
        return response()->json(null, 204);
    }
}
