<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'nomService',
        'payeFabrication',
        'prix',
        'rival'
    ];
    protected $attributes = [
        'isVisible' => true
    ];

    protected $casts = [
        'isVisible' => 'boolean'
    ];

   // Relationship with Forfait (many-to-many)
   public function forfaits()
   {
       return $this->belongsToMany(Forfait::class)
                   ->withPivot('prix')
                   ->withTimestamps();
   }
}
