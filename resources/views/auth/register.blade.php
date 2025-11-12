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
        .file-upload {
            position: relative;
            display: inline-block;
            width: 100%;
        }
        .file-upload-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            border: 2px dashed #d1d5db;
            border-radius: 0.5rem;
            background-color: #f9fafb;
            cursor: pointer;
            transition: all 0.3s;
        }
        .file-upload-label:hover {
            border-color: #059669;
            background-color: #f0fdf4;
        }
        .file-upload-label.has-file {
            border-color: #059669;
            background-color: #f0fdf4;
        }
        .file-input {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
            opacity: 0;
            cursor: pointer;
        }
        .file-name {
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: #374151;
            text-align: center;
        }
        .payment-status {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center py-8">
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

        <form class="mt-8 space-y-6 bg-white p-8 rounded-2xl shadow-lg border border-gray-100" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
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
                <select id="role" name="role" required onchange="toggleGradeAndPayment()"
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

            <!-- Payment Screenshot Upload (visible only for students) -->
            <div id="payment-section" style="display: none;">
                <label class="block text-sm font-medium text-gray-700 mb-2">Payment Screenshot</label>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">
                                Payment Required for Students
                            </h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>Students are required to pay a registration fee. Please upload a screenshot of your payment confirmation.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="file-upload">
                    <label for="payment_screenshot" id="file-upload-label" class="file-upload-label">
                        <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <span class="text-sm font-medium text-gray-600">Click to upload payment screenshot</span>
                        <span class="text-xs text-gray-500 mt-1">PNG, JPG, JPEG up to 5MB</span>
                    </label>
                    <input id="payment_screenshot" name="payment_screenshot" type="file" class="file-input" accept="image/*">
                    <div id="file-name" class="file-name"></div>
                </div>
                @error('payment_screenshot')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <div class="mt-4">
                    <span class="payment-status status-pending">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                        </svg>
                        Payment Status: Pending
                    </span>
                </div>
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
        function toggleGradeAndPayment() {
            const role = document.getElementById('role').value;
            const gradeSection = document.getElementById('grade-section');
            const gradeSelect = document.getElementById('grade');
            const paymentSection = document.getElementById('payment-section');
            const paymentInput = document.getElementById('payment_screenshot');

            if (role === 'student') {
                gradeSection.style.display = 'block';
                gradeSelect.required = true;
                paymentSection.style.display = 'block';
                paymentInput.required = true;
            } else {
                gradeSection.style.display = 'none';
                gradeSelect.required = false;
                gradeSelect.value = '';
                paymentSection.style.display = 'none';
                paymentInput.required = false;
                paymentInput.value = '';
                resetFileUpload();
            }
        }

        function resetFileUpload() {
            document.getElementById('file-upload-label').classList.remove('has-file');
            document.getElementById('file-name').textContent = '';
        }

        // File upload handling
        document.getElementById('payment_screenshot').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : '';
            document.getElementById('file-name').textContent = fileName;

            if (fileName) {
                document.getElementById('file-upload-label').classList.add('has-file');
            } else {
                document.getElementById('file-upload-label').classList.remove('has-file');
            }
        });

        // Initialize on page load - handle form validation errors
        document.addEventListener('DOMContentLoaded', function() {
            const initialRole = document.getElementById('role').value;

            // If role is already selected (from form validation), show/hide grade and payment accordingly
            if (initialRole === 'student') {
                document.getElementById('grade-section').style.display = 'block';
                document.getElementById('grade').required = true;
                document.getElementById('payment-section').style.display = 'block';
                document.getElementById('payment_screenshot').required = true;
            } else if (initialRole === 'teacher') {
                document.getElementById('grade-section').style.display = 'none';
                document.getElementById('grade').required = false;
                document.getElementById('payment-section').style.display = 'none';
                document.getElementById('payment_screenshot').required = false;
            } else {
                // No role selected yet
                document.getElementById('grade-section').style.display = 'none';
                document.getElementById('grade').required = false;
                document.getElementById('payment-section').style.display = 'none';
                document.getElementById('payment_screenshot').required = false;
            }
        });
    </script>
</body>
</html>
