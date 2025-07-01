<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPane extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'is_visible'
    ];
  protected $attributes = [
        'is_visible' => true
    ];
    protected $table = 'category_panes';
    public function services()
{
    return $this->hasMany(ServicePanne::class);
}

}
