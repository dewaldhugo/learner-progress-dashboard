<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrolment extends Model
{
    public $incrementing = false;

    protected $table = 'enrolments';

    protected $fillable = [
        'learner_id',
        'course_id',
        'progress',
    ];

    protected $casts = [
        'progress' => 'decimal:2',
    ];

    // Relationships:
    public function learner()
    {
        return $this->belongsTo(Learner::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
