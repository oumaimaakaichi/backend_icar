<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeFluxInconnuPanne extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_flux',
        'permission',
        'partage_with_client',
    ];

    public function flux()
    {
        return $this->belongsTo(FluxDirectInconnuPanne::class, 'id_flux');
    }
}
