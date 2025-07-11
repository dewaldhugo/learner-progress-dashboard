<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Learner;
use Yajra\DataTables\Facades\DataTables;

class LearnerProgressController extends Controller
{
    public function index()
{
    $courses = Course::orderBy('name')->get();

    return view('learner-progress.index', compact('courses'));
}

    public function data(Request $request)
{
    // Base query
    $query = Learner::with(['enrolments.course']);

    // If course filter applied, constrain results
    if ($request->filled('course_id')) {
        $courseId = $request->input('course_id');

        // Filter learners who are enrolled in the selected course
        $query->whereHas('enrolments', function ($q) use ($courseId) {
            $q->where('course_id', $courseId);
        });
    }

    return DataTables::of($query)
        ->addColumn('full_name', fn($learner) => $learner->firstname . ' ' . $learner->lastname)
        ->addColumn('courses', function ($learner) {
            return $learner->enrolments->map(function ($enrolment) {
                return $enrolment->course->name . ' (' . number_format($enrolment->progress, 0) . '%)';
            })->implode('<br>');
        })
        ->rawColumns(['courses'])
        ->make(true);
}
}
