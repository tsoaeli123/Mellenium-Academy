<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\WatchVideoController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use App\Models\video;

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

   //Videos uploads
     Route::get('/teacher/video', [VideoController::class, 'index'])->name('teacher.videoUpload');
     Route::post('/videos', [VideoController::class, 'store'])->name('videos.store');
     Route::delete('/videoUpload/{id}', [VideoController::class, 'destroy'])->name('teacher.destroy');

     //Documents uploads
     Route::get('/document', [DocumentController::class, 'index'])->name('teacher.documentUpload');
     Route::post('/upload-document', [DocumentController::class, 'store'])->name('documents.store');
     Route::delete('/document/{id}', [DocumentController::class, 'destroy'])->name('document.destroy');



});

// Student dashboard
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])
        ->name('student.dashboard');


     //Student Courses 
   Route::get('/courses', [CourseController::class, 'index']) ->name('student.course');
   Route::get('/course/{subject}', [CourseController::class, 'show']) ->name('student.showCourse');
   Route::get('/watchVideo/{subject}', [WatchVideoController::class, 'index']) ->name('student.displayVideo');
   Route::get('/videosGet/{subject}', [WatchVideoController::class, 'create']);
  
   Route::get('/file/{subject}', [FileController::class, 'index']) ->name('student.displayDocument');
   Route::get('/filesGet/{subject}', [FileController::class, 'create']);



});

// Enrollment routes
Route::middleware(['auth', 'verified'])->post('/student/enroll/{subject}', [EnrollmentController::class, 'enroll'])
    ->name('enroll.subject');

// Teacher dashboard
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/teacher/dashboard', function () {
         $id  = Auth::id();

        $docCount = Document::where('user_id', $id)->count();
        $videoCount = video::where('user_id', $id)->count();

        $latestDocument = Document::where('user_id', $id)->latest()->first();
        $latestVideo = video::where('user_id', $id)->latest()->first();

        return view('teacher.dashboard', compact('docCount','videoCount','latestDocument','latestVideo'));

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
