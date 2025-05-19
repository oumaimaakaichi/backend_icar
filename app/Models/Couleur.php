<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Couleur extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_couleur',
        'is_visible'
    ];

    protected $attributes = [
        'is_visible' => true
    ];
}
