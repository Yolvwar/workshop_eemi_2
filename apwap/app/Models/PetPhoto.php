<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PetPhoto extends Model
{
    use HasUuids;

    protected $table = 'pet_photos';

    protected $keyType = 'string'; // UUID as string
    public $incrementing = false;

    protected $fillable = [
        'pet_id',
        'filename',
        'original_name',
        'url',
        'thumbnail_url',
        'file_size',
        'mime_type',
        'width',
        'height',
        'category',
        'tags',
        'description',
        'ai_analysis',
        'taken_at',
        'uploaded_at',
        'is_public',
        'is_profile_picture',
    ];

    protected $casts = [
        'ai_analysis' => 'array',
        'taken_at' => 'datetime',
        'uploaded_at' => 'datetime',
        'is_public' => 'boolean',
        'is_profile_picture' => 'boolean',
    ];

    // Relations
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

}
