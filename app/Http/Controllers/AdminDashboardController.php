<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Enrollment;
use App\Models\Subject;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $students = User::where('role', 'student')->get();
        $teachers = User::where('role', 'teacher')->get();
        $admins = User::where('role', 'admin')->get();
        $enrollments = Enrollment::with(['user', 'subject'])->get();
        $subjects = Subject::all();

        $stats = [
            'total_students' => User::where('role', 'student')->count(),
            'total_teachers' => User::where('role', 'teacher')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_subjects' => Subject::count(),
            'pending_payments' => Enrollment::where('payment_status', 'pending')->count(),
        ];

        return view('admin.dashboard', compact(
            'students',
            'teachers',
            'admins',
            'enrollments',
            'subjects',
            'stats'
        ));
    }

    public function updateUserStatus(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required|in:paid,pending,active,inactive',
            'role' => 'sometimes|in:student,teacher,admin'
        ]);

        $user->update([
            'status' => $request->status,
            'role' => $request->role ?? $user->role // Keep current role if not provided
        ]);

        return redirect()->back()->with('success', 'User updated successfully!');
    }

    public function updatePaymentStatus(Request $request, Enrollment $enrollment)
    {
        $request->validate([
            'payment_status' => 'required|in:paid,pending,failed'
        ]);

        $enrollment->update([
            'payment_status' => $request->payment_status
        ]);

        return redirect()->back()->with('success', 'Payment status updated successfully!');
    }
}
