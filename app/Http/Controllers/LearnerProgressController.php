<?php

namespace App\Http\Controllers;

use App\Models\Learner;
use Yajra\DataTables\Facades\DataTables;

class LearnerProgressController extends Controller
{
    public function index()
    {
        return view('learner-progress.index');
    }

    public function data()
    {
        // Query learners with enrolments and courses eager loaded
        $learners = Learner::with(['enrolments.course'])->get();

        // Format data for DataTables
        return DataTables::of($learners)
            ->addColumn('full_name', function ($learner) {
                return $learner->firstname . ' ' . $learner->lastname;
            })
            ->addColumn('courses', function ($learner) {
                // Format courses and progress per learner
                return $learner->enrolments->map(function ($enrolment) {
                    return $enrolment->course->name . ' (' . number_format($enrolment->progress, 2) . '%)';
                })->implode('<br>');
            })
            ->rawColumns(['courses']) // Allow HTML in courses column
            ->make(true);
    }
}
