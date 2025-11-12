<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Enrollment;
use App\Models\Subject;
use App\Models\Video;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentStatusUpdated;
use Illuminate\Support\Facades\Log;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $students = User::where('role', 'student')->get();
        $teachers = User::where('role', 'teacher')->get();
        $admins = User::where('role', 'admin')->get();
        $enrollments = Enrollment::with(['user', 'subject'])->get();
        $subjects = Subject::all();

        // Get teacher uploads
        $videos = Video::with('user')->get();
        $documents = Document::with('user')->get();

        $stats = [
            'total_students' => User::where('role', 'student')->count(),
            'total_teachers' => User::where('role', 'teacher')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_subjects' => Subject::count(),
            'pending_payments' => Enrollment::where('payment_status', 'pending')->count(),
            'pending_videos' => Video::where('approved', false)->count(),
            'pending_documents' => Document::where('approved', false)->count(),
        ];

        return view('admin.dashboard', compact(
            'students',
            'teachers',
            'admins',
            'enrollments',
            'subjects',
            'videos',
            'documents',
            'stats'
        ));
    }

    public function updateUserStatus(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required|in:paid,pending,unpaid,active,inactive',
            'role' => 'sometimes|in:student,teacher,admin'
        ]);

        $oldStatus = $user->status;
        $newStatus = $request->status;

        $user->update([
            'status' => $newStatus,
            'role' => $request->role ?? $user->role
        ]);

        // Send email notification only if:
        // 1. Status actually changed
        // 2. User is a student
        // 3. Status is related to payment (paid, pending, unpaid)
        if ($oldStatus !== $newStatus &&
            $user->role === 'student' &&
            in_array($newStatus, ['paid', 'pending', 'unpaid'])) {

            try {
                Mail::to($user->email)->send(new PaymentStatusUpdated($user, $newStatus));

                // Log successful email
                Log::info("Payment status email sent to: {$user->email} - Status: {$newStatus}");

                $message = 'User status updated successfully! Email notification sent to student.';

            } catch (\Exception $e) {
                // Log the actual error with details
                $errorMessage = $e->getMessage();
                Log::error("Email failed to send to {$user->email}: {$errorMessage}");

                $message = "User status updated successfully! (Email failed: {$errorMessage})";
            }
        } else {
            $message = 'User status updated successfully!';
        }

        return redirect()->back()->with('success', $message);
    }

    public function updatePaymentStatus(Request $request, Enrollment $enrollment)
    {
        $request->validate([
            'payment_status' => 'required|in:paid,pending,failed'
        ]);

        $oldStatus = $enrollment->payment_status;
        $newStatus = $request->payment_status;

        $enrollment->update([
            'payment_status' => $newStatus
        ]);

        // Send email notification for enrollment payment status changes
        if ($oldStatus !== $newStatus && $enrollment->user->role === 'student') {
            try {
                Mail::to($enrollment->user->email)->send(new PaymentStatusUpdated($enrollment->user, $newStatus, true));

                // Log successful email
                Log::info("Enrollment payment status email sent to: {$enrollment->user->email} - Status: {$newStatus}");

                $message = 'Payment status updated successfully! Email notification sent to student.';

            } catch (\Exception $e) {
                // Log the actual error with details
                $errorMessage = $e->getMessage();
                Log::error("Enrollment email failed to send to {$enrollment->user->email}: {$errorMessage}");

                $message = "Payment status updated successfully! (Email failed: {$errorMessage})";
            }
        } else {
            $message = 'Payment status updated successfully!';
        }

        return redirect()->back()->with('success', $message);
    }

    // Video Management Methods
    public function approveVideo(Video $video)
    {
        $video->update(['approved' => true]);
        return redirect()->route('admin.dashboard')->with('success', 'Video approved successfully!');
    }

    public function deleteVideo(Video $video)
    {
        // Delete the file from storage
        if (Storage::exists($video->path)) {
            Storage::delete($video->path);
        }

        $video->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Video deleted successfully!');
    }

    // Document Management Methods
    public function approveDocument(Document $document)
    {
        $document->update(['approved' => true]);
        return redirect()->route('admin.dashboard')->with('success', 'Document approved successfully!');
    }

    public function deleteDocument(Document $document)
    {
        // Delete the file from storage
        if (Storage::exists($document->path)) {
            Storage::delete($document->path);
        }

        $document->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Document deleted successfully!');
    }
}
