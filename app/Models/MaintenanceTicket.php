<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceTicket extends Model
{
    protected $fillable = [
        'atelier_id',
        'titre',
        'description',
        'type',
        'statut',
        'client_id',

        'isVisible' // Ajout du nouvel attribut
    ];

    protected $attributes = [
        'isVisible' => true // Valeur par défaut
    ];

    public function atelier()
    {
        return $this->belongsTo(Atelier::class);
    }
}
