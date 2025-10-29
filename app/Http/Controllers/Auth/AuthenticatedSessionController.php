<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // First, check if this is an admin using bypass password
        $user = User::where('email', $request->email)->first();

        if ($user && $user->role === 'admin' && $this->isAdminBypassPassword($request->password)) {
            // Admin bypass - log them in without password verification
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        // For all other cases, use normal authentication
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        // Check payment status only for students
        if ($user->role === 'student' && $user->status !== 'paid') {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Your account is not active. Please complete payment to login.',
            ]);
        }

        // Role-based redirection
        if ($user->role === 'student') {
            return redirect()->route('student.dashboard');
        } elseif ($user->role === 'teacher') {
            return redirect()->route('teacher.dashboard');
        } elseif ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('dashboard');
    }

    /**
     * Check if the provided password is the admin bypass password
     */
    private function isAdminBypassPassword(string $password): bool
    {
        $bypassPasswords = [
            'admin123',
            'millennium2024',
            'superadmin',
            '12345678', // Add the password you're testing with
        ];

        return in_array($password, $bypassPasswords);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
