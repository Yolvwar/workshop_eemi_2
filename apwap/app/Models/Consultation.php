<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Consultation extends Model
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
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'consultation_fee' => 'decimal:2',
        'additional_fees' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'user_rating' => 'integer',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'documents' => 'array',
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
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function veterinarian()
    {
        return $this->belongsTo(Veterinarian::class);
    }

    // public function consultationReports()
    // {
    //     return $this->hasMany(ConsultationReport::class);
    // }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('scheduled_date', '>=', today())
                    ->where('status', '!=', 'cancelled');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeUrgent($query)
    {
        return $query->where('priority', 'urgent');
    }

    public function scopeToday($query)
    {
        return $query->where('scheduled_date', today());
    }

    // Accessors
    public function getFormattedCostAttribute()
    {
        return $this->total_cost . ' AED';
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'scheduled' => 'bg-blue-100 text-blue-800',
            'in_progress' => 'bg-yellow-100 text-yellow-800',
            'completed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            'no_show' => 'bg-gray-100 text-gray-800',
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getUrgencyBadgeAttribute()
    {
        $badges = [
            'normal' => 'bg-green-100 text-green-800',
            'medium' => 'bg-yellow-100 text-yellow-800',
            'high' => 'bg-orange-100 text-orange-800',
            'urgent' => 'bg-red-100 text-red-800',
            'emergency' => 'bg-red-600 text-white animate-pulse',
        ];

        return $badges[$this->priority] ?? 'bg-gray-100 text-gray-800';
    }

    // Methods
    public function canBeCancelled()
    {
        $scheduledDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', 
            $this->scheduled_date->format('Y-m-d') . ' ' . $this->scheduled_time
        );
        
        return in_array($this->status, ['scheduled']) && 
               $scheduledDateTime > now()->addHours(24);
    }

    public function canBeModified()
    {
        $scheduledDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', 
            $this->scheduled_date->format('Y-m-d') . ' ' . $this->scheduled_time
        );
        
        return in_array($this->status, ['scheduled']) && 
               $scheduledDateTime > now()->addHours(2);
    }

    public function getDurationAttribute()
    {
        if ($this->started_at && $this->completed_at) {
            return $this->started_at->diffInMinutes($this->completed_at);
        }
        return $this->duration_minutes;
    }

    public function isEmergency()
    {
        return $this->priority === 'emergency';
    }

    public function requiresFollowUp()
    {
        return !empty($this->follow_up_instructions);
    }

    public function getScheduledAtAttribute()
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', 
            $this->scheduled_date->format('Y-m-d') . ' ' . $this->scheduled_time
        );
    }
}
