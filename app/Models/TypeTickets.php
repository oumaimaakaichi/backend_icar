<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeTickets extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_ticket',
        'is_visible'
    ];

    protected $attributes = [
        'is_visible' => true
    ];

    protected $casts = [
        'is_visible' => 'boolean'
    ];
}
