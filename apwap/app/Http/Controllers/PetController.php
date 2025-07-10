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
        return view('pets.create');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:0',
            'birth_date' => 'nullable|date',
        ]);
        $validated['user_id'] = auth()->id();
        $pet = Pet::create($validated);

        return redirect()->route('pets.index', $pet->id)
            ->with('success', 'Animal ajouté avec succès');
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

    // public function update(Request $request, Pet $pet)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'species' => 'required|string|max:255',
    //         'breed' => 'nullable|string|max:255',
    //         'birth_date' => 'nullable|date',
    //     ]);

    //     $pet->update($validated);

    //     $validatedHealth = $request->validate([
    //         'health_record.primary_vet_name' => 'nullable|string|max:255',
    //         'health_record.blood_type' => 'nullable|string|max:20',
    //         'health_record.allergies' => 'nullable|string',
    //         'health_record.current_medications' => 'nullable|string',
    //     ]);

    //     $pet->healthRecord()->updateOrCreate(
    //         ['pet_id' => $pet->id],
    //         $validatedHealth['health_record']
    //     );

    //     return redirect()->route('pets.index', $pet->id)
    //         ->with('success', 'Profil animal mis à jour');
    // }


    public function update(Request $request, Pet $pet)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
        ]);

        $pet->update($validated);

        // 👉 ici on valide tout le bloc health_record comme un tableau
        $validatedHealth = $request->validate([
            'health_record' => 'array',
            'health_record.primary_vet_name' => 'nullable|string|max:255',
            'health_record.blood_type' => 'nullable|string|max:20',
            'health_record.allergies' => 'nullable|string',
            'health_record.current_medications' => 'nullable|string',
        ]);

        // ⚠️ ici ça fonctionnera bien car $validatedHealth['health_record'] existe
        $pet->healthRecord()->updateOrCreate(
            ['pet_id' => $pet->id],
            $validatedHealth['health_record']
        );

        return redirect()->route('pets.index', $pet->id)
            ->with('success', 'Profil animal mis à jour');
    }

    public function destroy(Pet $pet)
    {
        $pet->delete();

        return redirect()->route('pets.index')
            ->with('success', 'Animal supprimé');
    }
}
