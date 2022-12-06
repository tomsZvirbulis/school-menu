<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredients extends Model
{
    use HasFactory;

    protected $table = 'ingredients';
    protected $primaryKey  = 'id';

    protected $fillable = [
        'ingredient_category',
        'name',
    ];

    public function recepie()
    {

        return $this->belongsToMany(Recepie::class, 'recepie_has_ingredient', 'ingredients', 'recepie');
    }
}
