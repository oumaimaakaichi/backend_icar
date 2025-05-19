<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassificationPiece extends Model
{
    use HasFactory;

    protected $fillable = [
        'classificationPrincipale',
        'classificationSecondaire',
        'isVisible'
    ];

    protected $casts = [
        'isVisible' => 'boolean'
    ];
}
