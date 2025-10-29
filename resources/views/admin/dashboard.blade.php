<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Millennium Academy</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #f8fafc;
            color: #1e293b;
            line-height: 1.6;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: #1a472a;
            color: white;
            padding: 2rem 1.5rem;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
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
            background: #f1c40f;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1a472a;
            font-weight: 800;
            font-size: 1.3rem;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            margin: 0.5rem 0;
            padding: 0.85rem 1rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .sidebar-nav a.active {
            background: #f1c40f;
            color: #1a472a;
            font-weight: 600;
        }

        .sidebar-nav a:hover {
            background: rgba(241, 196, 15, 0.15);
            color: #f1c40f;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 2rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border-left: 4px solid #1a472a;
        }

        .stat-card h3 {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #1a472a;
        }

        .card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
        }

        .card h2 {
            color: #1a472a;
            margin-bottom: 1rem;
            font-size: 1.3rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            background: #f8fafc;
            font-weight: 600;
            color: #1a472a;
        }

        .status-badge {
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-paid { background: #dcfce7; color: #166534; }
        .status-pending { background: #fef3c7; color: #d97706; }
        .status-active { background: #dbeafe; color: #1e40af; }
        .status-inactive { background: #f3e8ff; color: #7c3aed; }

        .role-badge {
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .role-student { background: #dbeafe; color: #1e40af; }
        .role-teacher { background: #f3e8ff; color: #7c3aed; }
        .role-admin { background: #fef3c7; color: #d97706; }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: #1a472a;
            color: white;
        }

        .btn-primary:hover {
            background: #0f2d1a;
        }

        .btn-sm {
            padding: 0.35rem 0.75rem;
            font-size: 0.8rem;
        }

        select {
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            background: white;
            margin-right: 0.5rem;
        }

        .user-tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .user-tab {
            padding: 0.75rem 1.5rem;
            background: none;
            border: none;
            cursor: pointer;
            font-weight: 500;
            color: #64748b;
            border-bottom: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .user-tab.active {
            color: #1a472a;
            border-bottom-color: #1a472a;
        }

        .user-tab:hover {
            color: #1a472a;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <div class="logo-icon">MA</div>
                <div>
                    <h1>Millennium <span>Academy</span></h1>
                    <p>Admin Portal</p>
                </div>
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="active">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
                <a href="#">
                    <i class="fas fa-users"></i>
                    User Management
                </a>
                <a href="#">
                    <i class="fas fa-book"></i>
                    Subjects
                </a>
                <a href="#">
                    <i class="fas fa-credit-card"></i>
                    Payments
                </a>
                <a href="#">
                    <i class="fas fa-chart-bar"></i>
                    Reports
                </a>
                <form method="POST" action="{{ route('logout') }}" style="margin-top: 2rem;">
                    @csrf
                    <button type="submit" style="background: #dc2626; color: white; padding: 0.85rem 1rem; border: none; border-radius: 10px; cursor: pointer; width: 100%; text-align: left; display: flex; align-items: center; gap: 12px;">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </button>
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <h1>Admin Dashboard</h1>
                <div style="display: flex; align-items: center; gap: 15px;">
                    <div style="background: white; padding: 0.75rem 1.5rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                        <strong>{{ auth()->user()->name }}</strong>
                        <div style="font-size: 0.85rem; color: #64748b;">Administrator</div>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <!-- Statistics -->
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total Students</h3>
                    <div class="stat-number">{{ $stats['total_students'] }}</div>
                </div>
                <div class="stat-card">
                    <h3>Total Teachers</h3>
                    <div class="stat-number">{{ $stats['total_teachers'] }}</div>
                </div>
                <div class="stat-card">
                    <h3>Total Admins</h3>
                    <div class="stat-number">{{ $stats['total_admins'] }}</div>
                </div>
                <div class="stat-card">
                    <h3>Pending Payments</h3>
                    <div class="stat-number">{{ $stats['pending_payments'] }}</div>
                </div>
            </div>

            <!-- User Management with Tabs -->
            <div class="card">
                <h2>User Management</h2>

                <div class="user-tabs">
                    <button class="user-tab active" onclick="showTab('students')">Students ({{ $stats['total_students'] }})</button>
                    <button class="user-tab" onclick="showTab('teachers')">Teachers ({{ $stats['total_teachers'] }})</button>
                    <button class="user-tab" onclick="showTab('admins')">Admins ({{ $stats['total_admins'] }})</button>
                </div>

                <!-- Students Tab -->
                <div id="students" class="tab-content active">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Grade</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->grade ?? 'N/A' }}</td>
                                <td>
                                    <span class="status-badge status-{{ $user->status }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('admin.users.update', $user) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()">
                                            <option value="paid" {{ $user->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="pending" {{ $user->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Teachers Tab -->
                <div id="teachers" class="tab-content">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teachers as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="status-badge status-{{ $user->status }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('admin.users.update', $user) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()">
                                            <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Admins Tab -->
                <div id="admins" class="tab-content">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admins as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="status-badge status-{{ $user->status }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('admin.users.update', $user) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()">
                                            <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Enrollment & Payments -->
            <div class="card">
                <h2>Enrollments & Payments</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Subject</th>
                            <th>Payment Status</th>
                            <th>Enrollment Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enrollments as $enrollment)
                        <tr>
                            <td>{{ $enrollment->user->name }}</td>
                            <td>{{ $enrollment->subject->title }}</td>
                            <td>
                                <span class="status-badge status-{{ $enrollment->payment_status }}">
                                    {{ ucfirst($enrollment->payment_status) }}
                                </span>
                            </td>
                            <td>{{ $enrollment->created_at->format('M d, Y') }}</td>
                            <td>
                                <form action="{{ route('admin.payments.update', $enrollment) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <select name="payment_status" onchange="this.form.submit()">
                                        <option value="paid" {{ $enrollment->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="pending" {{ $enrollment->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="failed" {{ $enrollment->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });

            // Remove active class from all tabs
            document.querySelectorAll('.user-tab').forEach(tab => {
                tab.classList.remove('active');
            });

            // Show selected tab content
            document.getElementById(tabName).classList.add('active');

            // Activate selected tab
            event.target.classList.add('active');
        }

        console.log('Admin dashboard loaded');
    </script>
</body>
</html>
