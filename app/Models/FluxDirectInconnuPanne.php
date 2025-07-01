<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FluxDirectInconnuPanne extends Model
{
    use HasFactory;

    protected $table = 'flux_direct_inconnu_pannes'; // nom de la table en base de données

    protected $fillable = [
        'demande_id',
        'technicien_id',
        'lien_meet',
        'ouvert',
        'type_meet'
    ];
protected $casts = [
        'type_meet' => 'string',
    ];

    public function demande()
    {
        return $this->belongsTo(DemandePanneInconnu::class, 'demande_id');
    }

    public function technicien()
    {
        return $this->belongsTo(User::class, 'technicien_id');
    }

// Dans FluxDirectInconnuPanne.php - À corriger
public function demandeFlux()
{
    return $this->hasOne(DemandeFluxInconnuPanne::class, 'id_flux', 'id'); // Ajoutez la clé locale
}


}
