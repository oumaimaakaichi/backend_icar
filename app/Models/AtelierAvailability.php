<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class AtelierAvailability extends Model
{
    use HasFactory;

    protected $fillable = [
        'atelier_id',
        'day',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    /**
     * Relation avec l'atelier
     */
    public function atelier()
    {
        return $this->belongsTo(Atelier::class);
    }

    /**
     * Scope pour filtrer par jour
     */
    public function scopeForDay($query, $day)
    {
        return $query->where('day', $day);
    }

    /**
     * Vérifier si l'atelier est disponible à une heure donnée
     */
    public function isAvailableAt($time)
    {
        return $time >= $this->start_time && $time <= $this->end_time;
    }

    /**
     * Formater les heures pour l'affichage
     */
    public function getFormattedTimeAttribute()
    {
        return $this->start_time . ' - ' . $this->end_time;
    }

    /**
     * Obtenir le nom du jour en français
     */
    public function getDayNameAttribute()
    {
        $days = [
            'lundi' => 'Lundi',
            'mardi' => 'Mardi',
            'mercredi' => 'Mercredi',
            'jeudi' => 'Jeudi',
            'vendredi' => 'Vendredi',
            'samedi' => 'Samedi',
            'dimanche' => 'Dimanche',
        ];

        return $days[$this->day] ?? $this->day;
    }
}
