<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
  margin: 0;
  font-family: Arial, sans-serif;
  background-color: #f9f9f9;
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #202020;
  color: white;
  padding: 10px 20px;
}

.logo {
  display: flex;
  align-items: center;
}

.logo img {
  width: 40px;
  margin-right: 10px;
  margin-left: 50px;
}

.search-bar {
  display: flex;
  align-items: center;
}

.search-bar input {
  width: 250px;
  padding: 8px;
  border: none;
  border-radius: 2px;
}

.search-bar button {
  margin-left: 8px;
  padding: 8px 12px;
  background-color: #ff0000;
  border: none;
  color: white;
  cursor: pointer;
}

.main-content {
  display: flex;
  padding: 20px;
}

.video-player {
  flex: 2;
  margin-right: 20px;
}

.video-player iframe {
  width: 100%;
  height: 400px;
  border-radius: 8px;
}

/* ========== Base Video List Styles ========== */
.video-list {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

/* Video item */
.video-item {
  display: flex;
  align-items: center;
  cursor: pointer;
  background-color: #fff;
  padding: 10px;
  border-radius: 5px;
  transition: 0.3s;
}

.video-item:hover {
  background-color: #ececec;
}

.video-item img {
  width: 120px;
  height: 70px;
  border-radius: 4px;
  margin-right: 10px;
}

.video-item h4 {
  font-size: 14px;
  margin: 0;
}

/* ========== Responsive Layouts ========== */

/* Tablets and small laptops */
@media (max-width: 992px) {
  .main-content {
    flex-direction: column;
  }

  .video-player iframe {
    height: 350px;
  }

  .video-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 15px;
    margin-top: 20px;
  }

  .video-item {
    flex-direction: column;
    align-items: flex-start;
  }

  .video-item img {
    width: 100%;
    height: auto;
    margin-bottom: 8px;
  }

  .video-item h4 {
    font-size: 16px;
  }
}

/* Mobile phones (<= 768px) */
@media (max-width: 768px) {
  .header {
    flex-direction: column;
    align-items: flex-start;
  }

  .logo {
    margin-bottom: 10px;
  }

  .search-bar {
    width: 100%;
    justify-content: center;
  }

  .search-bar input {
    width: 80%;
  }

  .main-content {
    flex-direction: column;
    padding: 10px;
  }

  .video-player iframe {
    height: 250px;
  }

  /* 2-column grid for mobile */
  .video-list {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
  }

  .video-item {
    flex-direction: column;
    align-items: flex-start;
    width: 100%;
  }

  .video-item img {
    width: 100%;
    height: auto;
    margin-bottom: 8px;
  }

  .video-item h4 {
    font-size: 14px;
  }
}

/* Very small screens (<= 480px) */
@media (max-width: 480px) {
  .video-list {
    grid-template-columns: 1fr;
  }

  .video-player iframe {
    height: 200px;
  }
}

.user-info {
        display: flex;
        align-items: center;
        gap: 15px;
        color:white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

.user-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: orange;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.2rem;
        box-shadow: 0 4px 8px rgba(26, 71, 42, 0.3);
    }

    .video-wrapper {
  position: relative;
  width: 100%;
  padding-top: 56.25%; /* 16:9 ratio (9/16 * 100%) */
  background: #000;
  border-radius: 8px;
  overflow: hidden;
}

.video-wrapper video {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 8px;
}

</style>



</head>
<body>
  <header class="header">
    <div class="logo">
        <a href="{{route('student.dashboard')}}"><i class="fas fa-home" style="font-size:30px; color:orange;"></i></a>
        <img src="https://www.svgrepo.com/show/13671/youtube.svg" alt="Logo">
      <h3>{{$subject}} Video Clone</h3>
    </div>
     <div class="user-info">
            <div class="user-avatar">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div>
                <div><strong style="color:orange;">{{ auth()->user()->name }}</strong></div>
                <div style="font-size: 0.85rem; color: #64748b;">Student ID: STU-{{ substr(auth()->user()->id, 0, 6) }}</div>
            </div>
        </div>
    </div>
  </header>

  <main class="main-content">
    <section class="video-player">
     <div class="video-wrapper">
    <video 
    id="mainVideo" 
    controls 
    controlsList="nodownload" 
    oncontextmenu="return false"
  >
    <source src="" type="video/mp4">
  </video>
</div>
    
    <h3 id="videoTitle" style="background:orange; text-align:center;">Sample {{$subject}} Video Title</h3>
    </section>

    <aside class="video-list" id="videoList"></aside>
  </main>

  <script>

const subject = "{{ $subject }}";

const videoList = document.getElementById("videoList");
const mainVideo = document.getElementById("mainVideo");
const videoTitle = document.getElementById("videoTitle");
const searchInput = document.getElementById("searchInput");
const searchBtn = document.getElementById("searchBtn");
 

let videos = [];

function loadVideos(list) {
  videoList.innerHTML = "";
  list.forEach(video => {
    const div = document.createElement("div");
    div.classList.add("video-item");
    div.innerHTML = `
      <img src="${video.thumbnail}" alt="">
      <h4>${video.title}<br><small style='color:orange;'><i class='fas fa-clock'></i> ${video.created_at}</small></h4>
    `;
    div.onclick = () => {
      mainVideo.src = video.url;
      videoTitle.textContent = video.title;
    };
    videoList.appendChild(div);
  });
}

document.addEventListener('contextmenu', event => event.preventDefault());
// Fetch videos from Laravel
fetch(`/videosGet/${subject}`)
  .then(res => res.json())
  .then(data => {
    videos = data;
    loadVideos(videos);
  });

// Search filter
searchBtn.onclick = () => {
  const query = searchInput.value.toLowerCase();
  const filtered = videos.filter(v => v.title.toLowerCase().includes(query));
  loadVideos(filtered);
};
</script>

</body>
</html>
