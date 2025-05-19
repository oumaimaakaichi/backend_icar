<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForfaitService extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'prix',
        'rival',
        'service_panne_id',
    ];

    public function servicePanne()
    {
        return $this->belongsTo(ServicePanne::class);
    }
}
