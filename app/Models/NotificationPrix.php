<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class NotificationPrix extends Model
{
    use Notifiable, HasUuids;

    // Car l'ID est un UUID
    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'notification_prix';

    protected $fillable = [
        'id',
        'type',
        'notifiable_type',
        'notifiable_id',
        'data',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    /**
     * Relation morphique vers le modèle qui reçoit la notification.
     */
    public function notifiable()
    {
        return $this->morphTo();
    }
}
