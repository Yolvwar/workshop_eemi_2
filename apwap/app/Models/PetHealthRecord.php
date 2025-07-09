<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PetHealthRecord extends Model
{
    use HasUuids;

    protected $table = 'pet_health_records';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'pet_id',
        'blood_type',
        'allergies',
        'chronic_conditions',
        'current_medications',
        'dietary_restrictions',
        'insurance_provider',
        'insurance_policy_number',
        'insurance_expires_at',
        'primary_vet_name',
        'primary_vet_clinic',
        'primary_vet_phone',
        'primary_vet_email',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relation',
    ];

    protected $casts = [
        'insurance_expires_at' => 'date',
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}
