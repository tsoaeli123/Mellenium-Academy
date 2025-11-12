<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Dashboard - Millennium Academy</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    * {
        margin:0;
        padding:0;
        box-sizing:border-box;
        font-family: 'Inter', sans-serif;
    }

    body {
        display:flex;
        min-height:100vh;
        background:#f8fafc;
        color:#1e293b;
        line-height: 1.6;
    }

    /* Sidebar */
    .sidebar {
        width:280px;
        background:#1a472a; /* Dark Green */
        color:white;
        display:flex;
        flex-direction:column;
        height:100vh;
        padding:2rem 1.5rem;
        position:fixed;
        transition: transform 0.3s ease;
        box-shadow: 0 0 20px rgba(0,0,0,0.15);
        z-index: 100;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 2.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .logo-icon {
        width: 50px;
        height: 50px;
        background: #f1c40f; /* Yellow */
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #1a472a;
        font-weight: 800;
        font-size: 1.3rem;
        box-shadow: 0 4px 12px rgba(241, 196, 15, 0.3);
    }

    .logo-text h1 {
        font-size:1.4rem;
        font-weight:800;
        line-height: 1.2;
    }

    .logo-text span {
        color:#f1c40f; /* Yellow */
    }

    .logo-text p {
        font-size:0.8rem;
        opacity: 0.8;
        margin-top: 3px;
    }

    .sidebar-nav {
        flex: 1;
    }

    .sidebar a, .sidebar form button {
        display:flex;
        align-items: center;
        gap: 12px;
        color:rgba(255,255,255,0.85);
        text-decoration:none;
        margin:0.5rem 0;
        padding:0.85rem 1rem;
        border-radius:10px;
        font-weight:500;
        background:none;
        border:none;
        cursor:pointer;
        width:100%;
        text-align:left;
        transition: all 0.3s ease;
    }

    .sidebar a i, .sidebar form button i {
        width: 20px;
        text-align: center;
        font-size: 1.1rem;
    }

    .sidebar a:hover, .sidebar form button:hover {
        background:rgba(241, 196, 15, 0.15);
        color: #f1c40f;
        transform: translateX(5px);
    }

    .sidebar a.active {
        background: #f1c40f;
        color: #1a472a;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(241, 196, 15, 0.3);
    }

    /* Sidebar collapse toggle */
    .sidebar-toggle {
        display:none;
        position:fixed;
        top:1.5rem;
        left:1.5rem;
        background:#1a472a;
        border:none;
        color:white;
        padding:0.85rem;
        border-radius:10px;
        cursor:pointer;
        z-index:1000;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
    }

    .sidebar-toggle:hover {
        background: #0f2d1a;
        transform: scale(1.05);
    }

    /* Main content */
    .main-content {
        margin-left:280px;
        flex:1;
        padding:2.5rem 3rem;
        transition: margin-left 0.3s ease;
        background: #f8fafc;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .header h1 {
        color: #1a472a;
        font-weight: 700;
        font-size: 2rem;
        background: linear-gradient(135deg, #1a472a 0%, #2d5a3d 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 15px;
        background: white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .user-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1a472a 0%, #2d5a3d 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.2rem;
        box-shadow: 0 4px 8px rgba(26, 71, 42, 0.3);
    }

    /* Cards */
    .card {
        background:#fff;
        padding:2rem;
        border-radius:16px;
        box-shadow:0 4px 20px rgba(0,0,0,0.06);
        border: 1px solid #f1f5f9;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.1);
    }

    .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #1a472a 0%, #f1c40f 100%);
    }

    .card h2, .card h3, .card h4 {
        color:#1a472a;
        margin-bottom: 1rem;
        font-weight: 700;
    }

    .card h2 {
        font-size: 1.5rem;
    }

    .card h3 {
        font-size: 1.3rem;
    }

    .card h4 {
        font-size: 1.1rem;
    }

    /* Welcome Card */
    .welcome-card {
        background: linear-gradient(135deg, #1a472a 0%, #2d5a3d 100%);
        color: white;
        display: flex;
        align-items: center;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .welcome-card::before {
        display: none;
    }

    .welcome-card h2, .welcome-card p {
        color: white;
    }

    .welcome-icon {
        font-size: 3.5rem;
        color: #f1c40f;
        opacity: 0.9;
    }

    /* Subject Grid */
    .subject-grid {
        display:grid;
        grid-template-columns:repeat(auto-fit, minmax(320px,1fr));
        gap:1.5rem;
        margin-top: 1.5rem;
    }

    .subject-card {
        border-left: 4px solid #1a472a;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .subject-card:hover {
        border-left-color: #f1c40f;
        transform: translateY(-3px);
    }

    .subject-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .subject-icon {
        width: 55px;
        height: 55px;
        background: rgba(26, 71, 42, 0.1);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #1a472a;
        font-size: 1.4rem;
    }

    .subject-status {
        font-size: 0.8rem;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-weight: 600;
    }

    .status-enrolled {
        background: rgba(74, 222, 128, 0.2);
        color: #16a34a;
    }

    .status-pending {
        background: rgba(241, 196, 15, 0.2);
        color: #d97706;
    }

    .status-available {
        background: rgba(156, 163, 175, 0.2);
        color: #6b7280;
    }

    .subject-details {
        margin: 1rem 0;
    }

    .detail-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0.5rem 0;
        font-size: 0.9rem;
        color: #64748b;
    }

    .detail-item i {
        color: #1a472a;
        width: 16px;
    }

    /* Buttons */
    button.logout {
        background:#dc2626;
        color:white;
        padding:0.85rem 1.5rem;
        border-radius:10px;
        font-weight:600;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        width: 100%;
        justify-content: center;
        margin-top: 1rem;
    }

    button.logout:hover {
        background:#b91c1c;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }

    button.enroll {
        background:#1a472a;
        color:white;
        padding:0.85rem 1.5rem;
        border-radius:10px;
        font-weight:600;
        border:none;
        cursor:pointer;
        width: 100%;
        margin-top: 1rem;
        transition: all 0.3s ease;
    }

    button.enroll:hover {
        background:#0f2d1a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(26, 71, 42, 0.3);
    }

    button.access-subject {
        background:#1a472a;
        color:white;
        padding:0.85rem 1.5rem;
        border-radius:10px;
        font-weight:600;
        border:none;
        cursor:pointer;
        width: 100%;
        margin-top: 1rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: block;
        text-align: center;
    }

    button.access-subject:hover {
        background:#0f2d1a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(26, 71, 42, 0.3);
    }

    button.pending {
        background:#f59e0b;
        color:white;
        padding:0.85rem 1.5rem;
        border-radius:10px;
        font-weight:600;
        border:none;
        cursor:default;
        width: 100%;
        margin-top: 1rem;
    }

    /* Alert Messages */
    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .alert-error {
        background: #fee2e2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }

    /* Responsive */
    @media(max-width:768px) {
        .sidebar {
            transform: translateX(-280px);
        }

        .main-content {
            margin-left:0;
            padding: 1.5rem 1rem;
        }

        .sidebar.show {
            transform: translateX(0);
        }

        .sidebar-toggle {
            display:block;
        }

        .subject-grid {
            grid-template-columns: 1fr;
        }

        .header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .user-info {
            align-self: stretch;
            justify-content: flex-start;
        }

        .welcome-card {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }
    }

    @media(max-width:480px) {
        .main-content {
            padding: 1rem 0.5rem;
        }

        .card {
            padding: 1.5rem;
        }
    }
</style>
</head>
<body>

<!-- Sidebar toggle button for mobile -->
<button class="sidebar-toggle" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="logo">
        <div class="logo-icon">MA</div>
        <div class="logo-text">
            <h1>Millennium <span>Academy</span></h1>
            <p>Student Portal</p>
        </div>
    </div>

    <div class="sidebar-nav">
        <a href="{{ route('student.dashboard') }}" class="active">
            <i class="fas fa-home"></i>
            Dashboard
        </a>
        <a href="{{route('student.course')}}">
            <i class="fas fa-user-graduate"></i>
            My Courses
        </a>
        <a href="{{route('chat.chat')}}" class="action-btn">
                  <i class="fa-solid fa-comment-dots"></i>
               Teacher Chat 
            </a>
        <a href="#">
            <i class="fas fa-calendar-alt"></i>
            Schedule
        </a>
           <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout">
            <i class="fas fa-sign-out-alt"></i>
            Logout
        </button>
    </form>
        <a href="{{route('student.announcements')}}">
            <i class="fas fa-bell"></i>
            View Announcements
        </a>
        <a href="#">
            <i class="fas fa-tasks"></i>
            Assignments
        </a>
        <a href="#">
            <i class="fas fa-chart-line"></i>
            Progress
        </a>
        <a href="{{route('student.payment')}}">
            <i class="fas fa-credit-card"></i>
            Payments
        </a>

        <a href="#">
            <i class="fas fa-headset"></i>
            Support
        </a>
    </div>


</div>

<!-- Main Content -->
<div class="main-content">
    <!-- Header -->
    <div class="header">
        <h1>Student Dashboard</h1>
        <div class="user-info">
            <div class="user-avatar">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div>
                <div><strong>{{ auth()->user()->name }}</strong></div>
                <div style="font-size: 0.85rem; color: #64748b;">Student ID: STU-{{ substr(auth()->user()->id, 0, 6) }}</div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    <!-- Welcome Card -->
    <div class="card welcome-card">
        <div class="welcome-icon">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <div>
            <h2>Welcome back, {{ auth()->user()->name }}!</h2>
            <p>Continue your learning journey. You have access to all available subjects below.</p>
        </div>
    </div>

    <!-- User Info Card -->
    <div class="card">
        <h3>Student Information</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <div>
                <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                <p><strong>Student ID:</strong> STU-{{ substr(auth()->user()->id, 0, 6) }}</p>
            </div>
            <div>
                <p><strong>Role:</strong> {{ ucfirst(auth()->user()->role) }}</p>
                <p><strong>Status:</strong> {{ ucfirst(auth()->user()->status) }}</p>
            </div>
        </div>
    </div>

    <!-- Available Subjects Section -->
    <div class="card">
        <h3>Available Subjects</h3>
        <p>Enroll in subjects to begin your learning journey</p>

        <div class="subject-grid">
            @foreach($subjects as $subject)
                @php
                    // Get enrollment status for this subject
                    $enrollment = $enrollments->where('subject_id', $subject->id)->first();
                    $isEnrolled = $enrollment !== null;
                    $paymentStatus = $enrollment ? $enrollment->payment_status : null;

                    $icons = [
                        'Mathematics' => 'fas fa-calculator',
                        'Biology' => 'fas fa-dna',
                        'Physical Science' => 'fas fa-flask',
                        'English' => 'fas fa-book-open',
                        'Accounting' => 'fas fa-chart-bar'
                    ];
                    $icon = $icons[$subject->title] ?? 'fas fa-book';
                @endphp
                <div class="card subject-card">
                    <div class="subject-header">
                        <div class="subject-icon">
                            <i class="{{ $icon }}"></i>
                        </div>
                        <div class="subject-status
                            @if($isEnrolled && $paymentStatus === 'paid') status-enrolled
                            @elseif($isEnrolled && $paymentStatus === 'pending') status-pending
                            @else status-available @endif">
                            @if($isEnrolled && $paymentStatus === 'paid')
                                Enrolled & Paid
                            @elseif($isEnrolled && $paymentStatus === 'pending')
                                Pending Payment
                            @else
                                Available
                            @endif
                        </div>
                    </div>
                    <h4>{{ $subject->title }}</h4>
                    <p>{{ $subject->description ?? 'Master this subject with our comprehensive curriculum.' }}</p>

                    @if($isEnrolled && $paymentStatus === 'paid')
                        <a href="{{ route('student.subject.show', $subject->id) }}" class="access-subject">
                            <i class="fas fa-door-open"></i> Enter Subject
                        </a>
                    @elseif($isEnrolled && $paymentStatus === 'pending')
                        <button class="pending">
                            <i class="fas fa-clock"></i> Payment Pending
                        </button>
                    @else
                        <form method="POST" action="{{ route('enroll.subject', $subject->id) }}">
                            @csrf
                            <button type="submit" class="enroll">
                                <i class="fas fa-plus-circle"></i> Enroll Now
                            </button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.querySelector('.sidebar-toggle');

        if (window.innerWidth <= 768 &&
            !sidebar.contains(event.target) &&
            !toggleBtn.contains(event.target) &&
            sidebar.classList.contains('show')) {
            sidebar.classList.remove('show');
        }
    });
</script>

</body>
</html>
