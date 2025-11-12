<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index() {
        $subjects = Subject::all();
        return view('student.subjects.index', compact('subjects'));
    }

    public function enroll(Subject $subject) {
        $user = auth()->user();
        $user->enrolledSubjects()->syncWithoutDetaching([$subject->id]);
        return redirect()->back()->with('success', 'Enrolled successfully!');
    }

    public function show(Subject $subject) {
        if (!auth()->user()->enrolledSubjects->contains($subject->id)) {
            abort(403, 'You are not enrolled in this subject');
        }
        return view('student.subjects.show', compact('subject'));
    }
}

