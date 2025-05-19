<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    protected $fillable = [
        'type_service', 'prix', 'remise', 'taxe',
        'montant_total', 'atelier_id', 'user_id', 'status'
    ];

    public function atelier()
    {
        return $this->belongsTo(Atelier::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
