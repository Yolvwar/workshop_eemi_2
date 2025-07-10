<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vérifier si l'utilisateur existe (ID 1)
        $user = DB::table('users')->first();
        if (!$user) {
            // Créer un utilisateur de test
            $userId = DB::table('users')->insertGetId([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $userId = $user->id;
        }

        // Vider les tables existantes
        DB::table('pet_health_records')->delete();
        DB::table('pet_vaccinations')->delete();
        DB::table('pet_medical_history')->delete();
        DB::table('pet_photos')->delete();
        DB::table('consultations')->delete();
        DB::table('pets')->delete();
        DB::table('veterinarians')->delete();

        // Créer des vétérinaires
        $vet1Id = DB::table('veterinarians')->insertGetId([
            'name' => 'Dr. Sarah Johnson',
            'speciality' => 'Médecine générale',
            'phone' => '+971-4-123-4567',
            'email' => 'dr.johnson@dubaivets.com',
            'address' => 'Dubai Veterinary Clinic, Downtown Dubai',
            'license_number' => 'DXB-VET-001',
            'years_experience' => 8,
            'languages' => json_encode(['English', 'French', 'Arabic']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $vet2Id = DB::table('veterinarians')->insertGetId([
            'name' => 'Dr. Ahmed Al-Mansouri',
            'speciality' => 'Orthopédie',
            'phone' => '+971-4-765-4321',
            'email' => 'dr.ahmed@dubaivets.com',
            'address' => 'Dubai Animal Hospital, Jumeirah',
            'license_number' => 'DXB-VET-002',
            'years_experience' => 12,
            'languages' => json_encode(['Arabic', 'English']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Créer des animaux de compagnie
        $maxId = DB::table('pets')->insertGetId([
            'user_id' => $userId,
            'name' => 'Max',
            'species' => 'Chien',
            'breed' => 'Golden Retriever',
            'date_of_birth' => Carbon::now()->subYears(3)->subMonths(6),
            'gender' => 'Mâle',
            'weight' => 28.5,
            'color' => 'Doré',
            'microchip_number' => 'MC001234567890',
            'is_sterilized' => true,
            'allergies' => json_encode(['Poulet', 'Acariens']),
            'medical_conditions' => json_encode(['Sensibilité digestive']),
            'personality_traits' => json_encode(['Énergique', 'Sociable', 'Obéissant']),
            'favorite_activities' => json_encode(['Natation', 'Fetch', 'Promenades']),
            'emergency_contact_name' => 'Marie Dubois',
            'emergency_contact_phone' => '+971-50-123-4567',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $buddyId = DB::table('pets')->insertGetId([
            'user_id' => $userId,
            'name' => 'Buddy',
            'species' => 'Chien',
            'breed' => 'Labrador',
            'date_of_birth' => Carbon::now()->subYears(8)->subMonths(2),
            'gender' => 'Mâle',
            'weight' => 32.0,
            'color' => 'Chocolat',
            'microchip_number' => 'MC001234567891',
            'is_sterilized' => true,
            'allergies' => json_encode(['Aucune connue']),
            'medical_conditions' => json_encode(['Arthrite', 'Surpoids']),
            'personality_traits' => json_encode(['Calme', 'Affectueux', 'Gourmand']),
            'favorite_activities' => json_encode(['Siestes', 'Jeux doux', 'Caresses']),
            'emergency_contact_name' => 'Pierre Martin',
            'emergency_contact_phone' => '+971-50-234-5678',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $lunaId = DB::table('pets')->insertGetId([
            'user_id' => $userId,
            'name' => 'Luna',
            'species' => 'Chat',
            'breed' => 'Maine Coon',
            'date_of_birth' => Carbon::now()->subYears(2)->subMonths(9),
            'gender' => 'Femelle',
            'weight' => 4.8,
            'color' => 'Gris argenté',
            'microchip_number' => 'MC001234567892',
            'is_sterilized' => true,
            'allergies' => json_encode(['Poisson']),
            'medical_conditions' => json_encode(['Aucune']),
            'personality_traits' => json_encode(['Indépendante', 'Joueuse', 'Curieuse']),
            'favorite_activities' => json_encode(['Chasse aux jouets', 'Observation', 'Toilettage']),
            'emergency_contact_name' => 'Sophie Laurent',
            'emergency_contact_phone' => '+971-50-345-6789',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Créer des consultations
        $consultation1Id = DB::table('consultations')->insertGetId([
            'pet_id' => $buddyId,
            'veterinarian_id' => $vet2Id,
            'date' => Carbon::today()->addHours(14), // 14h aujourd'hui
            'type' => 'Consultation',
            'reason' => 'Suivi arthrite - Contrôle évolution',
            'symptoms' => json_encode(['Raideur matinale', 'Difficulté à se lever']),
            'diagnosis' => null, // Consultation à venir
            'treatment' => null,
            'medications' => null,
            'notes' => 'Consultation de suivi pour évaluer l\'efficacité du traitement contre l\'arthrite',
            'follow_up_date' => Carbon::today()->addWeeks(4),
            'status' => 'Planifiée',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $consultation2Id = DB::table('consultations')->insertGetId([
            'pet_id' => $maxId,
            'veterinarian_id' => $vet1Id,
            'date' => Carbon::today()->addHours(16)->addMinutes(30), // 16h30 aujourd'hui
            'type' => 'Consultation',
            'reason' => 'Consultation nutritionnelle - Adaptation régime chaleur',
            'symptoms' => json_encode(['Diminution appétit', 'Léthargie']),
            'diagnosis' => null,
            'treatment' => null,
            'medications' => null,
            'notes' => 'Adaptation du régime alimentaire pour la saison chaude',
            'follow_up_date' => Carbon::today()->addWeeks(2),
            'status' => 'Planifiée',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Toilettage Luna demain
        $consultation3Id = DB::table('consultations')->insertGetId([
            'pet_id' => $lunaId,
            'veterinarian_id' => $vet1Id,
            'date' => Carbon::tomorrow()->addHours(10), // 10h demain
            'type' => 'Toilettage',
            'reason' => 'Toilettage mensuel - Entretien pelage',
            'symptoms' => json_encode([]),
            'diagnosis' => null,
            'treatment' => null,
            'medications' => null,
            'notes' => 'Toilettage complet avec brossage spécialisé Maine Coon',
            'follow_up_date' => Carbon::tomorrow()->addMonth(),
            'status' => 'Planifiée',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Historique médical pour Buddy (arthrite)
        DB::table('pet_medical_history')->insert([
            'pet_id' => $buddyId,
            'date' => Carbon::now()->subMonths(6),
            'condition' => 'Arthrite',
            'diagnosis' => 'Arthrite des hanches et genoux diagnostiquée',
            'treatment' => 'Anti-inflammatoires, compléments glucosamine',
            'veterinarian' => 'Dr. Ahmed Al-Mansouri',
            'notes' => 'Début des symptômes il y a 8 mois, diagnostic confirmé par radiographie',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Enregistrements de santé récents
        // Max - Santé générale bonne
        DB::table('pet_health_records')->insert([
            'pet_id' => $maxId,
            'date' => Carbon::now()->subDays(30),
            'weight' => 28.5,
            'temperature' => 38.2,
            'heart_rate' => 120,
            'notes' => 'Santé générale excellente, très actif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Buddy - Problèmes arthrite
        DB::table('pet_health_records')->insert([
            'pet_id' => $buddyId,
            'date' => Carbon::now()->subDays(15),
            'weight' => 32.0,
            'temperature' => 38.5,
            'heart_rate' => 100,
            'notes' => 'Arthrite en progression, mobilité réduite le matin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Luna - Excellente santé
        DB::table('pet_health_records')->insert([
            'pet_id' => $lunaId,
            'date' => Carbon::now()->subDays(20),
            'weight' => 4.8,
            'temperature' => 38.0,
            'heart_rate' => 180,
            'notes' => 'Santé parfaite, très active et joueuse',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Vaccinations
        // Max - À jour
        DB::table('pet_vaccinations')->insert([
            'pet_id' => $maxId,
            'vaccine_name' => 'DHPP (Distemper, Hepatitis, Parvovirus, Parainfluenza)',
            'date_administered' => Carbon::now()->subMonths(11),
            'next_due_date' => Carbon::now()->addMonth(),
            'veterinarian' => 'Dr. Sarah Johnson',
            'batch_number' => 'VAC2024001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Buddy - À jour
        DB::table('pet_vaccinations')->insert([
            'pet_id' => $buddyId,
            'vaccine_name' => 'DHPP + Rage',
            'date_administered' => Carbon::now()->subMonths(10),
            'next_due_date' => Carbon::now()->addMonths(2),
            'veterinarian' => 'Dr. Ahmed Al-Mansouri',
            'batch_number' => 'VAC2024002',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Luna - À jour
        DB::table('pet_vaccinations')->insert([
            'pet_id' => $lunaId,
            'vaccine_name' => 'FVRCP (Feline Viral Rhinotracheitis, Calicivirus, Panleukopenia)',
            'date_administered' => Carbon::now()->subMonths(9),
            'next_due_date' => Carbon::now()->addMonths(3),
            'veterinarian' => 'Dr. Sarah Johnson',
            'batch_number' => 'VAC2024003',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        echo "✅ Données de démonstration créées avec succès !\n";
        echo "👥 Utilisateur créé/utilisé : {$user->email ?? 'test@example.com'}\n";
        echo "🐕 Animaux créés : Max (Golden Retriever), Buddy (Labrador), Luna (Maine Coon)\n";
        echo "👨‍⚕️ Vétérinaires créés : Dr. Sarah Johnson, Dr. Ahmed Al-Mansouri\n";
        echo "📅 Consultations planifiées : 2 aujourd'hui, 1 demain\n";
        echo "🏥 Historique médical et vaccinations à jour\n";
    }
}
