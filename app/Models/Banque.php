<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banque extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_banque',
        'is_visible'
    ];

    protected $attributes = [
        'is_visible' => true
    ];

    protected $casts = [
        'is_visible' => 'boolean'
    ];
}
