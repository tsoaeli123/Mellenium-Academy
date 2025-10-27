<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        ]);

        // Create user based on role
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'status' => 'unpaid',
        ];

        // Only add grade if user is a student
        if ($validated['role'] === 'student') {
            $userData['grade'] = $validated['grade'];
        } else {
            $userData['grade'] = null; // Explicitly set to null for teachers
        }

        $user = User::create($userData);

        event(new Registered($user));

        // Redirect to login with success message
        return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
    }
}
