<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $table = 'grade';
    protected $primaryKey  = 'id';

    protected $fillable = [
        'minYear', 
        'maxYear',
        'calories',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'class_has_grade');
    }
}
