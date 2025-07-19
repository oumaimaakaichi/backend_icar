<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'nbr_etoile',
        'commentaire',
        'client_id',
        'technicien_id',
        'demande_id',
    ];

    // Relations
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
public function demande()
{
    return $this->belongsTo(Demande::class, 'demande_id');
}
    public function technicien()
    {
        return $this->belongsTo(User::class, 'technicien_id');
    }
}
