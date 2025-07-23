<?php

namespace Database\Seeders;

use App\Models\Veterinarian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VeterinarianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $veterinarians = [
            [
                'first_name' => 'Sarah',
                'last_name' => 'Al-Rashid',
                'email' => 'sarah.alrashid@apwap.ae',
                'phone' => '+971-50-123-4567',
                'license_number' => 'DXB-VET-2019-001',
                'specializations' => 'nutrition,digestion,preventive_care',
                'languages' => 'français,anglais,arabe',
                'experience_years' => 8,
                'rating' => 4.9,
                'total_reviews' => 127,
                'consultation_fee' => 400.00,
                'home_visit_fee' => 500.00,
                'teleconsultation_fee' => 150.00,
                'emergency_fee' => 800.00,
                'clinic_name' => 'APWAP Clinic JLT',
                'clinic_address' => 'APWAP Clinic, Jumeirah Lake Towers, Dubai',
                'availability_status' => 'available',
                'service_areas' => 'Dubai,JLT,Marina,Downtown',
                'working_hours' => [
                    'monday' => ['start' => '08:00', 'end' => '18:00'],
                    'tuesday' => ['start' => '08:00', 'end' => '18:00'],
                    'wednesday' => ['start' => '08:00', 'end' => '18:00'],
                    'thursday' => ['start' => '08:00', 'end' => '18:00'],
                    'friday' => ['start' => '08:00', 'end' => '18:00'],
                    'saturday' => ['start' => '09:00', 'end' => '16:00'],
                    'sunday' => ['start' => '10:00', 'end' => '14:00'],
                ],
            ],
            [
                'first_name' => 'James',
                'last_name' => 'Wilson',
                'email' => 'james.wilson@apwap.ae',
                'phone' => '+971-50-234-5678',
                'license_number' => 'DXB-VET-2018-002',
                'specializations' => 'geriatrics,orthopedics,pain_management',
                'languages' => 'anglais,hindi',
                'experience_years' => 12,
                'rating' => 4.8,
                'total_reviews' => 98,
                'consultation_fee' => 450.00,
                'home_visit_fee' => 550.00,
                'teleconsultation_fee' => 200.00,
                'emergency_fee' => 900.00,
                'clinic_name' => 'APWAP Clinic JLT',
                'clinic_address' => 'APWAP Clinic, Jumeirah Lake Towers, Dubai',
                'availability_status' => 'available',
                'service_areas' => 'Dubai,JLT,Marina,DIFC',
                'working_hours' => [
                    'monday' => ['start' => '09:00', 'end' => '17:00'],
                    'tuesday' => ['start' => '09:00', 'end' => '17:00'],
                    'wednesday' => ['start' => '09:00', 'end' => '17:00'],
                    'thursday' => ['start' => '09:00', 'end' => '17:00'],
                    'friday' => ['start' => '09:00', 'end' => '17:00'],
                    'saturday' => ['start' => '10:00', 'end' => '15:00'],
                ],
            ],
            [
                'first_name' => 'Maria',
                'last_name' => 'Martinez',
                'email' => 'maria.martinez@apwap.ae',
                'phone' => '+971-50-345-6789',
                'license_number' => 'DXB-VET-2020-003',
                'specializations' => 'behavior,cats,anxiety_treatment',
                'languages' => 'espagnol,anglais,français',
                'experience_years' => 6,
                'rating' => 4.7,
                'total_reviews' => 76,
                'consultation_fee' => 350.00,
                'home_visit_fee' => 450.00,
                'teleconsultation_fee' => 150.00,
                'emergency_fee' => 700.00,
                'clinic_name' => 'APWAP Behavior Center',
                'clinic_address' => 'APWAP Clinic, Jumeirah Lake Towers, Dubai',
                'availability_status' => 'available',
                'service_areas' => 'Dubai,JLT,Marina',
                'working_hours' => [
                    'tuesday' => ['start' => '10:00', 'end' => '18:00'],
                    'wednesday' => ['start' => '10:00', 'end' => '18:00'],
                    'thursday' => ['start' => '10:00', 'end' => '18:00'],
                    'friday' => ['start' => '10:00', 'end' => '18:00'],
                    'saturday' => ['start' => '09:00', 'end' => '17:00'],
                ],
            ],
        ];

        foreach ($veterinarians as $vetData) {
            Veterinarian::create($vetData);
        }
    }
}
