<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasRoles , HasApiTokens;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'phone',
        'adresse',
        'password',
        'role',
        'extra_data',
        'isActive',
        'suspended',
        'suspension_reason',
        'atelier_id',
        'entreprise_contractante_id' ,// Ajout du nouveau champ
        'status',
        'rejection_reason',
    ];

    protected $hidden = ['password'];
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    protected $casts = [
        'password' => 'hashed',
        'extra_data' => 'array',
        'isActive' => 'boolean',
        'status' => 'string',
    ];

    public function isSuspended()
    {
        return $this->suspended;
    }
public function isAdmin()
{
    return $this->role === 'admin';
}

public function isExpert()
{
    return $this->role === 'expert';
}
public function isResponsablePiece()
{
    return $this->role === 'Responsable_piece';
}

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function loyaltyPoints(): HasMany
    {
        return $this->hasMany(LoyaltyPoint::class);
    }

    public function atelier()
    {
        return $this->belongsTo(Atelier::class);
    }

    // Ajout de la relation avec l'entreprise contractante
    public function entrepriseContractante(): BelongsTo
    {
        return $this->belongsTo(EntrepriseContractante::class, 'entreprise_contractante_id');
    }

    public function loyaltyPointsBalance(): float
    {
        return $this->loyaltyPoints->sum(function ($point) {
            return $point->type === 'credit' ? $point->points : -$point->points;
        });
    }
}
