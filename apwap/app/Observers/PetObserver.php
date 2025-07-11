<?php

namespace App\Observers;

use App\Models\Pet;

class PetObserver
{
    public function saving(Pet $pet): void
    {
        // On vérifie que les scores nécessaires sont définis
        $scores = [
            $pet->health_score,
            $pet->education_score,
            $pet->nutrition_score,
            $pet->activity_score,
            $pet->lifestyle_score,
            $pet->emotional_score,
        ];

        if (collect($scores)->contains(null)) {
            // Si un score est manquant, on ne touche pas à overall_score
            return;
        }

        $pet->overall_score = round(array_sum($scores) / count($scores));
    }
}
