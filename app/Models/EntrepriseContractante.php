<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class EntrepriseContractante extends Authenticatable
{

    protected $table = 'entreprises_contractante';

    protected $fillable = [
        'nom_entreprise',
        'email',
        'password',
        'num_unique',
        'nom_mandataire',
        'num_contact',
        'nbr_ateliers_requis',
        'ville',
        'nbr_employee',
        'type_parking',
        'adresse_entreprise',
        'hauteur_plafond_parking',
        'hauteur_autorise',
        'est_actif',
        'statut_demande',
        'remember_token',
        'email_verified_at',
    ];

    // Masquer le mot de passe dans les tableaux et JSON
    protected $hidden = ['password'];


    protected $casts = [
        'email_verified_at' => 'datetime',
        'est_actif' => 'boolean',
    ];

    const STATUT_EN_ATTENTE = 'en_attente';
    const STATUT_ACCEPTEE = 'acceptee';
    const STATUT_REFUSEE = 'refusee';

    // Constantes pour l'état de l'entreprise
    const EST_ACTIF = true;
    const EST_INACTIF = false;


    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
    public function employes(): HasMany
    {
        return $this->hasMany(User::class, 'entreprise_contractante_id')
                    ->where('role', 'employe');
    }


}
