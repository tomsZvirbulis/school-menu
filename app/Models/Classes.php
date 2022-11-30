<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    protected $table = 'class';
    protected $primaryKey  = 'id';

    protected $fillable = [
        'student_count', 
        'school_id',
        'name',
    ];

    public function grade()
    {
        return $this->belongsToMany(Grade::class, 'class_has_grade', 'class_id', 'grade_id');
    }
}
