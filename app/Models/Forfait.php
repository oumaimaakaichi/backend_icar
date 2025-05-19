<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forfait extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomForfait',
        'prixForfait',
        'rival',
    ];

    // Accesseur pour nomForfait
    public function getNomAttribute()
    {
        return $this->nomForfait;
    }

    // Accesseur pour prixForfait
    public function getPrixAttribute()
    {
        return $this->prixForfait;
    }

    /**
     * The ServicePanne associated with the forfait.
     */
    public function servicePannes()
    {
        return $this->belongsToMany(ServicePanne::class)
                    ->withPivot('prix')
                    ->withTimestamps();
    }
}
