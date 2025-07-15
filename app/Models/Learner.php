<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Learner extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
    ];

    // Relationships:
    public function enrolments()
    {
        return $this->hasMany(Enrolment::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enrolments')
                    ->withPivot('progress');
    }
}
