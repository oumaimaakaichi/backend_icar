<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RapportMaintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_technicien',
        'id_demande',
        'description',
    ];

    // Relations
    public function technicien()
    {
        return $this->belongsTo(User::class, 'id_technicien');
    }

    public function demande()
    {
        return $this->belongsTo(Demande::class, 'id_demande');
    }
}
