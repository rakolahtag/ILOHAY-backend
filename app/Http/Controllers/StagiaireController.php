<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stagiaire;
use Illuminate\Support\Facades\Storage;

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
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'email' => 'required|email|unique:stagiaires,email',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'genre' => 'required|in:masculin,feminin',
            'cin' => 'required|string|unique:stagiaires,cin',
            'nationalite' => 'nullable|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'pays_origine' => 'nullable|string|max:255',
            'niveau_en_classe' => 'nullable|string|max:255',
            'etablissement' => 'nullable|string|max:255',
        ]);

        // Gestion upload photo
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('stagiaires', 'public');
            $validated['photo'] = $path;
        }

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

        $validated = $request->validate([
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'email' => 'required|email|unique:stagiaires,email,' . $id,
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'genre' => 'required|in:masculin,feminin,autre',
            'cin' => 'required|string|unique:stagiaires,cin,' . $id,
            'nationalite' => 'nullable|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'pays_origine' => 'nullable|string|max:255',
            'niveau_en_classe' => 'nullable|string|max:255',
            'etablissement' => 'nullable|string|max:255',
        ]);

        // si nouvelle photo envoyée
        if ($request->hasFile('photo')) {
            // supprimer l'ancienne si existe
            if ($stagiaire->photo && Storage::disk('public')->exists($stagiaire->photo)) {
                Storage::disk('public')->delete($stagiaire->photo);
            }
            $path = $request->file('photo')->store('stagiaires', 'public');
            $validated['photo'] = $path;
        }

        $stagiaire->update($validated);

        return response()->json([
            'message' => 'Stagiaire mis à jour avec succès',
            'data' => $stagiaire
        ]);
    }

    // Supprimer
    public function destroy($id)
    {
        $stagiaire = Stagiaire::findOrFail($id);

        // supprimer aussi la photo
        if ($stagiaire->photo && Storage::disk('public')->exists($stagiaire->photo)) {
            Storage::disk('public')->delete($stagiaire->photo);
        }

        $stagiaire->delete();

        return response()->json(null, 204);
    }
}
