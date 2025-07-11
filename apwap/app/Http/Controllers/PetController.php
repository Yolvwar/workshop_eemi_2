<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Veterinarian;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function index()
    {
        $pets = Pet::orderBy('name')->get();
        return view('pets.index', ['pets' => $pets]);
    }

    public function create()
    {
        $veterinarians = Veterinarian::all();
        return view('pets.create', compact('veterinarians'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'microchip_number' => 'nullable|string|max:50',
            'insurance_provider' => 'nullable|string|max:100',
            'health_score' => 'nullable|integer|min:0|max:100',
            'education_score' => 'nullable|integer|min:0|max:100',
            'nutrition_score' => 'nullable|integer|min:0|max:100',
            'activity_score' => 'nullable|integer|min:0|max:100',
            'lifestyle_score' => 'nullable|integer|min:0|max:100',
            'emotional_score' => 'nullable|integer|min:0|max:100',
            'overall_score' => 'nullable|integer|min:0|max:100',
            'markings' => 'nullable|string|max:255',
            'is_neutered' => 'nullable|boolean', // Ajouté
        ]);


        // Calcul du score global
        $scores = collect([
            $validated['health_score'] ?? null,
            $validated['education_score'] ?? null,
            $validated['nutrition_score'] ?? null,
            $validated['activity_score'] ?? null,
            $validated['lifestyle_score'] ?? null,
            $validated['emotional_score'] ?? null,
        ])->filter(); // retire les valeurs null

        $validated['overall_score'] = $scores->count() > 0
            ? round($scores->avg())
            : null;

        $validated['user_id'] = auth()->id();

        $pet = Pet::create($validated);

        // Validation du dossier de santé
        $validatedHealth = $request->validate([
            'health_record.primary_vet_name' => 'nullable|string|max:255',
            'health_record.blood_type' => 'nullable|string|max:20',
            'health_record.allergies' => 'nullable|string',
            'health_record.current_medications' => 'nullable|string',
        ]);


        // Création du dossier de santé associé
        $pet->healthRecord()->updateOrCreate(
            ['pet_id' => $pet->id],
            $validatedHealth['health_record']
        );

        return redirect()->route('pets.index')->with('success', 'Animal ajouté avec succès');
    }


    public function show(Pet $pet)
    {
        return view('pets.show', ['pet' => $pet]);
    }

    public function edit(Pet $pet)
    {
        $veterinarians = Veterinarian::where('is_active', true)->get();

        return view('pets.edit', ['pet' => $pet, 'veterinarians' => $veterinarians]);
    }

    public function update(Request $request, Pet $pet)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'health_score' => 'nullable|integer|min:0|max:100',
            'education_score' => 'nullable|integer|min:0|max:100',
            'nutrition_score' => 'nullable|integer|min:0|max:100',
            'activity_score' => 'nullable|integer|min:0|max:100',
            'lifestyle_score' => 'nullable|integer|min:0|max:100',
            'emotional_score' => 'nullable|integer|min:0|max:100',
            'overall_score' => 'nullable|integer|min:0|max:100',
            'markings' => 'nullable|string|max:255',
            'is_neutered' => 'nullable|boolean',
        ]);

        $pet->update($validated);

        $validatedHealth = $request->validate([
            'health_record' => 'array',
            'health_record.primary_vet_name' => 'nullable|string|max:255',
            'health_record.blood_type' => 'nullable|string|max:20',
            'health_record.allergies' => 'nullable|string',
            'health_record.current_medications' => 'nullable|string',
        ]);

        $pet->healthRecord()->updateOrCreate(
            ['pet_id' => $pet->id],
            $validatedHealth['health_record']
        );

        return redirect()->route('pets.index')
            ->with('success', 'Profil animal mis à jour avec succès.');
    }


    public function destroy(Pet $pet)
    {
        $pet->delete();

        return redirect()->route('pets.index')
            ->with('success', 'Animal supprimé');
    }
}
