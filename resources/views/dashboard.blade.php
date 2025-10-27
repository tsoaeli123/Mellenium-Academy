<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Teacher Dashboard - Restart Academy</title>
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

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin: 1.5rem 0;
    }

    .stat-card {
        text-align: center;
        padding: 1.5rem;
        background: #f8fafc;
        border-radius: 12px;
        border-left: 4px solid #f1c40f;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: #1a472a;
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 0.9rem;
        color: #64748b;
        font-weight: 500;
    }

    /* Quick Actions */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 1.5rem 1rem;
        background: white;
        border-radius: 12px;
        text-decoration: none;
        color: #1a472a;
        transition: all 0.3s ease;
        border: 1px solid #f1f5f9;
        text-align: center;
    }

    .action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        color: #f1c40f;
        border-color: #f1c40f;
    }

    .action-icon {
        font-size: 2rem;
        margin-bottom: 0.75rem;
        color: #1a472a;
    }

    .action-btn:hover .action-icon {
        color: #f1c40f;
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

    button.primary {
        background:#1a472a;
        color:white;
        padding:0.85rem 1.5rem;
        border-radius:10px;
        font-weight:600;
        border:none;
        cursor:pointer;
        transition: all 0.3s ease;
    }

    button.primary:hover {
        background:#0f2d1a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(26, 71, 42, 0.3);
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

        .stats-grid, .quick-actions {
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
        <div class="logo-icon">RA</div>
        <div class="logo-text">
            <h1>Restart <span>Academy</span></h1>
            <p>Teacher Portal</p>
        </div>
    </div>

    <div class="sidebar-nav">
        <a href="#" class="active">
            <i class="fas fa-home"></i>
            Dashboard
        </a>
        <a href="#">
            <i class="fas fa-video"></i>
            Upload Videos
        </a>
        <a href="#">
            <i class="fas fa-calendar-plus"></i>
            Live Sessions
        </a>
        <a href="#">
            <i class="fas fa-bullhorn"></i>
            Announcements
        </a>
        <a href="#">
            <i class="fas fa-comments"></i>
            Student Chat
        </a>
        <a href="#">
            <i class="fas fa-chart-line"></i>
            Performance
        </a>
        <a href="#">
            <i class="fas fa-cog"></i>
            Settings
        </a>
    </div>

    <form method="POST" action="#">
        @csrf
        <button type="submit" class="logout">
            <i class="fas fa-sign-out-alt"></i>
            Logout
        </button>
    </form>
</div>

<!-- Main Content -->
<div class="main-content">
    <!-- Header -->
    <div class="header">
        <h1>Teacher Dashboard</h1>
        <div class="user-info">
            <div class="user-avatar">
                T
            </div>
            <div>
                <div><strong>Teacher Name</strong></div>
                <div style="font-size: 0.85rem; color: #64748b;">Mathematics Department</div>
            </div>
        </div>
    </div>

    <!-- Welcome Card -->
    <div class="card welcome-card">
        <div class="welcome-icon">
            <i class="fas fa-chalkboard-teacher"></i>
        </div>
        <div>
            <h2>Welcome back, Teacher!</h2>
            <p>Manage your classes, upload content, and connect with your students.</p>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="card">
        <h3>Teaching Overview</h3>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value">24</div>
                <div class="stat-label">Total Students</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">12</div>
                <div class="stat-label">Videos Uploaded</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">8</div>
                <div class="stat-label">Live Sessions</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">15</div>
                <div class="stat-label">Announcements</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card">
        <h3>Quick Actions</h3>
        <div class="quick-actions">
            <a href="#" class="action-btn">
                <div class="action-icon">
                    <i class="fas fa-video"></i>
                </div>
                <div>Upload Video</div>
            </a>
            <a href="#" class="action-btn">
                <div class="action-icon">
                    <i class="fas fa-calendar-plus"></i>
                </div>
                <div>Schedule Live Session</div>
            </a>
            <a href="#" class="action-btn">
                <div class="action-icon">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <div>Post Announcement</div>
            </a>
            <a href="#" class="action-btn">
                <div class="action-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <div>Student Messages</div>
            </a>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="card">
        <h3>Recent Activity</h3>
        <div style="margin-top: 1rem;">
            <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem 0; border-bottom: 1px solid #f1f5f9;">
                <div style="width: 40px; height: 40px; background: rgba(26, 71, 42, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #1a472a;">
                    <i class="fas fa-video"></i>
                </div>
                <div>
                    <div style="font-weight: 600;">New video uploaded</div>
                    <div style="font-size: 0.85rem; color: #64748b;">Algebra Basics - 2 hours ago</div>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem 0; border-bottom: 1px solid #f1f5f9;">
                <div style="width: 40px; height: 40px; background: rgba(241, 196, 15, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #d97706;">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div>
                    <div style="font-weight: 600;">Live session completed</div>
                    <div style="font-size: 0.85rem; color: #64748b;">Calculus Review - 1 day ago</div>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem 0;">
                <div style="width: 40px; height: 40px; background: rgba(74, 222, 128, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #16a34a;">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <div>
                    <div style="font-weight: 600;">Announcement posted</div>
                    <div style="font-size: 0.85rem; color: #64748b;">Exam Schedule - 2 days ago</div>
                </div>
            </div>
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
