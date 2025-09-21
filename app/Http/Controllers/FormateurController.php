<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formateur;
use Illuminate\Support\Facades\Storage;

class FormateurController extends Controller
{
    // Liste tous les formateurs
    public function index()
    {
        return response()->json(Formateur::all());
    }

    // Ajouter un formateur
    public function store(Request $request)
    {
        $validated = $request->validate([
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'email' => 'required|email|unique:formateurs,email',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'genre' => 'required|in:masculin,feminin',
            'cin' => 'required|string|unique:formateurs,cin',
            'nationalite' => 'nullable|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'paysOrigine' => 'nullable|string|max:255',
            'specialite' => 'nullable|string|max:255',
        ]);

        // ✅ Gestion upload photo
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('formateurs', 'public');
            $validated['photo'] = $path;
        }

        $formateur = Formateur::create($validated);

        return response()->json([
            'message' => 'Formateur créé avec succès',
            'data' => $formateur
        ], 201);
    }

    // Récupérer un formateur
    public function show($id)
    {
        return response()->json(Formateur::findOrFail($id));
    }

    // Mettre à jour un formateur
    public function update(Request $request, $id)
    {
        $formateur = Formateur::findOrFail($id);

        $validated = $request->validate([
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'email' => 'required|email|unique:formateurs,email,' . $id,
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'genre' => 'required|in:masculin,feminin',
            'cin' => 'required|string|unique:formateurs,cin,' . $id,
            'nationalite' => 'nullable|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'paysOrigine' => 'nullable|string|max:255',
            'specialite' => 'nullable|string|max:255',
        ]);

        // ✅ Nouvelle photo
        if ($request->hasFile('photo')) {
            // supprimer l'ancienne si elle existe
            if ($formateur->photo && Storage::disk('public')->exists($formateur->photo)) {
                Storage::disk('public')->delete($formateur->photo);
            }
            $path = $request->file('photo')->store('formateurs', 'public');
            $validated['photo'] = $path;
        }

        $formateur->update($validated);

        return response()->json([
            'message' => 'Formateur mis à jour avec succès',
            'data' => $formateur
        ]);
    }

    // Supprimer un formateur
    public function destroy($id)
    {
        $formateur = Formateur::findOrFail($id);

        // ✅ supprimer aussi la photo
        if ($formateur->photo && Storage::disk('public')->exists($formateur->photo)) {
            Storage::disk('public')->delete($formateur->photo);
        }

        $formateur->delete();

        return response()->json(null, 204);
    }
}
