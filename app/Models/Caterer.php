<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caterer extends Model
{
    use HasFactory;

    protected $table = 'caterer';
    protected $primaryKey  = 'id';

    protected $fillable = [
        'name',
        'address_id',
        'caterer',
    ];
}
