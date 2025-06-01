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
        'flux_en_direct',

        'prix_main_oeuvre',
    'status',
    'techniciens' ,

    //nouveau attributs
    // Maison
    'surface_maison',
    'hauteur_plafond_maison',
    'porte_garage_maison',

    // Bureau privé
    'surface_bureau',
    'hauteur_plafond_bureau',
    'porte_garage_bureau',

    // Travail
    'surface_parking_travail',
    'autorisation_entree_travail',
    'porte_travail',
'lien_flux',

    // Parkings publics
    'proximite_parking_public',
    ];

    protected $casts = [
        'pieces_choisies'   => 'array',
        'techniciens' => 'array',
        'date_maintenance'  => 'date',
        'heure_maintenance'=> 'string',
        'prix_total'        => 'decimal:2',
        'latitude'          => 'decimal:7',
        'flux_en_direct' => 'boolean',

        'longitude'         => 'decimal:7',
         'prix_main_oeuvre' => 'decimal:2',
          'porte_garage_maison' => 'array',
    'porte_garage_bureau' => 'array',
    'porte_travail'       => 'array',
    'autorisation_entree_travail' => 'boolean',
    'surface_maison'      => 'decimal:2',
    'hauteur_plafond_maison' => 'decimal:2',
    'surface_bureau'      => 'decimal:2',
    'hauteur_plafond_bureau' => 'decimal:2',
    'surface_parking_travail' => 'decimal:2',
    'lien_flux' => 'string',


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
    // Dans app/Models/Demande.php
public function getPiecesChoisiesAttribute($value)
{
    if (is_array($value)) {
        return $value;
    }
    return json_decode($value, true) ?: [];
}
// Dans app/Models/Demande.php
public function rapports()
{
    return $this->hasMany(RapportMaintenance::class, 'id_demande');
}
    public function servicePanne()
    {
        return $this->belongsTo(ServicePanne::class);
    }
// Dans app/Models/Demande.php
public function piecesCatalogue()
{
    // Supposons que pieces_choisies contient des IDs de catalogue
    return $this->belongsToMany(Catalogue::class, null, 'demande_id', 'piece_id')
                ->withPivot(['type', 'prix'])
                ->using(DemandePiecePivot::class); // Créez cette classe si nécessaire
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
