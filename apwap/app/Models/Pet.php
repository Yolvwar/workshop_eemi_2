<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Pet extends Model
{
    use HasUuids;

    protected $table = 'pets';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'name',
        'species',
        'breed',
        'gender',
        'is_neutered',
        'birth_date',
        'adoption_date',
        'registration_date',
        'weight',
        'height',
        'color',
        'markings',
        'microchip_number',
        'registration_number',
        'passport_number',
        'energy_level',
        'sociability',
        'obedience_level',
        'favorite_toys',
        'feeding_schedule',
        'exercise_routine',
        'sleeping_habits',
        'fears_phobias',
        'health_score',
        'education_score',
        'nutrition_score',
        'activity_score',
        'lifestyle_score',
        'emotional_score',
        'overall_score',
        'profile_image_url',
        'is_active',
    ];

    protected $casts = [
        'is_neutered' => 'boolean',
        'birth_date' => 'date',
        'adoption_date' => 'date',
        'registration_date' => 'date',
        'weight' => 'decimal:2',
        'height' => 'decimal:2',
        'energy_level' => 'integer',
        'obedience_level' => 'integer',
        'health_score' => 'integer',
        'education_score' => 'integer',
        'nutrition_score' => 'integer',
        'activity_score' => 'integer',
        'lifestyle_score' => 'integer',
        'emotional_score' => 'integer',
        'overall_score' => 'integer',
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasMany(PetPhoto::class);
    }

    public function medicalHistories()
    {
        return $this->hasMany(PetMedicalHistory::class);
    }

    public function vaccinations()
    {
        return $this->hasMany(PetVaccination::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function healthRecord()
    {
        return $this->hasOne(PetHealthRecord::class);
    }


}
