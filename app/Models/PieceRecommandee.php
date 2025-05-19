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
    ];

    protected $casts = [
        'pieces' => 'array', // JSON → tableau PHP automatiquement
    ];

    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }
}
