<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Veterinarian extends Model
{
    use HasUuids;

    protected $table = 'veterinarians';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'avatar_url',
        'license_number',
        'specializations',
        'languages',
        'experience_years',
        'clinic_name',
        'clinic_address',
        'clinic_phone',
        'service_areas',
        'working_hours',
        'availability_status',
        'consultation_fee',
        'home_visit_fee',
        'teleconsultation_fee',
        'emergency_fee',
        'rating',
        'total_reviews',
        'total_consultations',
        'is_active',
        'is_verified',
        'verification_date',
    ];

    protected $casts = [
        'working_hours' => 'array',
        'consultation_fee' => 'decimal:2',
        'home_visit_fee' => 'decimal:2',
        'teleconsultation_fee' => 'decimal:2',
        'emergency_fee' => 'decimal:2',
        'rating' => 'decimal:2',
        'is_active' => 'boolean',
        'is_verified' => 'boolean',
        'verification_date' => 'datetime',
    ];

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

}
