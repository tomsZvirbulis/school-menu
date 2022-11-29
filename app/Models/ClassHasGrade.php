<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassHasGrade extends Model
{
    use HasFactory;

    protected $table = 'class_has_grade';
    protected $primaryKey  = 'id';

    protected $fillable = [
        'class_id', 
        'grade_id',
    ];
}
