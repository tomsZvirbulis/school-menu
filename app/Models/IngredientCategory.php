<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientCategory extends Model
{
    use HasFactory;

    protected $table = 'ingredient_category';
    protected $primaryKey  = 'id';

    protected $fillable = [
        'name',
    ];

}
