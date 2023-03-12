<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuHasDay extends Model
{
    use HasFactory;

    protected $table = 'menu_has_day';

    public $timestamps = false;

    protected $fillable = [
        'menu', 
        'day',
        'recepie',
    ];
}
