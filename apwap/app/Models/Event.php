<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'start',
        'end',
        'color',
        'all_day',
        'pets_id'
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
        'all_day' => 'boolean'
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class, 'pets_id');
    }
}