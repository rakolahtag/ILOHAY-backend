<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;
use Illuminate\Support\Facades\Storage;

class ParticipantController extends Controller
{
   // Liste tous les participants
    public function index()
    {
        return response()->json(Participant::all());
    }

    // Ajouter un participant
    public function store(Request $request)
    {
        $validated = $request->validate([
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'email' => 'required|email|unique:participants,email',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'genre' => 'required|in:masculin,feminin',
            'cin' => 'required|string|unique:participants,cin',
            'nationalite' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'paysOrigine' => 'required|string|max:255',
            'entiteOrigine' => 'required|string|max:255',
        ]);

        $participant = Participant::create($validated);

        return response()->json([
            'message' => 'Participant créé avec succès',
            'data' => $participant
        ], 201);
    }

    // Récupérer un participant
    public function show($id)
    {
        return response()->json(Participant::findOrFail($id));
    }

    // Mettre à jour un participant
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'email' => 'required|email|unique:participants,email,' . $id,
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'genre' => 'required|in:masculin,feminin',
            'cin' => 'required|string|unique:participants,cin,' . $id,
            'nationalite' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'paysOrigine' => 'required|string|max:255',
            'entiteOrigine' => 'required|string|max:255',
        ]);

        $participant = Participant::findOrFail($id);
        $participant->update($validated);

        return response()->json([
            'message' => 'Participant mis à jour avec succès',
            'data' => $participant
        ]);
    }

    // Supprimer un participant
    public function destroy($id)
    {
        $participant = participant::findOrFail($id);

        if ($participant->photo && Storage::disk('public')->exists($participant->photo)) {
            Storage::disk('public')->delete($participant->photo);
        }

        $participant->delete();

        return response()->json(null, 204);
    }
}
