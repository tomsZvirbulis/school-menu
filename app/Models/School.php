<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $table = 'school';
    protected $primaryKey  = 'id';
    public $incrementing = true;

    protected $fillable = [
        'name',
        'address_id',
    ];
}
