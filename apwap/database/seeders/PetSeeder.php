<?php

namespace Database\Seeders;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class PetSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $userIds = User::pluck('id');

        if ($userIds->isEmpty()) {
            $this->command->warn('No users found. Skipping PetSeeder.');
            return;
        }

        foreach (range(1, 20) as $i) {
            Pet::create([
                'user_id' => $faker->randomElement($userIds),
                'name' => Str::substr($faker->firstName, 0, 50),
                'species' => $faker->randomElement(['dog', 'cat']),
                'breed' => Str::substr($faker->word, 0, 50),
                'gender' => $faker->randomElement(['male', 'female']),
                'is_neutered' => $faker->boolean,
                'birth_date' => $faker->dateTimeBetween('-10 years', '-6 months'),
                'adoption_date' => $faker->dateTimeBetween('-9 years', '-3 months'),
                'registration_date' => $faker->dateTimeBetween('-9 years', 'now'),
                'weight' => $faker->randomFloat(2, 1.0, 60.0),
                'height' => $faker->randomFloat(2, 10.0, 120.0),
                'color' => Str::substr($faker->safeColorName, 0, 50),
                'markings' => Str::substr($faker->optional()->sentence ?? '', 0, 50),
                'microchip_number' => Str::substr($faker->optional()->numerify('###########') ?? '', 0, 50),
                'registration_number' => Str::substr($faker->optional()->bothify('REG-####-???') ?? '', 0, 50),
                'passport_number' => Str::substr($faker->optional()->bothify('PA-###-????') ?? '', 0, 50),
                'energy_level' => $faker->numberBetween(1, 10),
                'sociability' => Str::substr($faker->sentence, 0, 50),
                'obedience_level' => $faker->numberBetween(1, 10),
                'favorite_toys' => Str::substr(implode(', ', $faker->words(3)), 0, 50),
                'feeding_schedule' => Str::substr($faker->sentence, 0, 50),
                'exercise_routine' => Str::substr($faker->sentence, 0, 50),
                'sleeping_habits' => Str::substr($faker->sentence, 0, 50),
                'fears_phobias' => Str::substr($faker->optional()->sentence ?? '', 0, 50),
                'health_score' => $faker->numberBetween(50, 100),
                'education_score' => $faker->numberBetween(50, 100),
                'nutrition_score' => $faker->numberBetween(50, 100),
                'activity_score' => $faker->numberBetween(50, 100),
                'lifestyle_score' => $faker->numberBetween(50, 100),
                'emotional_score' => $faker->numberBetween(50, 100),
                'overall_score' => $faker->numberBetween(50, 100),
                'profile_image_url' => $faker->imageUrl(300, 300, 'animals', true),
                'is_active' => $faker->boolean(90),
            ]);
        }
    }
}
