<?php

namespace Database\Seeders;

use App\Models\Pet;
use App\Models\PetHealthRecord;
use App\Models\Veterinarian;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PetHealthRecordSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Récupérer tous les vétérinaires existants
        $vets = Veterinarian::all();

        // Récupérer tous les animaux
        $pets = Pet::all();

        foreach ($pets as $index => $pet) {
            // Choisir un vétérinaire cycliquement
            $vet = $vets->count() ? $vets[$index % $vets->count()] : null;

            PetHealthRecord::updateOrCreate(
                ['pet_id' => $pet->id],
                [
                    'id' => Str::uuid(),
                    'blood_type' => ['A', 'B', 'AB', 'O'][array_rand(['A', 'B', 'AB', 'O'])],
                    'allergies' => 'Pollen, gluten',
                    'chronic_conditions' => 'Arthrite',
                    'current_medications' => 'Anti-inflammatoires',
                    'dietary_restrictions' => 'Sans gluten',

                    'insurance_provider' => 'AssurPet',
                    'insurance_policy_number' => strtoupper(Str::random(10)),
                    'insurance_expires_at' => $now->copy()->addYear(),

                    // Infos vétérinaire à partir du modèle Veterinarian
                    'primary_vet_name' => $vet ? $vet->full_name : null,
                    'primary_vet_clinic' => $vet ? $vet->clinic_name : null,
                    'primary_vet_phone' => $vet ? $vet->clinic_phone : null,
                    'primary_vet_email' => $vet ? $vet->email : null,

                    'emergency_contact_name' => 'Jean Dupont',
                    'emergency_contact_phone' => '06 11 22 33 44',
                    'emergency_contact_relation' => 'Propriétaire',

                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}
