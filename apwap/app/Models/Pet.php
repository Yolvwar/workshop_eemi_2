<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class Pet extends Model
{
    use HasFactory;
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
        'behavioral_notes',
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
        'birth_date' => 'date',
        'adoption_date' => 'date',
        'registration_date' => 'date',
        'weight' => 'decimal:2',
        'height' => 'decimal:2',
        'is_neutered' => 'boolean',
        'is_active' => 'boolean',
        'energy_level' => 'integer',
        'obedience_level' => 'integer',
        'health_score' => 'integer',
        'education_score' => 'integer',
        'nutrition_score' => 'integer',
        'activity_score' => 'integer',
        'lifestyle_score' => 'integer',
        'emotional_score' => 'integer',
        'overall_score' => 'integer',
        'favorite_toys' => 'array',
        'feeding_schedule' => 'array',
        'exercise_routine' => 'array',
        'sleeping_habits' => 'array',
        'behavioral_notes' => 'array',
        'fears_phobias' => 'array',
    ];

    /**
     * Boot the model and generate UUID.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Relation avec l'utilisateur propriétaire
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec les articles du panier pour cet animal
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Relation avec les articles de commande pour cet animal
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relation avec les avis de produits
     */
    public function productReviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    /**
     * Calculer l'âge en années
     */
    public function getAgeAttribute()
    {
        if (!$this->birth_date) {
            return null;
        }

        return $this->birth_date->diffInYears(now());
    }

    /**
     * Calculer l'âge formaté
     */
    public function getAgeFormattedAttribute()
    {
        if (!$this->birth_date) {
            return 'Âge inconnu';
        }

        $years = $this->birth_date->diffInYears(now());
        $months = $this->birth_date->diffInMonths(now()) % 12;

        if ($years > 0) {
            return $years . ' an' . ($years > 1 ? 's' : '') .
                ($months > 0 ? ' et ' . $months . ' mois' : '');
        }

        return $months . ' mois';
    }

    /**
     * Obtenir les recommandations de produits
     */
    public function getRecommendedProducts($limit = 6)
    {
        return Product::active()
            ->suitableForSpecies($this->species)
            ->inStock()
            ->orderBy('rating', 'desc')
            ->orderBy('review_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Calculer le score global des 6 piliers
     */
    public function calculateOverallScore()
    {
        $scores = [
            $this->health_score,
            $this->education_score,
            $this->nutrition_score,
            $this->activity_score,
            $this->lifestyle_score,
            $this->emotional_score,
        ];

        $validScores = array_filter($scores, function ($score) {
            return $score > 0;
        });

        if (empty($validScores)) {
            return 0;
        }

        $this->overall_score = round(array_sum($validScores) / count($validScores));
        $this->save();

        return $this->overall_score;
    }

    /**
     * Obtenir la couleur du score
     */
    public function getScoreColorClass($score)
    {
        if ($score >= 85)
            return 'text-green-600';
        if ($score >= 70)
            return 'text-yellow-600';
        if ($score >= 50)
            return 'text-orange-600';
        return 'text-red-600';
    }

    /**
     * Scope pour les animaux actifs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope pour filtrer par espèce
     */
    public function scopeBySpecies($query, $species)
    {
        return $query->where('species', $species);
    }

    /**
     * Obtenir le nom avec l'espèce
     */
    public function getFullNameAttribute()
    {
        return $this->name . ' (' . $this->species . ')';
    }

    /**
     * Vérifier si c'est un animal senior
     */
    public function isSenior()
    {
        $age = $this->age;
        if (!$age)
            return false;

        // Chien/Chat : senior à partir de 7 ans
        return $age >= 7;
    }

    /**
     * Vérifier si c'est un chiot/chaton
     */
    public function isPuppy()
    {
        $age = $this->age;
        if (!$age)
            return false;

        // Moins d'un an
        return $age < 1;
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

    public function updateOverallScore(): void
    {
        $this->overall_score = round((
            $this->health_score +
            $this->education_score +
            $this->nutrition_score +
            $this->activity_score +
            $this->lifestyle_score +
            $this->emotional_score
        ) / 6);

        $this->saveQuietly();
    }



}
