<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class NotificationTechnicien extends Model
{
    use HasFactory;

    protected $table = 'notification_techniciens';

    protected $fillable = [
        'technicien_id',
        'demande_id',
        'titre',
        'message',
        'type',
        'lu',
        'lu_at'
    ];

    protected $casts = [
        'lu' => 'boolean',
        'lu_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = [
        'temps_ecoule',
        'est_recente'
    ];

    // Relations
    public function technicien()
    {
        return $this->belongsTo(User::class, 'technicien_id');
    }

    public function demande()
    {
        return $this->belongsTo(Demande::class, 'demande_id');
    }

    // Scopes
   public function scopeNonLues(Builder $query)
{
    return $query->where(function($q) {
        $q->where('lu', 0)->orWhereNull('lu');
    });
}

    public function scopeLues(Builder $query)
    {
        return $query->where('lu', true);
    }

    public function scopePourTechnicien(Builder $query, $technicienId)
    {
        return $query->where('technicien_id', $technicienId);
    }

    public function scopeParType(Builder $query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeRecentes(Builder $query, $heures = 24)
    {
        return $query->where('created_at', '>=', now()->subHours($heures));
    }

    public function scopeOrdrePriorite(Builder $query)
    {
        return $query->orderByRaw("
            CASE type
                WHEN 'assignation' THEN 1
                WHEN 'modification' THEN 2
                WHEN 'annulation' THEN 3
                ELSE 4
            END
        ")->orderBy('created_at', 'desc');
    }

    // Accesseurs
    public function getTempsEcouleAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getEstRecenteAttribute()
    {
        return $this->created_at->greaterThan(now()->subHours(2));
    }

    // Méthodes
    public function marquerCommeLue()
    {
        if (!$this->lu) {
            $this->update([
                'lu' => true,
                'lu_at' => now()
            ]);
        }
        return $this;
    }

    public function marquerCommeNonLue()
    {
        $this->update([
            'lu' => false,
            'lu_at' => null
        ]);
        return $this;
    }

    public function getIconeType()
    {
        return match($this->type) {
            'assignation' => 'user-plus',
            'modification' => 'edit',
            'annulation' => 'user-minus',
            default => 'bell'
        };
    }

    public function getCouleurType()
    {
        return match($this->type) {
            'assignation' => 'success',
            'modification' => 'warning',
            'annulation' => 'danger',
            default => 'info'
        };
    }

    // Méthodes statiques
    public static function creerNotification($technicienId, $demandeId, $titre, $message, $type = 'assignation')
    {
        return self::create([
            'technicien_id' => $technicienId,
            'demande_id' => $demandeId,
            'titre' => $titre,
            'message' => $message,
            'type' => $type
        ]);
    }

    public static function compterNonLues($technicienId)
    {
        return self::pourTechnicien($technicienId)->nonLues()->count();
    }

    public static function supprimerAnciennes($jours = 30)
    {
        return self::where('created_at', '<', now()->subDays($jours))->delete();
    }



}
