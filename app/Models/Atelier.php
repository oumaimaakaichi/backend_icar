<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Atelier extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nom_commercial',
        'num_registre_commerce',
        'num_fiscal',
        'ville',
        'site_web',
        'nom_banque',
        'num_IBAN',
        'nom_directeur',
        'num_contact',
        'specialisation_centre',
        'type_entreprise',
        'document',
        'photos_centre',
        'nbr_techniciens',
        'techniciens',
        'email',
        'password',
        'is_active',
    ];

    // Hachage du mot de passe avant de le sauvegarder dans la base de données
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $guard = 'atelier';

    protected $hidden = ['password', 'remember_token'];
}
