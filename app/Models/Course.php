<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // Relationships:
    public function enrolments()
    {
        return $this->hasMany(Enrolment::class);
    }

    public function learners()
    {
        return $this->belongsToMany(Learner::class, 'enrolments')
                    ->withPivot('progress');
    }
}