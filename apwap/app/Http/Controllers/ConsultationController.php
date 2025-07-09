<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Consultation;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function index(Pet $pet)
    {
        $consultations = $pet->consultations()->get();
        return view('consultations.index', ['pet' => $pet, 'consultations' => $consultations]);
    }

    public function create(Pet $pet)
    {
        return view('consultations.create', ['pet' => $pet]);
    }

    public function store(Request $request, Pet $pet)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $consultation = $pet->consultations()->create($validated);

        return redirect()->route('pets.consultations.show', [$pet->id, $consultation->id])
            ->with('success', 'Consultation ajoutée');
    }

    public function show(Pet $pet, Consultation $consultation)
    {
        return view('consultations.show', ['pet' => $pet, 'consultation' => $consultation]);
    }

    public function edit(Pet $pet, Consultation $consultation)
    {
        return view('consultations.edit', ['pet' => $pet, 'consultation' => $consultation]);
    }

    public function update(Request $request, Pet $pet, Consultation $consultation)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $consultation->update($validated);

        return redirect()->route('pets.consultations.show', [$pet->id, $consultation->id])
            ->with('success', 'Consultation mise à jour');
    }

    public function destroy(Pet $pet, Consultation $consultation)
    {
        $consultation->delete();

        return redirect()->route('pets.consultations.index', $pet->id)
            ->with('success', 'Consultation supprimée');
    }
}
