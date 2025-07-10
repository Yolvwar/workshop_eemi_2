<?php

namespace Database\Seeders;

use App\Models\Pet;
use App\Models\PetHealthRecord;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PetHealthRecordSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Liste de vétérinaires existants (tu peux bien sûr en tirer dynamiquement depuis la table `veterinarians`)
        $vets = [
            [
                'name' => 'Alfred Guyot',
                'clinic' => 'Ruiz',
                'phone' => '07 60 91 56 95',
                'email' => 'georges76@example.org',
            ],
            [
                'name' => 'Tristan Philippe',
                'clinic' => 'Vallet',
                'phone' => '+33 (0)1 70 36 54 93',
                'email' => 'humbert.denis@example.com',
            ],
            [
                'name' => 'Frédéric Techer',
                'clinic' => 'Fernandez Le Goff SAS',
                'phone' => '04 21 13 15 79',
                'email' => 'benoit38@example.net',
            ],
        ];

        // Récupérer les animaux existants (tu peux adapter à ton cas)
        $pets = Pet::all();

        foreach ($pets as $index => $pet) {
            $vet = $vets[$index % count($vets)];

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
                    'insurance_expires_at' => Carbon::now()->addYear(),

                    'primary_vet_name' => $vet['name'],
                    'primary_vet_clinic' => $vet['clinic'],
                    'primary_vet_phone' => $vet['phone'],
                    'primary_vet_email' => $vet['email'],

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
