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
        .status-unpaid { background: #fee2e2; color: #dc2626; }

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

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }

        .btn-danger {
            background: #dc2626;
            color: white;
        }

        .btn-danger:hover {
            background: #b91c1c;
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

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .pending-badge {
            background: #dc2626;
            color: white;
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 0.7rem;
            margin-left: 5px;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.8);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 2rem;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
        }

        .close-modal {
            position: absolute;
            right: 1rem;
            top: 1rem;
            font-size: 1.5rem;
            cursor: pointer;
            color: #64748b;
            background: none;
            border: none;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .close-modal:hover {
            background: #f1f5f9;
            color: #1e293b;
        }

        .screenshot-image {
            width: 100%;
            max-height: 400px;
            object-fit: contain;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .screenshot-info {
            margin-top: 1rem;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 8px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .info-label {
            font-weight: 600;
            color: #374151;
        }

        .no-screenshot {
            text-align: center;
            padding: 2rem;
            color: #64748b;
            background: #f8fafc;
            border-radius: 8px;
            border: 2px dashed #d1d5db;
        }

        /* Email notification badge */
        .email-badge {
            background: #059669;
            color: white;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.7rem;
            margin-left: 5px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
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
                    @if(str_contains(session('success'), 'Email notification sent'))
                        <span class="email-badge"><i class="fas fa-envelope"></i> Email Sent</span>
                    @endif
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
                <!-- Add these new stat cards for teacher uploads -->
                <div class="stat-card">
                    <h3>Pending Videos</h3>
                    <div class="stat-number">{{ $stats['pending_videos'] ?? 0 }}</div>
                </div>
                <div class="stat-card">
                    <h3>Pending Documents</h3>
                    <div class="stat-number">{{ $stats['pending_documents'] ?? 0 }}</div>
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
                                <th>Payment Status</th>
                                <th>Payment Screenshot</th>
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
                                    @if($user->payment_screenshot)
                                        <button class="btn btn-secondary btn-sm"
                                                onclick="viewScreenshot('{{ $user->name }}', '{{ $user->payment_screenshot }}', '{{ $user->status }}', '{{ $user->created_at->format('M d, Y') }}')">
                                            <i class="fas fa-eye"></i> View Screenshot
                                        </button>
                                    @else
                                        <span class="text-gray-500 text-sm">No screenshot</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('admin.users.update', $user) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="confirmStatusChange(this, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}')">
                                            <option value="paid" {{ $user->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="pending" {{ $user->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="unpaid" {{ $user->status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
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

            <!-- Payment Screenshots Modal -->
            <div id="screenshotModal" class="modal">
                <div class="modal-content">
                    <button class="close-modal" onclick="closeScreenshotModal()">&times;</button>
                    <h2 style="margin-bottom: 1rem; color: #1a472a;">Payment Screenshot</h2>

                    <div id="screenshotContent">
                        <!-- Content will be loaded here -->
                    </div>
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
                                    <select name="payment_status" onchange="confirmPaymentStatusChange(this, '{{ $enrollment->user->name }}', '{{ $enrollment->user->email }}')">
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

            <!-- Teacher Uploads Management -->
            <div class="card">
                <h2>Teacher Uploads Management</h2>

                <div class="user-tabs">
                    <button class="user-tab active" onclick="showUploadTab('videos')">
                        Videos ({{ $videos->count() }})
                        @if(($stats['pending_videos'] ?? 0) > 0)
                        <span class="pending-badge">{{ $stats['pending_videos'] }} pending</span>
                        @endif
                    </button>
                    <button class="user-tab" onclick="showUploadTab('documents')">
                        Documents ({{ $documents->count() }})
                        @if(($stats['pending_documents'] ?? 0) > 0)
                        <span class="pending-badge">{{ $stats['pending_documents'] }} pending</span>
                        @endif
                    </button>
                </div>

                <!-- Videos Tab -->
                <div id="videos" class="tab-content active">
                    @if($videos->count() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Subject</th>
                                <th>Teacher</th>
                                <th>Upload Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($videos as $video)
                            <tr>
                                <td>{{ $video->title }}</td>
                                <td>{{ $video->subject }}</td>
                                <td>{{ $video->user->name ?? 'Unknown' }}</td>
                                <td>{{ $video->created_at->format('M d, Y') }}</td>
                                <td>
                                    <span class="status-badge {{ $video->approved ? 'status-active' : 'status-pending' }}">
                                        {{ $video->approved ? 'Approved' : 'Pending Approval' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        @if(!$video->approved)
                                        <form action="{{ route('admin.videos.approve', $video) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                        </form>
                                        @endif

                                        <form action="{{ route('admin.videos.delete', $video) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this video?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>

                                        <a href="{{ Storage::url($video->path) }}"
                                           target="_blank"
                                           class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p style="text-align: center; padding: 2rem; color: #64748b;">
                        No videos uploaded yet.
                    </p>
                    @endif
                </div>

                <!-- Documents Tab -->
                <div id="documents" class="tab-content">
                    @if($documents->count() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Subject</th>
                                <th>Teacher</th>
                                <th>Filename</th>
                                <th>Upload Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($documents as $document)
                            <tr>
                                <td>{{ $document->title }}</td>
                                <td>{{ $document->subject }}</td>
                                <td>{{ $document->user->name ?? 'Unknown' }}</td>
                                <td>{{ $document->filename }}</td>
                                <td>{{ $document->created_at->format('M d, Y') }}</td>
                                <td>
                                    <span class="status-badge {{ $document->approved ? 'status-active' : 'status-pending' }}">
                                        {{ $document->approved ? 'Approved' : 'Pending Approval' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        @if(!$document->approved)
                                        <form action="{{ route('admin.documents.approve', $document) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                        </form>
                                        @endif

                                        <form action="{{ route('admin.documents.delete', $document) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this document?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>

                                        <a href="{{ Storage::url($document->path) }}"
                                           target="_blank"
                                           class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p style="text-align: center; padding: 2rem; color: #64748b;">
                        No documents uploaded yet.
                    </p>
                    @endif
                </div>
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

        function showUploadTab(tabName) {
            // Hide all upload tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });

            // Remove active class from all upload tabs
            document.querySelectorAll('.user-tab').forEach(tab => {
                tab.classList.remove('active');
            });

            // Show selected tab content
            document.getElementById(tabName).classList.add('active');

            // Activate selected tab
            event.target.classList.add('active');
        }

        // Simple confirmation function for student status changes
        function confirmStatusChange(selectElement, userName, userEmail, userRole) {
            const newStatus = selectElement.value;

            // Only show email confirmation for students with payment status changes
            if (userRole === 'student' && ['paid', 'pending', 'unpaid'].includes(newStatus)) {
                if (confirm(`Change status for ${userName} to "${newStatus}"?\n\n📧 Email will be sent to: ${userEmail}`)) {
                    selectElement.form.submit();
                }
            } else {
                // For non-student or non-payment status changes, submit immediately
                selectElement.form.submit();
            }
        }

        // Simple confirmation function for payment status changes
        function confirmPaymentStatusChange(selectElement, studentName, studentEmail) {
            const newStatus = selectElement.value;

            if (confirm(`Change payment status for ${studentName} to "${newStatus}"?\n\n📧 Email will be sent to: ${studentEmail}`)) {
                selectElement.form.submit();
            }
        }

        // Payment Screenshot Modal Functions
        function viewScreenshot(studentName, screenshotPath, status, registrationDate) {
            const modal = document.getElementById('screenshotModal');
            const content = document.getElementById('screenshotContent');

            // Construct the full URL to the screenshot
            const screenshotUrl = `{{ Storage::url('') }}${screenshotPath}`;

            content.innerHTML = `
                <div class="screenshot-info">
                    <div class="info-row">
                        <span class="info-label">Student Name:</span>
                        <span>${studentName}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Payment Status:</span>
                        <span class="status-badge status-${status}">${status.charAt(0).toUpperCase() + status.slice(1)}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Registration Date:</span>
                        <span>${registrationDate}</span>
                    </div>
                </div>

                <div style="margin-top: 1.5rem;">
                    ${screenshotPath ?
                        `<img src="${screenshotUrl}" alt="Payment Screenshot" class="screenshot-image" onerror="this.style.display='none'; document.getElementById('noScreenshot').style.display='block';">
                         <div id="noScreenshot" class="no-screenshot" style="display: none;">
                             <i class="fas fa-exclamation-triangle" style="font-size: 2rem; margin-bottom: 1rem;"></i>
                             <p>Unable to load payment screenshot. The file may have been moved or deleted.</p>
                         </div>`
                        :
                        `<div class="no-screenshot">
                             <i class="fas fa-receipt" style="font-size: 2rem; margin-bottom: 1rem;"></i>
                             <p>No payment screenshot uploaded by this student.</p>
                         </div>`
                    }
                </div>

                ${screenshotPath ? `
                <div style="margin-top: 1rem; text-align: center;">
                    <a href="${screenshotUrl}" target="_blank" class="btn btn-primary">
                        <i class="fas fa-external-link-alt"></i> Open in New Tab
                    </a>
                </div>
                ` : ''}
            `;

            modal.style.display = 'block';
        }

        function closeScreenshotModal() {
            document.getElementById('screenshotModal').style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('screenshotModal');
            if (event.target === modal) {
                closeScreenshotModal();
            }
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeScreenshotModal();
            }
        });

        // Auto-refresh the page when a success message is shown (after form submission)
        document.addEventListener('DOMContentLoaded', function() {
            // If there's a success message, it means a form was submitted
            const successAlert = document.querySelector('.alert-success');
            if (successAlert) {
                // Scroll to top to see the success message
                window.scrollTo(0, 0);
            }
        });

        console.log('Admin dashboard loaded');
    </script>
</body>
</html>
