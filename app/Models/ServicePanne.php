<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePanne extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'category_pane_id',
    ];

    public function categoryPane()
    {
        return $this->belongsTo(CategoryPane::class);
    }


    public function forfaits()
   {
       return $this->belongsToMany(Forfait::class)
                   ->withPivot('prix')
                   ->withTimestamps();
   }
}
