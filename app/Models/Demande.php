<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Demande extends Model
{
    use HasFactory;

    protected $fillable = [
        'forfait_id',
        'service_panne_id',
        'voiture_id',
        'client_id',
        'pieces_choisies',       // JSON : tableau d’objets (idPiece, type)
        'type_emplacement',
        'atelier_id',
        'date_maintenance',
        'prix_total',
        'latitude',
        'longitude',
        'heure_maintenance',
        'prix_main_oeuvre',
    'status',
    'techniciens' 
    ];

    protected $casts = [
        'pieces_choisies'   => 'array',
        'techniciens' => 'array',
        'date_maintenance'  => 'date',
        'heure_maintenance'=> 'string',
        'prix_total'        => 'decimal:2',
        'latitude'          => 'decimal:7',
        'longitude'         => 'decimal:7',
         'prix_main_oeuvre' => 'decimal:2',
    ];

    // Relations
    public function voiture()
    {
        return $this->belongsTo(Voiture::class);
    }

    public function pieceRecommandee()
    {
        return $this->hasOne(PieceRecommandee::class);
    }

    public function servicePanne()
    {
        return $this->belongsTo(ServicePanne::class);
    }

    public function forfait()
    {
        return $this->belongsTo(Forfait::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function atelier()
    {
        return $this->belongsTo(Atelier::class);
    }
}
