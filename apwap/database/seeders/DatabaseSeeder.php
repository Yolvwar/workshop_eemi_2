<?php

namespace Database\Seeders;

use Hash;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            ['email' => 'test@mail.com'], // clé unique pour rechercher l'utilisateur
            [
                'first_name' => 'Test',
                'last_name' => 'User',
                'password' => Hash::make('password'),
            ]
        );


        // Ajouter les données de la boutique
        $this->call([
            ShopSeeder::class,
            VeterinarianSeeder::class,
            PetSeeder::class,
            PetHealthRecordSeeder::class
        ]);
    }
}
