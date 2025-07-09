<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PetMedicalHistory extends Model
{
    use HasUuids;

    protected $table = 'pet_medical_history';

    protected $keyType = 'string'; // UUID as string
    public $incrementing = false;

    protected $fillable = [
        'pet_id',
        'consultation_id',
        'entry_type',
        'title',
        'description',
        'diagnosis',
        'treatment',
        'prescription',
        'recommendations',
        'cost',
        'insurance_covered',
        'date_occurred',
        'follow_up_date',
        'veterinarian_name',
        'clinic_name',
        'documents',
    ];

    protected $casts = [
        'documents' => 'array',
        'cost' => 'decimal:2',
        'insurance_covered' => 'decimal:2',
        'date_occurred' => 'date',
        'follow_up_date' => 'date',
    ];

    // Relations
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

}
