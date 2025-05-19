<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'status',
        'type',
        'date_envoie',
        'destination',
    ];

    protected $casts = [
        'date_envoie' => 'datetime',
    ];
}

