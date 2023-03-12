<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Days extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'day';
    protected $primaryKey  = 'id';

    protected $fillable = [
        'name', 
        'day_index',
        'menu_id',
        'recepie',
    ];

    public function menu()
    {
        return $this->belongsToMany(Menu::class, 'menu_has_day', 'menu', 'day', 'recepie');
    }
}
