<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class DemandeMaintenance extends Model
{
    use HasFactory;

    protected $table = 'demandes_maintenances';

    protected $fillable = [
        'type_service',
        'type_assistance',
        'type_maintenance',
        'type_voiture',
        'piece_rechange',
        'emplacement',
        'donnees_carte',
        'atelier_id'
    ];

    public function atelier()
    {
        return $this->belongsTo(Atelier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
