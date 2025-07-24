<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    protected $table = 'users';

    public $incrementing = false;
    protected $keyType = 'string';

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

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

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
     * Relation : animaux actifs
     */
    public function pets()
    {
        return $this->hasMany(Pet::class)->active();
    }

    /**
     * Relation : tous les paniers
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Relation : panier actif
     */
    public function activeCart()
    {
        return $this->hasOne(Cart::class)->where('status', 'active');
    }

    /**
     * Relation : commandes de l'utilisateur
     */
    public function orders()
    {
        return $this->hasMany(Order::class)->orderBy('created_at', 'desc');
    }

    /**
     * Relation : avis produits
     */
    public function productReviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    /**
     * Obtenir ou créer un panier actif
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
     * Accesseur : niveau de fidélité
     */
    public function getMembershipLevelAttribute()
    {
        if ($this->total_spent >= 10000) return 'Platinum';
        if ($this->total_spent >= 5000) return 'Gold';
        if ($this->total_spent >= 2000) return 'Silver';
        return 'Bronze';
    }

    /**
     * Vérifie si l'utilisateur bénéficie de la livraison gratuite
     */
    public function hasFreeDelivery()
    {
        return in_array($this->membership_type, ['Gold', 'Platinum']);
    }
}
