<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointDeFidelite extends Model
{
    use HasFactory;

    protected $fillable = [
        'points_acquis',
        'points_utilises',
        'date_operation',
        'description_operation',
        'cout',
    ];

    protected $casts = [
        'date_operation' => 'datetime',
    ];
}

