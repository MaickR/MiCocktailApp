<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cocktail extends Model
{
    use HasFactory;

    //! Los campos asignables
    protected $fillable = [
        'cocktail_id_api',
        'name',
        'category',
        'alcoholic',
        'instructions',
        'thumbnail',
        'user_id'
    ];
    
    
    //! Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
