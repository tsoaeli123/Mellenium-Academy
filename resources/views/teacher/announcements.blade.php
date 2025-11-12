<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Teacher Dashboard - Restart Academy</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<style>
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: 'Inter', sans-serif;
  }

  body {
    background: #f8f9fc;
    color: #333;
    display: flex;
    min-height: 100vh;
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
  /* Sidebar */
 

  .search-bar {
    display: flex;
    align-items: center;
    background: white;
    border-radius: 6px;
    overflow: hidden;
    border: 1px solid #ccc;
    margin-top: 10px;
  }

  .search-bar input {
    border: none;
    outline: none;
    padding: 10px;
    width: 250px;
  }

  .search-bar button {
    background: darkgreen;
    color: white;
    border: none;
    padding: 10px 15px;
    cursor: pointer;
  }

  /* Announcement Form */
  .announcement-form {
    background: white;
    padding: 20px;
    margin-top: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  }

  .announcement-form h2 {
    margin-bottom: 15px;
  }

  .announcement-form input, 
  .announcement-form textarea,
  .announcement-form select {
    width: 100%;
    padding: 10px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 6px;
  }

  .announcement-form button {
    background: green;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.3s;
  }

  .announcement-form button:hover {
    background: #004d00;
  }

  /* Announcements */
  .announcement-list {
    margin-top: 30px;
  }

  .announcement-card {
    background: white;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 15px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
    position: relative;
  }

  .announcement-card.pinned {
    border-left: 6px solid gold;
    background: #fffbea;
  }

  .announcement-card h5 {
    margin-bottom: 5px;
    font-size: 18px;
  }

  .announcement-meta {
    font-size: 13px;
    color: #777;
    margin-bottom: 10px;
  }

  .announcement-text {
    font-size: 15px;
    color: #333;
  }

  .attachments {
    margin-top: 10px;
  }

  .attachments button,
  .attachments a {
    background: #f1f1f1;
    border: none;
    border-radius: 5px;
    padding: 6px 10px;
    margin-right: 8px;
    cursor: pointer;
    color: #333;
    text-decoration: none;
  }

  .actions {
    position: absolute;
    top: 10px;
    right: 10px;
    display: flex;
    gap: 8px;
  }

  .actions i {
    cursor: pointer;
    font-size: 16px;
    color: #444;
    transition: 0.2s;
  }

  .actions i:hover {
    color: darkgreen;
  }

  @media (max-width: 768px) {
    nav {
      width: 70px;
      padding: 15px;
    }
    nav span { 
        display: none; 
    }
    .main-content { 
        margin-left: 70px;
         padding: 15px; 
        }
    .search-bar input { 
        width: 150px; 
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
            <p>Teacher Portal</p>
        </div>
    </div>

    <div class="sidebar-nav">
        <a href="{{ route('teacher.dashboard') }}" class="active">
            <i class="fas fa-home"></i>
            Dashboard
        </a>
        <a href="{{route('teacher.videoUpload')}}" class="action-btn">
                <div class="action-icon">
                    <i class="fas fa-video"></i>
                </div>
                <div>Upload Video</div>
            </a>
        <a href="{{route('teacher.documentUpload')}}" class="action-btn">
                <div class="action-icon">
                    <i class="fas fa-file"></i>
                </div>
                <div>Upload Documents</div>
            </a>
        <a href="#">
            <i class="fas fa-calendar-alt"></i>
            Schedule
        </a>

        <a href="#">
            <i class="fas fa-chart-line"></i>
            Progress
        </a>
        <a href="#">
            <i class="fas fa-credit-card"></i>
            Payments
        </a>
        <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout">
            <i class="fas fa-sign-out-alt"></i>
            Logout
        </button>
    </form>
        <a href="#">
            <i class="fas fa-headset"></i>
            Support
        </a>
    </div>


</div>


<!-- Main Content -->
<div class="main-content">
  <header>
    <h1>Teacher Announcements</h1>
    <div class="search-bar">
      <input type="text" id="searchInput" placeholder="Search announcements..." />
      <button onclick="searchAnnouncements()"><i class="fa-solid fa-search"></i></button>
    </div>
  </header>

  <!-- Post New Announcement -->
  <section class="announcement-form">
    <h2>Post New Announcement</h2>
    @if(session('success'))
       <h5 class="alert alert-success" style="background:#fff; color:green;">{{session('success')}}</h5>
       @endif

    <form class="form-control"  action="{{route('teacher.announcement')}}" method="POST" enctype="multipart/form-data">
        @csrf
      <input type="text" name="title" placeholder="Title" required />
      <textarea name="message" rows="4" placeholder="Write your announcement..."></textarea>
      <select name="subject" id="subject">
          <option value="">-- Select Subject --</option>
          <option value="All">All</option>
           @foreach($subject as $cs)
            <option value="{{$cs->title}}">{{$cs->title}}</option>
            
           @endforeach
        </select>
      <input type="file" name="file" />
      <label><input type="checkbox" name="pinned" /> Pin this announcement</label><br><br>
      <button type="submit"><i class="fa-solid fa-paper-plane"></i> Post Announcement</button>
    </form>
  </section>

  <h3 style="margin-top:30px;">Recent Announcements</h3>
  <div id="announcementList" class="announcement-list">

 @foreach($announcements as $post)
    
    <div class="announcement-card pinned">
      <h5>📌 {{$post->title}}</h5>
      <div class="announcement-meta">Posted by Mr/Mrs. {{ Auth::user()->name }} · {{$post->created_at->format('l, jS, F Y')}} <span class="badge-class badge-all">
       @if($post->subject != "All")
       
      {{$post->subject}} Students
      
       @else
      
      All Students
      
      @endif
      </span></div>
     
      <div class="announcement-text">{{$post->message}}.</div>
      <div class="attachments mt-2">
        <a target="_blank" href="/storage/{{$post->file_path}}" class="btn btn-primary"><i class="fas fa-eye"></i> View Document</a>
      </div>
      <div class="attachments mt-2">
        <form action="{{route('teacher.delete',$post->id )}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Announcement?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Delete Announcement</button>
    </form>
    </div>
    </div>
   
    @endforeach


    

    <p class="text-muted">No more announcements.</p>




  </div>
</div>


</body>
</html>
