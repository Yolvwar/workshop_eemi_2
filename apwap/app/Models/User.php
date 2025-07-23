<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Indicates if the model's ID is auto-incrementing.
     */
    public $incrementing = false;

    /**
     * The data type of the auto-incrementing ID.
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'password',
        'phone',
        'first_name',
        'last_name',
        'date_of_birth',
        'avatar_url',
        'country',
        'city',
        'address_line_1',
        'address_line_2',
        'postal_code',
        'latitude',
        'longitude',
        'language',
        'currency',
        'timezone',
        'membership_type',
        'total_spent',
        'loyalty_points',
        'theme',
        'notification_push',
        'notification_email',
        'notification_sms',
        'emergency_contact_name',
        'emergency_contact_phone',
        'location',
        'bio',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

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
     * Accessor pour name (requis par Breeze)
     */
    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Mutateur pour name
     */
    public function setNameAttribute($value)
    {
        $parts = explode(' ', $value, 2);
        $this->first_name = $parts[0];
        $this->last_name = $parts[1] ?? '';
    }

    /**
     * Relation avec les animaux
     */
    public function pets()
    {
        return $this->hasMany(Pet::class)->active();
    }

    /**
     * Relation avec les paniers
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Relation avec le panier actif
     */
    public function activeCart()
    {
        return $this->hasOne(Cart::class)->where('status', 'active');
    }

    /**
     * Relation avec les commandes
     */
    public function orders()
    {
        return $this->hasMany(Order::class)->orderBy('created_at', 'desc');
    }

    /**
     * Relation avec les avis de produits
     */
    public function productReviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    /**
     * Obtenir le panier actif ou en créer un
     */
    public function getOrCreateActiveCart()
    {
        return Cart::getActiveForUser($this->id);
    }

    /**
     * Calculer le total dépensé
     */
    public function calculateTotalSpent()
    {
        $total = $this->orders()
            ->whereIn('status', ['confirmed', 'shipped', 'delivered'])
            ->sum('total_amount');
            
        $this->total_spent = $total;
        $this->save();
        
        return $total;
    }

    /**
     * Obtenir le niveau de membership
     */
    public function getMembershipLevelAttribute()
    {
        if ($this->total_spent >= 10000) return 'Platinum';
        if ($this->total_spent >= 5000) return 'Gold';
        if ($this->total_spent >= 2000) return 'Silver';
        return 'Bronze';
    }

    /**
     * Vérifier si livraison gratuite
     */
    public function hasFreeLivery()
    {
        return in_array($this->membership_type, ['Gold', 'Platinum']);
    }
}
