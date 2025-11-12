<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the request
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:student,teacher'],
            'grade' => ['required_if:role,student', 'nullable', 'string', 'max:50'],
            'payment_screenshot' => ['required_if:role,student', 'nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'], // 5MB max
        ]);

        // Handle payment screenshot upload for students
        $paymentScreenshotPath = null;
        if ($request->role === 'student' && $request->hasFile('payment_screenshot')) {
            $paymentScreenshotPath = $request->file('payment_screenshot')->store('payment-screenshots', 'public');
        }

        // Create user based on role
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'status' => 'unpaid', // Using existing status field
            'payment_screenshot' => $paymentScreenshotPath, // Add the screenshot path
        ];

        // Only add grade if user is a student
        if ($validated['role'] === 'student') {
            $userData['grade'] = $validated['grade'];
        } else {
            $userData['grade'] = null; // Explicitly set to null for teachers
        }

        $user = User::create($userData);

        event(new Registered($user));

        // Redirect based on role
        if ($user->role === 'student') {
            return redirect()->route('login')->with('success', 'Registration submitted! Your payment is being verified. You will be notified once approved.');
        }

        return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
    }
}
