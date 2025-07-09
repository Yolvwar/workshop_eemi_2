<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasUuids;

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
        'membership_expires_at',
        'total_spent',
        'loyalty_points',
        'theme',
        'notification_push',
        'notification_email',
        'notification_sms',
        'last_login_at',
        'is_active',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'date_of_birth' => 'date',
        'membership_expires_at' => 'datetime',
        'last_login_at' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'total_spent' => 'decimal:2',
        'loyalty_points' => 'integer',
        'notification_push' => 'boolean',
        'notification_email' => 'boolean',
        'notification_sms' => 'boolean',
        'is_active' => 'boolean',
    ];

    // Si besoin, tu peux ajouter ici des relations avec d'autres modèles, par exemple pets, consultations, etc.
}
