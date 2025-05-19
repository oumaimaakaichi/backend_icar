<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapport extends Model
{
    use HasFactory;

    protected $table = 'maintenances';

    protected $fillable = [
        'number',
        'date_maintenance',
        'photos_jointes',
    ];
}
