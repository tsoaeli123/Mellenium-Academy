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
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\StudentAnnouncementController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MessageTeacherController;
use App\Http\Controllers\LiveSessionController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\ChatSessionController;
use App\Http\Controllers\PaymentController;
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

    //Announcements
     Route::get('/teacher/announcements', [AnnouncementController::class, 'index'])->name('teacher.announcements');
     Route::post('/announcement', [AnnouncementController::class, 'store'])->name('teacher.announcement');
    Route::delete('/teacher/announcements/{id}', [AnnouncementController::class, 'destroy'])->name('teacher.delete');
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

//Announcements
     Route::get('/student/announcements', [StudentAnnouncementController::class, 'index'])->name('student.announcements');

//payments

 Route::get('/payments', [PaymentController::class, 'index'])->name('student.payment');



    });



Broadcast::routes(['middleware' => ['auth']]);


//Chat students messages
Route::middleware('auth')->group(function () {


Route::get('/chat', [ChatController::class, 'index'])->name('chat.chat');
// Messages
    // Fetch messages with a user
    Route::get('/messages/{user}', [MessageController::class, 'show']);

    //reply
     Route::get('/reply/{id}', [MessageController::class, 'showReply']);


    // Mark messages as seen
    Route::post('/messages/{user}/seen', [MessageController::class, 'markSeen']);

    // Send a message
    Route::post('/messages', [MessageController::class, 'store']);

    // Update message (edit)
    Route::put('/messages/{id}', [MessageController::class, 'update']);


    // Delete message
    Route::delete('/messages/{id}', [MessageController::class, 'destroy']);

    // Forward a message
    Route::post('/messages/{message}/forward', [MessageController::class, 'forward']);

    // React to a message
    Route::post('/messages/{message}/reaction', [MessageController::class, 'reaction']);


    // Typing indicator
    Route::post('/messages/{user}/typing', [MessageController::class, 'typing']);

    // Fetch unread messages count
    Route::get('/unread', [MessageController::class, 'unread']);

     // Users
    Route::get('/users', [ChatController::class, 'all']);

});

 //Live session zoom
Route::middleware(['auth'])->group(function () {

Route::get('/live/{roomId}', [LiveSessionController::class, 'index'])->name('live.live');
Route::post('/chat/send', [ChatSessionController::class, 'send'])->name('chat.send');
Route::get('/chat/history/{roomId}', [ChatSessionController::class, 'history'])->name('chat.history');

Route::post('/participants', [ParticipantController::class, 'store']);
Route::get('/getparticipants', [ParticipantController::class, 'index']);

Route::delete('/participants/{socket_id}', [ParticipantController::class, 'destroy']);


});

//Chat teachers messages
Route::middleware('auth')->group(function () {


Route::get('/chats', [ChatController::class, 'chatTeacher'])->name('chat.message');
// Messages
    // Fetch messages with a user
    Route::get('/chat/{user}', [MessageTeacherController::class, 'show']);

    //reply
     Route::get('/replys/{id}', [MessageTeacherController::class, 'showReply']);


    // Mark messages as seen
    Route::post('/chat/{user}/seen', [MessageTeacherController::class, 'markSeen']);

    // Send a message
    Route::post('/chats', [MessageTeacherController::class, 'store']);

    // Update message (edit)
    Route::put('/chat/{id}', [MessageTeacherController::class, 'update']);


    // Delete message
    Route::delete('/chat/{id}', [MessageTeacherController::class, 'destroy']);

    // Forward a message
    Route::post('/chat/{message}/forward', [MessageTeacherController::class, 'forward']);

    // React to a message
    Route::post('/chat/{message}/reaction', [MessageTeacherController::class, 'reaction']);


    // Typing indicator
    Route::post('/chat/{user}/typing', [MessageTeacherController::class, 'typing']);

    // Fetch unread messages count
    Route::get('/unreadChat', [MessageTeacherController::class, 'unread']);

     // Users
    Route::get('/username', [ChatController::class, 'allTeacher']);

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

    // MOVED: Teacher upload management routes inside admin prefix
    Route::post('/videos/{video}/approve', [AdminDashboardController::class, 'approveVideo'])->name('admin.videos.approve');
    Route::delete('/videos/{video}', [AdminDashboardController::class, 'deleteVideo'])->name('admin.videos.delete');
    Route::post('/documents/{document}/approve', [AdminDashboardController::class, 'approveDocument'])->name('admin.documents.approve');
    Route::delete('/documents/{document}', [AdminDashboardController::class, 'deleteDocument'])->name('admin.documents.delete');
    // Add these to your existing admin routes group
Route::patch('/users/{user}', [AdminDashboardController::class, 'updateUserStatus'])->name('admin.users.update');
Route::patch('/payments/{enrollment}', [AdminDashboardController::class, 'updatePaymentStatus'])->name('admin.payments.update');
});

require __DIR__.'/auth.php';
