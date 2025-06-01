<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FluxDirect extends Model
{
    use HasFactory;

    protected $fillable = [
        'demande_id',
        'technicien_id',
        'lien_meet',
          'ouvert'
    ];

    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }

    public function technicien()
    {
        return $this->belongsTo(User::class, 'technicien_id');
    }
    public function demandeFlux()
    {
        return $this->hasOne(DemandeFlux::class, 'id_flux');
    }
    public function hasPermission()
{
    return $this->demandeFlux && $this->demandeFlux->permission;
}
}
