<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restrictions extends Model
{
    use HasFactory;

    protected $table = 'restrictions';

    protected $fillable = [
        'class_id', 
        'ingredients_id',
        'count',
        'category_id',
    ];
}
