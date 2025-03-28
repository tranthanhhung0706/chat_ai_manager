<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'skills', 'experience', 'education', 'gpa', 'age', 'cv_file'
    ];
}
