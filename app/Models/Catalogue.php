<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Catalogue extends Model
{
    use HasFactory;
    protected $fillable = [
        'entreprise',
        'type_voiture',
        'nom_piece',
        'num_piece',
        'paye_fabrication',
        'photo_piece',
        'prix', // ✅ nouveau champ
        'stock'
    ];

}
