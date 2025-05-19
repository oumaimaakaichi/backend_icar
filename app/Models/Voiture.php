<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voiture extends Model
{
    use HasFactory;

    protected $table = 'voitures';

    protected $fillable = [
        'serie',
        'date_fabrication',
        'model',
        'couleur',
        'company', // anciennement 'entreprise'
        'numero_chassis',
        'client_id', // nouvel attribut
    ];

    /**
     * Relation avec le client (utilisateur ayant créé la voiture).
     */

}

