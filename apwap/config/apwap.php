<?php

return [
    /*
    |--------------------------------------------------------------------------
    | APWAP Authentication Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration spécifique pour l'authentification APWAP
    |
    */

    'registration' => [
        'enabled' => true,
        'default_country' => 'UAE',
        'default_city' => 'Dubai',
        'default_language' => 'fr',
        'default_timezone' => 'Asia/Dubai',
        'default_currency' => 'AED',
        'require_phone_verification' => true,
        'require_email_verification' => true,
    ],

    'login' => [
        'max_attempts' => 5,
        'lockout_duration' => 60, // minutes
        'remember_me_duration' => 43200, // minutes (30 days)
    ],

    'password' => [
        'min_length' => 8,
        'require_uppercase' => true,
        'require_lowercase' => true,
        'require_numbers' => true,
        'require_symbols' => false,
    ],

    'supported_languages' => [
        'fr' => 'Français',
        'en' => 'English', 
        'ar' => 'العربية',
    ],

    'supported_cities' => [
        'Dubai' => 'Dubai',
        'Abu Dhabi' => 'Abu Dhabi',
        'Sharjah' => 'Sharjah',
        'Ajman' => 'Ajman',
        'Ras Al Khaimah' => 'Ras Al Khaimah',
        'Fujairah' => 'Fujairah',
        'Umm Al Quwain' => 'Umm Al Quwain',
    ],

    'notifications' => [
        'welcome_email' => true,
        'sms_verification' => true,
        'appointment_reminders' => true,
    ],

    'features' => [
        'multi_pet_support' => true,
        'emergency_contacts' => true,
        'loyalty_program' => true,
        'premium_membership' => true,
    ],
];
