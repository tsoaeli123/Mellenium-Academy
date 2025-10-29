<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function enroll(Subject $subject)
    {
        $user = Auth::user();

        // Check if already enrolled
        $existingEnrollment = Enrollment::where('user_id', $user->id)
            ->where('subject_id', $subject->id)
            ->first();

        if ($existingEnrollment) {
            return redirect()->back()->with('error', 'You are already enrolled in this subject!');
        }

        // Create enrollment using the Enrollment model
        Enrollment::create([
            'user_id' => $user->id,
            'subject_id' => $subject->id,
            'payment_status' => 'pending', // Add this field
        ]);

        return redirect()->back()->with('success', 'Successfully enrolled in ' . $subject->title . '!');
    }
}
