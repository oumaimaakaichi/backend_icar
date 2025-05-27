<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeFlux extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_flux',
        'permission',
        'partage_with_client',
    ];

    public function flux()
    {
        return $this->belongsTo(FluxDirect::class, 'id_flux');
    }
}
