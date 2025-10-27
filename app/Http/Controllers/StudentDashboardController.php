<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    /**
     * Display the student dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        // Get all subjects
        $subjects = Subject::all();

        // Get IDs of enrolled subjects
        $enrollments = $user->enrollments()->pluck('subject_id')->toArray();

        return view('student.dashboard', compact('subjects', 'enrollments'));
        // No need to pass $user, use auth()->user() in Blade
    }
}
