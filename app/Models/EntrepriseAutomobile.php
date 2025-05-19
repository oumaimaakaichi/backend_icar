<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntrepriseAutomobile extends Model
{
    use HasFactory;

    protected $fillable = ['entreprise', 'pays', 'logo', 'voitures'];

    protected $casts = [
        'voitures' => 'array'
    ];

    public function getLogoPathAttribute()
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }

    public function addVoiture($nomVoiture)
    {
        $voitures = $this->voitures ?? [];
        $voitures[] = $nomVoiture;
        $this->voitures = $voitures;
        $this->save();
    }
}
