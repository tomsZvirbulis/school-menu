<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recepie extends Model
{
    use HasFactory;

    protected $table = 'recepie';
    protected $primaryKey  = 'id';
    public $incrementing = true;

    protected $fillable = [
        'name',
        'prep_time',
        'cook_time',
        'calories',
        'servings',
        'instruction',
        'caterer_id',
    ];

    public function ingredient()
    {

        return $this->belongsToMany(Ingredient::class, 'recepie_has_ingredient', 'recepie', 'ingredient');
    }
}
