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
        'caterer_id',
    ];
}
