<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = [
        'demande_id',
        'demande_connu_id',  // ✅ Nouvel attribut
        'client_id',
        'montant',
        'methode',
        'date_paiement',
    ];

    protected $casts = [
        'date_paiement' => 'datetime',
        'montant' => 'decimal:2',
    ];

    // Relation avec Demande Panne Inconnue
    public function demande()
    {
        return $this->belongsTo(DemandePanneInconnu::class, 'demande_id');
    }

    // Relation avec Demande Panne Connue
    public function demandeConnu()
    {
        return $this->belongsTo(Demande::class, 'demande_connu_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
