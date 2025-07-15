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
        $courses = Course::withCount('enrolments')->orderBy('name')->get();

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

        // Get learners and their average progress
        $learnerAverages = Learner::with('enrolments')->get()->map(function ($learner) {
            $avg = $learner->enrolments->avg('progress') ?? 0;
            return [
                'id' => $learner->id,
                'average' => round($avg, 2),
            ];
        });

        return DataTables::of($query)
        ->addColumn('full_name', fn($learner) => $learner->firstname . ' ' . $learner->lastname)

        ->addColumn('courses', function ($learner) {
            return $learner->enrolments->map(function ($enrolment) {
                return $enrolment->course->name . ' (' . number_format($enrolment->progress, 0) . '%)';
            })->implode('<br>');
        })

        ->addColumn('average_progress', function ($learner) {
            if ($learner->enrolments->isEmpty()) {
                return '<div class="text-muted">N/A</div>';
            }

            $avg = round($learner->enrolments->avg('progress'), 2);

            // Choose Bootstrap progress color class
            if ($avg < 40) {
                $color = 'bg-danger';
            } elseif ($avg < 60) {
                $color = 'bg-warning';
            } else {
                $color = 'bg-info';
            }

            return <<<HTML
            <div class="progress" style="height: 30px;">
                <div class="progress-bar {$color}" role="progressbar"
                style="width: {$avg}%;" aria-valuenow="{$avg}" aria-valuemin="0" aria-valuemax="100">
                <strong>{$avg}%</strong>
                </div>
            </div>
            HTML;
        })



        ->orderColumn('average_progress', function ($query, $order) {
            $query->withAvg('enrolments as average_progress', 'progress')
            ->orderBy('average_progress', $order);
        })

        ->filterColumn('full_name', function($query, $search) {
            $sql = "learners.firstname || learners.lastname  like ?";
            $query->whereRaw($sql, ["%{$search}%"]);
        })

        ->rawColumns(['courses', 'average_progress'])
        ->make(true);

    }
}
