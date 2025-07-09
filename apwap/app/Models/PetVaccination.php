<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PetVaccination extends Model
{
    use HasUuids;

    protected $table = 'pet_vaccinations';

    protected $keyType = 'string'; // UUID as string
    public $incrementing = false;

    protected $fillable = [
        'pet_id',
        'vaccine_name',
        'vaccine_type',
        'batch_number',
        'manufacturer',
        'administered_date',
        'expiry_date',
        'next_due_date',
        'clinic_name',
        'veterinarian_name',
        'veterinarian_license',
        'side_effects',
        'notes',
        'certificate_url',
    ];

    protected $dates = [
        'administered_date',
        'expiry_date',
        'next_due_date',
        'created_at',
        'updated_at',
    ];

    // Relations
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}
