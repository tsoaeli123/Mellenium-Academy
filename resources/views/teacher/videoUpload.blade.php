<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Teacher Dashboard - Video Upload</title>
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


.upload-container {
      background: #fff;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      width: 600px;
      text-align: center;
    }

    .upload-container h2 {
      margin-bottom: 1.5rem;
      color: #333;
    }

    /* ===== Title Input ===== */
    .input-group {
      margin-bottom: 1.5rem;
      text-align: left;
    }

    .input-group label {
      font-weight: 600;
      color: #555;
      display: block;
      margin-bottom: 0.5rem;
    }

    .input-group input[type="text"] {
      width: 100%;
      padding: 10px;
      border: 2px solid #ccc;
      border-radius: 6px;
      font-size: 1rem;
      transition: border-color 0.2s;
    }

    .input-group input[type="text"]:focus {
      border-color: #007bff;
      outline: none;
    }
    
    .input-group select{
          border-color: #007bff;
          width: 100%;  
          padding: 10px;
      border: 2px solid #ccc;
      border-radius: 6px;
      font-size: 1rem;
      transition: border-color 0.2s;    

    }
    /* ===== Drag & Drop Zone ===== */
    .drop-zone {
      border: 2px dashed #007bff;
      border-radius: 10px;
      padding: 2rem;
      background: #f9f9f9;
      cursor: pointer;
      transition: background 0.3s, border-color 0.3s;
    }

    .drop-zone.dragover {
      background: #e3f2fd;
      border-color: #0056b3;
    }

    .drop-zone p {
      color: #555;
      font-size: 1rem;
    }

    .drop-zone input {
      display: none;
    }

    /* ===== Video Preview ===== */
    .preview {
      margin-top: 1.5rem;
      display: none;
      text-align: left;

    }

    video {
      width: 100%;
      height: 200px;
      border-radius: 8px;
      margin-top: 0.5rem;
    }

    /* ===== Progress Bar ===== */
    .progress-container {
      display: none;
      margin-top: 1rem;
      text-align: left;
    }

    .progress-bar {
      height: 10px;
      width: 0%;
      background: #007bff;
      border-radius: 5px;
      transition: width 0.3s;
    }

    /* ===== Submit Button ===== */
    button {
      margin-top: 1.5rem;
      padding: 10px 20px;
      background: #007bff;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 1rem;
      transition: background 0.3s;
    }

    button:hover {
      background: #0056b3;
    }

    progress {
  width: 100%;
  height: 20px;
  border-radius: 10px;
  overflow: hidden;
}
progress::-webkit-progress-bar {
  background-color: #eee;
  border-radius: 10px;
}
progress::-webkit-progress-value {
  background-color: #007bff;
  border-radius: 10px;
  transition: width 0.3s ease;
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
        <a href="{{route('teacher.dashboard')}}" class="active">
            <i class="fas fa-home"></i>
            Dashboard
        </a>
        <a href="{{route('teacher.documentUpload')}}">
            <i class="fas fa-file"></i>
            Upload Documents
        </a>
        <a href="#">
            <i class="fas fa-calendar-plus"></i>
            Live Sessions
        </a>
        <a href="{{route('teacher.announcements')}}">
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
         <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout">
            <i class="fas fa-sign-out-alt"></i>
            Logout
        </button>
    </form>
        <a href="#">
            <i class="fas fa-cog"></i>
            Settings
        </a>
    </div>

    <form method="POST" action="{{ route('logout') }}">
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
        <h1><i class="fas fa-video"></i> Upload Videos</h1>
        <div class="user-info">
            <div class="user-avatar">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div>
                <div><strong>{{ auth()->user()->name }}</strong></div>
                <div style="font-size: 0.85rem; color: #64748b;">Teacher</div>
            </div>
        </div>
    </div>

    <!-- Welcome Card -->
    <div class="card welcome-card">
        <div class="welcome-icon">
            <i class="fas fa-chalkboard-teacher"></i>
        </div>
        <div>
            <h2>This Platform Allow Teachers To Upload Video Lesson For Students!</h2>
            <p><i class="fas fa-arrow-right"></i> Manage your classes, upload videos, and connect with your students.</p>
        </div>
    </div>

    

    <!-- Video Uploads -->
    <div class="card">
       
        <div class="quick-actions">
            
        <div class="upload-container">
    <h2><i class="fas fa-video"></i>Upload Your Video</h2>
     @if(session('success'))
       <h5 style="font-weight:bold; color:darkgreen;">{{session('success')}}</h5>
       @endif
    <form id="videoUploadForm" enctype="multipart/form-data">
     @csrf

      <div id="video-message" style="color:darkgreen; font-weight:bold;"></div>
      <div id="video-error" style="color:red; font-weight:bold;"></div>
       <div class="input-group">
       
        <label for="subject">Subject</label>
        <select name="subject" id="subject">
          <option value="">-- Select Subject --</option>
           @foreach($course as $cs)
            <option value="{{$cs->title}}">{{$cs->title}}</option>
            
           @endforeach
        </select>
        
    </div>

      <div class="input-group">
        <label for="videoTitle">Video Title/Topic</label>
        <input type="text" id="videoTitle" name="title" placeholder="Enter video title...">
           
    </div>

      <!-- Drag & Drop Zone -->
      <div class="drop-zone" id="dropZone">
        <p>Drag & drop a video file here or <strong>click to upload</strong></p>
        <input type="file" id="videoFile" name="video" accept="video/*">
      </div>

      <!-- Video Preview -->
      <div class="preview" id="preview">
        <label>🎥 Video Preview:</label>
         <video id="videoPreview" controls preload="metadata"></video>

      </div>

      <!-- Progress Bar -->
      <div class="progress-container">
        
        <progress id="progressBar" value="0" max="100"></progress>

      </div>

      <!-- Submit -->
      <button type="submit"><i class="fas fa-upload"></i> Upload Video</button>
    </form>
  </div>



        </div>
    </div>

    <!-- Recent Activity -->
    <div class="card">
        <h3 style="color:darkgreen;">Recent Activity</h3>
        
        @foreach($videos as $video)
        <div style="margin-top: 1rem;">
            <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem 0; border-bottom: 1px solid #f1f5f9;">
                
                <div>
                    <div style="font-weight: 600;">{{$video->subject}} - video uploaded</div>
                    <div style="font-size: 0.85rem; color: #64748b;"> <i style="color:red;" class="fas fa-video"></i> {{$video->title}} - {{$video->created_at->format('l, jS, F Y')}}</div>
                  </div>
                    <div style="font-size: 0.85rem; color: #64748b;">
                    <form action="{{route('teacher.destroy', $video->id)}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this video?');">
                    @csrf
                   @method('DELETE')
                  <button type="submit" style="background:red;"><i class="fas fa-trash"></i> Delete</button>
               </form>
                </div>
                
              
                </div>
            </div>
             @endforeach
          
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


//Upload video files

    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('videoFile');
    const videoPreview = document.getElementById('videoPreview');
    const previewContainer = document.getElementById('preview');
    const progressBar = document.getElementById('progressBar');
    const progressContainer = document.querySelector('.progress-container');
    const form = document.getElementById('videoUploadForm');

    dropZone.addEventListener('dragover', (e) => {
      e.preventDefault();
      dropZone.classList.add('dragover');
    });

    dropZone.addEventListener('dragleave', () => {
      dropZone.classList.remove('dragover');
    });

    dropZone.addEventListener('drop', e => {
      e.preventDefault();
      dropZone.classList.remove('dragover');
      const file = e.dataTransfer.files[0];
      if (file && file.type.startsWith('video/')) {
        fileInput.files = e.dataTransfer.files;
        showPreview(file);
      }
      else {
         document.getElementById('video-error').innerHTML='Please drop a valid video file!';
        
      }
    });

     // Trigger file input when clicking drop zone
    dropZone.addEventListener('click', () => fileInput.click());


     function showPreview(file) {
        const videoPreview = document.getElementById('videoPreview');
        const previewContainer = document.getElementById('preview');
        const videoError = document.getElementById('video-error');

        videoError.innerText = '';

        if (!file.type.startsWith('video/')) {
            videoError.innerText = 'Please select a valid video file!';
            previewContainer.style.display = 'none';
            return;
        }

        const url = URL.createObjectURL(file);
        videoPreview.src = url;
        videoPreview.load();
        previewContainer.style.display = 'block';
    }

     // Preview when selecting file manually
    fileInput.addEventListener('change', () => {
      const file = fileInput.files[0];
      if (file) showPreview(file);
    });

let chunkSize = 5 * 1024 * 1024; // 5 MB chunks

// Chunked upload function with live progress updates
async function uploadVideo(file, title, subject) {
    const totalChunks = Math.ceil(file.size / chunkSize);
    progressContainer.style.display = 'block'; // 👈 show progress bar
    progressBar.value = 0;

    for (let chunkIndex = 0; chunkIndex < totalChunks; chunkIndex++) {
        const start = chunkIndex * chunkSize;
        const end = Math.min(start + chunkSize, file.size);
        const chunk = file.slice(start, end);

        const formData = new FormData();
        formData.append('video', chunk);
        formData.append('file_name', file.name);
        formData.append('chunk_index', chunkIndex);
        formData.append('total_chunks', totalChunks);
        formData.append('title', title);
        formData.append('subject', subject);

        try {
            const response = await fetch('{{ route("videos.store") }}', {
                method: 'POST',
                body: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });

            if (!response.ok) throw new Error('Chunk upload failed');

            // ✅ Update progress smoothly
            const percent = ((chunkIndex + 1) / totalChunks) * 100;
            progressBar.value = percent;

        } catch (error) {
            document.getElementById('video-error').innerText = `Upload failed: ${error.message}`;
            progressContainer.style.display = 'none';
            return;
        }
    }

    document.getElementById('video-message').innerText = '✅ Video uploaded successfully!';
    progressBar.value = 100;
    setTimeout(() => {
        progressContainer.style.display = 'none';
        progressBar.value = 0;
    }, 2000);

    form.reset();
    previewContainer.style.display = 'none';
}

// Handle form submit
form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const file = fileInput.files[0];
    const title = document.getElementById('videoTitle').value.trim();
    const subject = document.getElementById('subject').value.trim();

    document.getElementById('video-error').innerText = '';
    document.getElementById('video-message').innerText = '';

    if (!file) {
        document.getElementById('video-error').innerText = 'Please select a video file first!';
        return;
    }

    await uploadVideo(file, title, subject);
});



</script>

</body>
</html>
