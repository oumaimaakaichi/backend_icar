<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{
    use HasFactory;

    protected $fillable = [
        'catalogue_id',
        'client_id',
        'quantite',
    ];

    public function catalogue()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
