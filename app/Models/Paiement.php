<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = [
        'demande_id',
        'client_id',
        'montant',        // Correction: utiliser 'montant' au lieu de 'prix_total'
        'methode',
        'date_paiement',
    ];

    protected $casts = [
        'date_paiement' => 'datetime',
        'montant' => 'decimal:2',  // Assurer le cast en decimal
    ];

    public function demande()
    {
        return $this->belongsTo(DemandePanneInconnu::class, 'demande_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
