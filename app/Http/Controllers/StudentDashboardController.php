<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get all subjects
        $subjects = Subject::all();

        // Get user's enrollments with payment status
        $enrollments = Enrollment::where('user_id', $user->id)->get();

        return view('student.dashboard', compact('subjects', 'enrollments'));
    }

    public function showSubject(Subject $subject)
    {
        $user = Auth::user();

        // Check if user is enrolled and payment is paid
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('subject_id', $subject->id)
            ->first();

        if (!$enrollment || $enrollment->payment_status !== 'paid') {
            return redirect()->route('student.dashboard')->with('error', 'You do not have access to this subject.');
        }

        // Here you can pass subject materials, videos, etc.
        return view('student.subject-show', compact('subject'));
    }
}
