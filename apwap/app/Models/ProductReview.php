<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductReview extends Model
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
        'product_id',
        'user_id',
        'pet_id',
        'rating',
        'title',
        'review',
        'is_verified_purchase',
        'is_approved',
        'helpful_count',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_verified_purchase' => 'boolean',
        'is_approved' => 'boolean',
        'helpful_count' => 'integer',
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

        static::created(function ($model) {
            $model->product->updateRating();
        });

        static::updated(function ($model) {
            $model->product->updateRating();
        });

        static::deleted(function ($model) {
            $model->product->updateRating();
        });
    }

    /**
     * Relation avec le produit
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec l'animal (optionnel)
     */
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    /**
     * Scope pour les avis approuvés
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope pour les achats vérifiés
     */
    public function scopeVerifiedPurchases($query)
    {
        return $query->where('is_verified_purchase', true);
    }

    /**
     * Approuver l'avis
     */
    public function approve()
    {
        $this->is_approved = true;
        $this->save();
    }

    /**
     * Obtenir les étoiles en HTML
     */
    public function getStarsHtmlAttribute()
    {
        $html = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->rating) {
                $html .= '<i class="fas fa-star text-yellow-400"></i>';
            } else {
                $html .= '<i class="far fa-star text-gray-300"></i>';
            }
        }
        return $html;
    }

    /**
     * Obtenir le nom de l'utilisateur (avec privacy)
     */
    public function getDisplayNameAttribute()
    {
        if (!$this->user) {
            return 'Utilisateur supprimé';
        }

        $firstName = $this->user->first_name;
        $lastName = $this->user->last_name;
        
        return $firstName . ' ' . substr($lastName, 0, 1) . '.';
    }
}
