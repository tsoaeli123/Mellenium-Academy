<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function enroll(Subject $subject)
    {
        $user = Auth::user();

        // Check if already enrolled
        if (!$user->enrollments()->where('subject_id', $subject->id)->exists()) {
            $user->enrollments()->attach($subject->id); // assuming pivot table 'enrollments'
        }

        return redirect()->back()->with('success', 'Enrolled successfully!');
    }
}
