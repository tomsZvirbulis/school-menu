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

    public function class()
    {
        return $this->belongsToMany(Classes::class, 'class_has_grade', 'grade_id', 'class_id');
    }
}
