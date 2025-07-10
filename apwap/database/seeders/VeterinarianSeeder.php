<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Veterinarian;
use Faker\Factory as Faker;

class VeterinarianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('fr_FR');

        foreach (range(1, 10) as $i) {
            Veterinarian::create([
                'id' => Str::uuid(),
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'avatar_url' => $faker->imageUrl(200, 200, 'people'),
                'license_number' => 'VET-' . strtoupper(Str::random(6)),
                'specializations' => $faker->randomElement(['Chiens', 'Chats', 'NAC', 'Exotiques']),
                'languages' => 'Français, Anglais',
                'experience_years' => $faker->numberBetween(1, 30),
                'clinic_name' => $faker->company,
                'clinic_address' => $faker->address,
                'clinic_phone' => $faker->phoneNumber,
                'service_areas' => $faker->city,
                'working_hours' => json_encode([
                    'monday' => '09:00-17:00',
                    'tuesday' => '09:00-17:00',
                    'wednesday' => '09:00-17:00',
                    'thursday' => '09:00-17:00',
                    'friday' => '09:00-17:00',
                ]),
                'availability_status' => $faker->randomElement(['available', 'busy', 'on_leave']),
                'consultation_fee' => $faker->randomFloat(2, 20, 80),
                'home_visit_fee' => $faker->randomFloat(2, 30, 100),
                'teleconsultation_fee' => $faker->randomFloat(2, 15, 60),
                'emergency_fee' => $faker->randomFloat(2, 50, 150),
                'rating' => $faker->randomFloat(2, 3.0, 5.0),
                'total_reviews' => $faker->numberBetween(0, 200),
                'total_consultations' => $faker->numberBetween(0, 500),
                'is_active' => true,
                'is_verified' => $faker->boolean,
                'verification_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
