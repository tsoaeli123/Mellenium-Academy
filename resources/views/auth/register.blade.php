<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Millennium Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="flex justify-center">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-green-800 rounded-lg flex items-center justify-center">
                        <span class="text-yellow-400 font-bold text-xl">MA</span>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Millennium Academy</h2>
                        <p class="text-sm text-gray-600">Create your account</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="mt-8 space-y-6 bg-white p-8 rounded-2xl shadow-lg border border-gray-100" method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                <input id="name" name="name" type="text" required
                    class="mt-1 appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:z-10"
                    placeholder="Enter your full name"
                    value="{{ old('name') }}">
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input id="email" name="email" type="email" required
                    class="mt-1 appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:z-10"
                    placeholder="Enter your email"
                    value="{{ old('email') }}">
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" name="password" type="password" required
                    class="mt-1 appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:z-10"
                    placeholder="Create a password">
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                    class="mt-1 appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:z-10"
                    placeholder="Confirm your password">
                @error('password_confirmation')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role Selection -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">I am a</label>
                <select id="role" name="role" required onchange="toggleGradeSelect()"
                    class="mt-1 block w-full px-3 py-3 border border-gray-300 bg-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <option value="">Select your role</option>
                    <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                    <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Teacher</option>
                </select>
                @error('role')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Grade Selection (visible only for students) -->
            <div id="grade-section" style="display: none;">
                <label for="grade" class="block text-sm font-medium text-gray-700">Select Grade</label>
                <select id="grade" name="grade"
                    class="mt-1 block w-full px-3 py-3 border border-gray-300 bg-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <option value="">Select your grade</option>
                    <option value="Grade 8" {{ old('grade') == 'Grade 8' ? 'selected' : '' }}>Grade 8</option>
                    <option value="Grade 9" {{ old('grade') == 'Grade 9' ? 'selected' : '' }}>Grade 9</option>
                    <option value="Grade 10" {{ old('grade') == 'Grade 10' ? 'selected' : '' }}>Grade 10</option>
                    <option value="Grade 11" {{ old('grade') == 'Grade 11' ? 'selected' : '' }}>Grade 11</option>
                    <option value="Grade 12" {{ old('grade') == 'Grade 12' ? 'selected' : '' }}>Grade 12</option>
                </select>
                @error('grade')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                    Create Account
                </button>
            </div>

            <!-- Login Link -->
            <div class="text-center">
                <a href="{{ route('login') }}" class="text-green-700 hover:text-green-800 text-sm font-medium">
                    Already have an account? Sign in
                </a>
            </div>
        </form>

        <!-- Academy Motto -->
        <div class="text-center text-gray-600 text-sm mt-6">
            <p class="font-medium">"We either find a way or we make one. Yes we can."</p>
            <p class="mt-1">Powered by TechSolve</p>
        </div>
    </div>

    <script>
        function toggleGradeSelect() {
            const role = document.getElementById('role').value;
            const gradeSection = document.getElementById('grade-section');
            const gradeSelect = document.getElementById('grade');

            if (role === 'student') {
                gradeSection.style.display = 'block';
                gradeSelect.required = true;
            } else {
                gradeSection.style.display = 'none';
                gradeSelect.required = false;
                gradeSelect.value = '';
            }
        }

        // Initialize on page load - handle form validation errors
        document.addEventListener('DOMContentLoaded', function() {
            const initialRole = document.getElementById('role').value;

            // If role is already selected (from form validation), show/hide grade accordingly
            if (initialRole === 'student') {
                document.getElementById('grade-section').style.display = 'block';
                document.getElementById('grade').required = true;
            } else if (initialRole === 'teacher') {
                document.getElementById('grade-section').style.display = 'none';
                document.getElementById('grade').required = false;
            } else {
                // No role selected yet
                document.getElementById('grade-section').style.display = 'none';
                document.getElementById('grade').required = false;
            }
        });
    </script>
</body>
</html>
