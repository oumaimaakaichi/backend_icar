<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssistanceAtelier extends Model
{
    use HasFactory;

    protected $fillable = [
        'atelier_id',
        'type',
        'message',
        'reponse',
        'statut',
    ];

    public function atelier()
    {
        return $this->belongsTo(Atelier::class);
    }
}
