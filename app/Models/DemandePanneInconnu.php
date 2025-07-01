<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
class DemandePanneInconnu extends Model
{
    use HasFactory;

    protected $table = 'demandes_panne_inconnue';

    protected $fillable = [
        'forfait_id',
'categories',
        'voiture_id',
        'client_id',
        'pieces_choisies',
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
        'techniciens',
        'description_probleme', // Nouvel attribut spécifique
         'panne',
 'main_oeuvre_pieces',

        // Attributs pour différents types d'emplacement
        'surface_maison',
        'hauteur_plafond_maison',
        'porte_garage_maison',
        'surface_bureau',
        'hauteur_plafond_bureau',
        'porte_garage_bureau',
        'surface_parking_travail',
        'autorisation_entree_travail',
        'porte_travail',
        'proximite_parking_public',
    ];

    protected $casts = [
        'categories' => 'array',
         'main_oeuvre_pieces' => 'array',
        'pieces_choisies' => 'array',
        'techniciens' => 'array',
        'date_maintenance' => 'date',
        'heure_maintenance' => 'string',
        'prix_total' => 'decimal:2',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'flux_en_direct' => 'boolean',
        'prix_main_oeuvre' => 'decimal:2',
        'porte_garage_maison' => 'array',
        'porte_garage_bureau' => 'array',
        'porte_travail' => 'array',
        'autorisation_entree_travail' => 'boolean',
        'surface_maison' => 'decimal:2',
        'hauteur_plafond_maison' => 'decimal:2',
        'surface_bureau' => 'decimal:2',
        'hauteur_plafond_bureau' => 'decimal:2',
        'surface_parking_travail' => 'decimal:2',
    ];

    // Relations
    public function voiture()
    {
        return $this->belongsTo(Voiture::class);
    }

    public function category()
    {
        return $this->belongsTo(CategoryPane::class);
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

    public function rapports()
    {
        return $this->hasMany(RapportMaintenance::class, 'id_demande');
    }

    public function getPiecesChoisiesAttribute($value)
    {
        if (is_array($value)) {
            return $value;
        }
        return json_decode($value, true) ?: [];
    }
public function catalogues()
{
    return Catalogue::whereIn('id', $this->pieces_choisies ?? []);
}
        public function flux()
    {
        return $this->hasOne(FluxDirectInconnuPanne::class, 'demande_id');
    }



    public function getMainOeuvrePiecesAttribute($value)
{
    if (is_array($value)) {
        return $value;
    }
    return json_decode($value, true) ?: [];
}
}

