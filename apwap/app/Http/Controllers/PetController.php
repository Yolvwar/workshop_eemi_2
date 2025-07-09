<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function index()
    {
        $pets = Pet::all();
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
            'age' => 'nullable|integer|min:0'
        ]);

        $pet = Pet::create($validated);

        return redirect()->route('pets.show', $pet->id)
            ->with('success', 'Animal ajouté avec succès');
    }

    public function show(Pet $pet)
    {
        return view('pets.show', ['pet' => $pet]);
    }

    public function edit(Pet $pet)
    {
        return view('pets.edit', ['pet' => $pet]);
    }

    public function update(Request $request, Pet $pet)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:0'
        ]);

        $pet->update($validated);

        return redirect()->route('pets.show', $pet->id)
            ->with('success', 'Profil animal mis à jour');
    }

    public function destroy(Pet $pet)
    {
        $pet->delete();

        return redirect()->route('pets.index')
            ->with('success', 'Animal supprimé');
    }
}
