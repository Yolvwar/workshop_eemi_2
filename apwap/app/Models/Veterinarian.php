<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Veterinarian extends Model
{
    use HasFactory;

    /**
     * Indicates if the model's ID is auto-incrementing.
     */
    public $incrementing = false;

    /**
     * The data type of the auto-incrementing ID.
     */
    protected $keyType = 'string';

    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'email',
        'phone',
        'license_number',
        'specialties',
        'specializations',
        'languages',
        'experience_years',
        'rating',
        'total_reviews',
        'hourly_rate',
        'consultation_fee',
        'home_visit_rate',
        'home_visit_fee',
        'teleconsultation_fee',
        'emergency_fee',
        'clinic_name',
        'clinic_address',
        'clinic_phone',
        'service_areas',
        'working_hours',
        'availability_schedule',
        'availability_status',
        'is_active',
        'is_emergency_available',
        'avatar_url',
        'bio',
        'education',
        'certifications',
    ];

    protected $casts = [
        'specialties' => 'array',
        'specializations' => 'array',
        'languages' => 'array',
        'rating' => 'decimal:1',
        'hourly_rate' => 'decimal:2',
        'consultation_fee' => 'decimal:2',
        'home_visit_rate' => 'decimal:2',
        'home_visit_fee' => 'decimal:2',
        'teleconsultation_fee' => 'decimal:2',
        'emergency_fee' => 'decimal:2',
        'availability_schedule' => 'array',
        'working_hours' => 'array',
        'is_active' => 'boolean',
        'is_verified' => 'boolean',
        'is_emergency_available' => 'boolean',
        'education' => 'array',
        'certifications' => 'array',
        'verification_date' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }

    // Relations
    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeEmergencyAvailable($query)
    {
        return $query->where('is_emergency_available', true);
    }

    public function scopeWithSpecialty($query, $specialty)
    {
        return $query->whereJsonContains('specialties', $specialty);
    }

    public function scopeWithLanguage($query, $language)
    {
        return $query->whereJsonContains('languages', $language);
    }

    // Accessors
    public function getFormattedRateAttribute()
    {
        return $this->hourly_rate . ' AED/h';
    }

    public function getFormattedHomeVisitRateAttribute()
    {
        return $this->home_visit_rate . ' AED/h';
    }

    public function getSpecialtiesStringAttribute()
    {
        return is_array($this->specialties) ? implode(', ', $this->specialties) : '';
    }

    public function getLanguagesStringAttribute()
    {
        return is_array($this->languages) ? implode(', ', $this->languages) : '';
    }

    // Methods
    public function hasSpecialty($specialty)
    {
        return in_array($specialty, $this->specialties ?? []);
    }

    public function speaksLanguage($language)
    {
        return in_array($language, $this->languages ?? []);
    }

    public function isAvailableAt($datetime)
    {
        // Logic to check availability based on schedule
        // This would be implemented based on the availability_schedule structure
        return true; // Placeholder
    }

    public function getNextAvailableSlot()
    {
        // Logic to find next available time slot
        return now()->addDay(); // Placeholder
    }
}
