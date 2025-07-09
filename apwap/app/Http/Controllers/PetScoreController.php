<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;

class PetScoreController extends Controller
{
    public function show(Pet $pet)
    {
        $scores = $pet->scores()->latest()->first();

        return view('pets.scores.show', ['pet' => $pet, 'scores' => $scores]);
    }

    public function applyRecommendations(Request $request, Pet $pet)
    {
        // Logique pour appliquer les recommandations sur l'animal
        // Exemple : mise à jour des scores, ajout d'actions, etc.

        // Après traitement, redirection vers la vue du score
        return redirect()->route('pets.scores.show', $pet->id)
            ->with('success', 'Recommandations appliquées avec succès');
    }
}
