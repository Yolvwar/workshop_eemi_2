<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\PetPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PetPhotoController extends Controller
{
    public function index(Pet $pet)
    {
        $photos = $pet->photos()->get();
        return view('photos.index', ['pet' => $pet, 'photos' => $photos]);
    }

    public function create(Pet $pet)
    {
        return view('photos.create', ['pet' => $pet]);
    }

    public function store(Request $request, Pet $pet)
    {
        $validated = $request->validate([
            'photo' => 'required|image|max:2048',
            'description' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('pet_photos', 'public');
            $validated['path'] = $path;
        }

        $pet->photos()->create($validated);

        return redirect()->route('pets.photos.index', $pet->id)
            ->with('success', 'Photo ajoutée');
    }

    public function show(Pet $pet, PetPhoto $photo)
    {
        return view('photos.show', ['pet' => $pet, 'photo' => $photo]);
    }

    public function edit(Pet $pet, PetPhoto $photo)
    {
        return view('photos.edit', ['pet' => $pet, 'photo' => $photo]);
    }

    public function update(Request $request, Pet $pet, PetPhoto $photo)
    {
        $validated = $request->validate([
            'description' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            Storage::disk('public')->delete($photo->path);
            $path = $request->file('photo')->store('pet_photos', 'public');
            $validated['path'] = $path;
        }

        $photo->update($validated);

        return redirect()->route('pets.photos.show', [$pet->id, $photo->id])
            ->with('success', 'Photo mise à jour');
    }

    public function destroy(Pet $pet, PetPhoto $photo)
    {
        Storage::disk('public')->delete($photo->path);
        $photo->delete();

        return redirect()->route('pets.photos.index', $pet->id)
            ->with('success', 'Photo supprimée');
    }
}
