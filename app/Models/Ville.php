<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomville',
        'longitude',
        'latitude',
         'is_visible'
    ];

    protected $attributes = [
        'is_visible' => true // Valeur par défaut
    ];
}

