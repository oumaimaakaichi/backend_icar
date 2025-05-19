<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camion extends Model
{
    use HasFactory;

    // Champs remplissables (mass assignable)
    protected $fillable = [
        'nom_camion',
        'type_camion',
        'emplacement',
        'latitude',
        'longitude',
        'lien_map',
        'nom_entreprise',
        'date_accord',
        'direction',
    ];
    public function techniciens()
    {
        return $this->belongsToMany(User::class, 'camion_technicien', 'camion_id', 'technicien_id');
    }
    // Cast des champs JSON

}
