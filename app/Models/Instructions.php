<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructions extends Model
{
    use HasFactory;

    protected $table = 'instructions';
    protected $primaryKey  = 'id';

    protected $fillable = [
        'instruction',
    ];
}
