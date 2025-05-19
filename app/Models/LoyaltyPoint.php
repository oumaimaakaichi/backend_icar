<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'technician_id',
        'spare_part_id',
        'points',
        'type',
        'actual_value',
        'adjustment_factor',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function sparePart()
    {
        return $this->belongsTo(Catalogue::class);
    }
}
