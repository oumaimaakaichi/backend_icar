<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PieceRecommandee extends Model
{
    use HasFactory;

    protected $fillable = [
        'demande_id',

        'pieces',
          'main_oeuvre_seule',
        'prix_main_oeuvre_seule'

    ];

    protected $casts = [
        'pieces' => 'array', // JSON → tableau PHP automatiquement
         'main_oeuvre_seule' => 'boolean'
    ];

    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }
}
