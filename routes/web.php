<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LearnerProgressController;

Route::get('/', function () {
    return view('welcome');
});

// Learner Progress Dashboard page
Route::get('/learner-progress', [LearnerProgressController::class, 'index'])->name('learner-progress.index');

// AJAX data endpoint for DataTables
Route::get('/learner-progress/data', [LearnerProgressController::class, 'data'])->name('learner-progress.data');
