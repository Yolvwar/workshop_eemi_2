<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Consultation extends Model
{
    use HasUuids;

    protected $table = 'consultations';

    // Le champ id est un UUID, on désactive l'incrément automatique
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'pet_id',
        'veterinarian_id',
        'type',
        'mode',
        'status',
        'scheduled_date',
        'scheduled_time',
        'duration_minutes',
        'location_type',
        'address',
        'latitude',
        'longitude',
        'chief_complaint',
        'symptoms',
        'examination_findings',
        'diagnosis',
        'treatment_plan',
        'prescriptions',
        'recommendations',
        'follow_up_instructions',
        'consultation_fee',
        'additional_fees',
        'total_cost',
        'payment_status',
        'started_at',
        'completed_at',
        'priority',
        'urgency_notes',
        'documents',
        'user_rating',
        'user_review',
        'vet_notes',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'scheduled_time' => 'time',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'documents' => 'array',
        'latitude' => 'float',
        'longitude' => 'float',
        'consultation_fee' => 'decimal:2',
        'additional_fees' => 'decimal:2',
        'total_cost' => 'decimal:2',
    ];

    // Relations
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function veterinarian()
    {
        return $this->belongsTo(Veterinarian::class);
    }

    public function medicalHistories()
    {
        return $this->hasMany(PetMedicalHistory::class);
    }

}
