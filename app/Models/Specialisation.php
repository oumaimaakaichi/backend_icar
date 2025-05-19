<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialisation extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_specialite',
        'is_visible'
    ];

    protected $attributes = [
        'is_visible' => true
    ];

    protected $casts = [
        'is_visible' => 'boolean'
    ];
}
