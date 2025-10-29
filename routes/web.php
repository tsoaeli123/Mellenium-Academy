<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\EnrollmentController;
use Illuminate\Support\Facades\Route;

// Public route
Route::get('/', function () {
    return view('welcome');
});

// Dashboard redirect based on role
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->role === 'student') {
            return redirect()->route('student.dashboard');
        } elseif ($user->role === 'teacher') {
            return redirect()->route('teacher.dashboard');
        } elseif ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return view('dashboard'); // fallback
    })->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Student dashboard
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])
        ->name('student.dashboard');
});

// Enrollment routes
Route::middleware(['auth', 'verified'])->post('/student/enroll/{subject}', [EnrollmentController::class, 'enroll'])
    ->name('enroll.subject');

// Teacher dashboard
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/teacher/dashboard', function () {
        return view('teacher.dashboard');
    })->name('teacher.dashboard');
});

// Student subject access
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/student/subject/{subject}', [StudentDashboardController::class, 'showSubject'])
        ->name('student.subject.show');
});

// Admin dashboard and management routes
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');
    Route::patch('/users/{user}', [AdminDashboardController::class, 'updateUserStatus'])
        ->name('admin.users.update');
    Route::patch('/payments/{enrollment}', [AdminDashboardController::class, 'updatePaymentStatus'])
        ->name('admin.payments.update');
});

require __DIR__.'/auth.php';
