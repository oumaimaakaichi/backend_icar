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
    ];

    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }

    public function technicien()
    {
        return $this->belongsTo(User::class, 'technicien_id');
    }
}
