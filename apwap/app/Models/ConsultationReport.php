<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ConsultationReport extends Model
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
        'consultation_id',
        'symptoms_observed',
        'diagnosis_details',
        'treatment_plan',
        'prescriptions_details',
        'recommendations_details',
        'next_appointment_needed',
        'next_appointment_date',
        'general_condition',
        'weight_recorded',
        'temperature_recorded',
        'heart_rate_recorded',
        'blood_pressure_recorded',
        'additional_notes',
        'files_attached',
        'images_urls',
        'lab_results',
    ];

    protected $casts = [
        'next_appointment_date' => 'datetime',
        'next_appointment_needed' => 'boolean',
        'weight_recorded' => 'decimal:2',
        'temperature_recorded' => 'decimal:1',
        'prescriptions_details' => 'array',
        'recommendations_details' => 'array',
        'files_attached' => 'array',
        'images_urls' => 'array',
        'lab_results' => 'array',
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
    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    // Accessors
    public function getFormattedWeightAttribute()
    {
        return $this->weight_recorded ? $this->weight_recorded . ' kg' : null;
    }

    public function getFormattedTemperatureAttribute()
    {
        return $this->temperature_recorded ? $this->temperature_recorded . '°C' : null;
    }

    // Methods
    public function hasAttachments()
    {
        return !empty($this->files_attached) || !empty($this->images_urls);
    }

    public function hasLabResults()
    {
        return !empty($this->lab_results);
    }

    public function requiresFollowUp()
    {
        return $this->next_appointment_needed && $this->next_appointment_date;
    }
}
