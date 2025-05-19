<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    protected $fillable = ['email', 'code'];
    public $timestamps = true; // Ensure timestamps are enabled
}

