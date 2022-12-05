<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecepieHasIngredient extends Model
{
    use HasFactory;

    protected $table = 'recepie_has_ingredient';

    protected $fillable = [
        'recepie', 
        'ingredients',
        'count',
    ];
}
