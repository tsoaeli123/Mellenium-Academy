<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Live Room {{ $roomId }}</title>
<style>

/* Basic Reset */
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Segoe UI', sans-serif;
        background: #111;
        color: #fff;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        padding: 10px;
    }
    #main {
        flex: 3;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
    }
    
    #video-grid {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 12px;
    margin-top: 20px;
}

#video-grid div {
    background: #1c1c1c;
    border-radius: 10px;
    padding: 6px;
}



    video {
        width: 280px;
        height: 200px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid #444;
        background: #000;
    }
    #controls {
        margin: 15px;
    }
    button {
        background: #333;
        color: #fff;
        border: none;
        padding: 10px 20px;
        margin: 5px;
        border-radius: 6px;
        cursor: pointer;
        transition: 0.2s;
    }
    button:hover {
        background: #4caf50;
    }
    /* Chat sidebar */
    #chat {
        flex: 1;
        background: #1a1a1a;
        display: flex;
        flex-direction: column;
        border-left: 2px solid #333;
    }
    

#chat-messages {
    height: 200px;
    overflow-y: auto;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

    .message {
        background: #2a2a2a;
        margin-bottom: 8px;
        padding: 8px 10px;
        border-radius: 5px;
        text-align: left;
    }
    .message strong {
        color: #4caf50;
    }
    #chat-input {
        display: flex;
        padding: 10px;
        border-top: 1px solid #333;
    }
    #chat-input input {
        flex: 1;
        padding: 8px;
        border: none;
        border-radius: 5px;
        outline: none;
    }
    #chat-input button {
        margin-left: 10px;
        background: #4caf50;
    }
    #leaveBtn {
    background-color: #e53935;
    color: white;
    border: none;
    padding: 8px 14px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
    margin-left: 10px;
    transition: background 0.3s;
}
#leaveBtn:hover {
    background-color: #c62828;
}
#leaveBtn:disabled {
    background-color: #aaa;
    cursor: not-allowed;
}

.system-message {
    text-align: center;
    color: #777;
    font-style: italic;
    margin: 6px 0;
}

#raiseHandBtn {
    background-color: #ffb300;
    color: #000;
    border: none;
    padding: 10px 16px;
    margin: 5px;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s;
}

#raiseHandBtn:hover {
    background-color: #ffca28;
}

#raiseHandBtn.active {
    background-color: #4CAF50;
    color: #fff;
}

#raisedHandsPanel {
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    font-family: sans-serif;
    z-index: 9999;
}

#raisedHandsList li {
    background: #f5f5f5;
    margin: 6px 0;
    padding: 6px 10px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

#raisedHandsList li span {
    font-weight: 600;
}

.hand-icon-small {
    color: #ffb300;
    font-size: 20px;
}

#raisedHandsList li {
    background: #f5f5f5;
    margin: 6px 0;
    padding: 6px 10px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    transition: background 0.2s;
}

#raisedHandsList li:hover {
    background: #e0e0e0;
}


#localVideo{
    width:600px;
    height:450px;
}

@media (max-width: 768px) {
    #video-grid {
        flex-direction: column; /* stack videos vertically */
        gap: 8px;
    }


}

</style>
</head>
<body>
<div id="main">
    <h2>🔴 Live Class Room: {{ $roomId }}</h2>

    <div id="video-grid">
        <video id="localVideo" autoplay muted playsinline></video>
    </div>

    <div id="raisedHandsPanel" style="display:none; position:fixed; top:80px; right:20px; width:220px; background:#fff; border:2px solid #333; border-radius:8px; padding:10px;">
    <h4 style="margin-top:0; text-align:center;">✋ Raised Hands</h4>
    <ul id="raisedHandsList" style="list-style:none; padding:0; margin:0;"></ul>
</div>



    <div id="controls">
        <button id="joinBtn">Join Class Room</button>
        <button id="muteBtn" disabled>Mute</button>
        <button id="cameraBtn" disabled>Stop Camera</button>
        <button id="raiseHandBtn" disabled>✋ Raise Hand</button>
        <button id="shareBtn" disabled>Share Screen</button>
        <button id="endSpeakingBtn" style="display:none; background:#f44336;color:white;padding:6px 12px;border:none;border-radius:5px;margin-left:10px;">🛑 End Speaking</button>
        <button id="leaveBtn" disabled>Leave Class</button>

    </div>
</div>

<div id="participants"></div>


<!-- 💬 Chat Sidebar -->
<div id="chat">
    <div id="chat-messages"></div>
    <div id="typing-indicator" style="padding:5px 10px;color:#aaa;font-size:13px;min-height:20px;"></div>
    <div id="chat-input" style="display:none;">
        <input type="text" id="messageBox" placeholder="Type a message..." />
        <button id="sendBtn">Send</button>
    </div>
</div>


<!-- Pusher JS -->
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>

<!-- Laravel Echo -->
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script>


<script>
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: "{{ env('PUSHER_APP_KEY') }}",
    cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
    forceTLS: true,
    authEndpoint: '/broadcasting/auth',
    auth: {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    }
});


const userId = "{{ Auth::id() }}";
const userName = "{{ Auth::user()->name ?? 'Guest' }}";
const roomId = "{{ $roomId }}";
const userRole = '{{ auth()->user()->role }}';
let liveRoomChannel; // global


const localVideo = document.getElementById('localVideo');
const joinBtn = document.getElementById('joinBtn');
const muteBtn = document.getElementById('muteBtn');
const cameraBtn = document.getElementById('cameraBtn');
const shareBtn = document.getElementById('shareBtn');
const videoGrid = document.getElementById('video-grid');
const peers = {};
let localStream = null;
let audioEnabled = true;
let videoEnabled = true;
let screenStream = null;


// Function to zoom in
function zoomIn(factor = 1.2) {
    localVideo.style.transform = `scale(${factor})`;
}

// Function to reset zoom
function resetZoom() {
    localVideo.style.transform = 'scale(1)';
}

// Example: Zoom in when you click, reset when you click again
let zoomed = false;
localVideo.addEventListener('click', () => {
    if (!zoomed) {
        zoomIn(2.0); // Zoom 150%
        zoomed = true;
    } else {
        resetZoom();
        zoomed = false;
    }
});

// --- Chat elements ---
const chatMessages = document.getElementById('chat-messages');
const messageBox = document.getElementById('messageBox');
const sendBtn = document.getElementById('sendBtn');

function appendMessage(name, text, time = null, self = false) {
    const div = document.createElement('div');
    div.className = 'message';
    div.innerHTML = `
        <strong>${self ? 'You' : name}:</strong> ${text}
        <div style="font-size:11px;color:#888;text-align:right;">${time ?? new Date().toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'})}</div>
    `;
    chatMessages.appendChild(div);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

// --- Join video session ---
async function joinRoom() {

     // 0️⃣ Fetch participants from DB
    const participants = await fetch('/getparticipants')
        .then(res => res.json());

    participants.forEach(user => {
        if (user.id !== userId) {
            addParticipant(user);  // Add to UI
        }
    });

    // Load previous chat messages
    const history = await fetch(`/chat/history/${roomId}`).then(res => res.json());
    history.forEach(msg => appendMessage(msg.user.name, msg.message));

    // Try to access camera + mic
    try {
        localStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
    } catch (err) {
        console.warn('Camera not available, joining with audio only:', err);
        alert('Could not access your camera. You will join with audio only.');
        localStream = await navigator.mediaDevices.getUserMedia({ video: false, audio: true });
        cameraBtn.disabled = true; // disable camera toggle if no video
    }

    // Set local video if available
    if (localStream.getVideoTracks().length > 0) {
        localVideo.srcObject = localStream;
    } else {
        localVideo.style.display = 'none'; // hide local video if none
    }

    // Enable controls
    joinBtn.disabled = true;
    muteBtn.disabled = false;
    raiseHandBtn.disabled = false;
    shareBtn.disabled = false;
    leaveBtn.disabled = false;
    joinBtn.innerText = "Connected ✅";

    if (userRole === 'host') {
    raisedHandsPanel.style.display = 'block';
     }

     // ✅ Save participant to Laravel DB
    await fetch('/participants', {
        method: 'POST',
        headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
        body: JSON.stringify({
            name: userName,
            role: userRole,
            room_id: roomId,
            socket_id: window.Echo.socketId() // optional for tracking
        })
    });


  // WebRTC signaling join
   liveRoomChannel = window.Echo.join(`live-room.${roomId}`)
    .here(async users => {
        // Existing logic for users already in the room
        for (const user of users) {
            if (user.id !== userId) {
                addParticipant({
                        id: user.id,
                        name: user.name,
                        role: user.role || 'student',
                        status: 'online'
                    });
                await createOffer(user.id);
            }
        }

        // 🟢 Announce your join to others
        liveRoomChannel.whisper('user-joined', {
            userId: userId,
            userName: userName,
            status: 'online'
        });

        // Display your own system message
        appendSystemMessage(`You joined the class.`);

        // ✅ Load all participants from DB and display
            const res = await fetch(`/participants/${roomId}`);
            const participants = await res.json();
            participants.forEach(participant => {
                if (participant.id !== userId) {
                    addParticipant({
                        id: participant.id,
                        name: participant.name,
                        role: participant.role
                    });
                }
            });
    })
    .joining(async user => {
        addParticipant(user);
        if (user.id !== userId) {
            appendSystemMessage(`${user.name} joined the class.`);
            await createOffer(user.id);
        }
    })
    .leaving(async user => {
    markUserOffline(user.id);
    appendSystemMessage(`${user.name} left the meeting.`);
    const videoContainer = document.getElementById(`user-${user.id}`);
    if (videoContainer) videoContainer.remove();

    // ✅ OK now, since we're inside an async function
    await fetch(`/participants/${window.Echo.socketId()}`, {
    method: 'DELETE',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    }
});


})



    // 🧍 When a new user joins
        .joining(async user => {
            addParticipant({
                id: user.id,
                name: user.name,
                role: user.role || 'student',
                status: 'online'
            });
            appendSystemMessage(`${user.name} joined the class.`);

            if (user.id !== userId) {
                await createOffer(user.id);
            }
        })

        // 🚪 When a user leaves
        .leaving(user => {
            addParticipant({
                id: user.id,
                name: user.name,
                role: user.role || 'student',
                status: 'offline'
            });
            appendSystemMessage(`${user.name} left the meeting.`);

            const videoContainer = document.getElementById(`user-${user.id}`);
            if (videoContainer) videoContainer.remove();
        })



    // Existing whispers for signaling
    .listenForWhisper('offer', handleOffer)
    .listenForWhisper('answer', handleAnswer)
    .listenForWhisper('ice-candidate', handleCandidate)
    // 🟠 Listen for join/leave whispers
    .listenForWhisper('user-joined', (data) => {
        if (data.userId !== userId) {
            appendSystemMessage(`${data.userName} joined the class.`);
        }
    })
    .listenForWhisper('user-left', (data) => {
        if (data.userId !== userId) {
            appendSystemMessage(`${data.userName} left the class.`);
            markUserOffline(data.userId);
            const videoContainer = document.getElementById(`user-${data.userId}`);
            if (videoContainer) videoContainer.remove();
        }
    })
    .listenForWhisper('hand-status', (data) => {
    const { userId: senderId, userName: senderName, raised, loweredByHost } = data;

    const videoContainer = document.getElementById(`user-${senderId}`);
    if (!videoContainer) return;

    let handIcon = videoContainer.querySelector('.hand-icon');

    // 🟢 Handle Raise
    if (raised) {
        if (!handIcon) {
            handIcon = document.createElement('div');
            handIcon.className = 'hand-icon';
            handIcon.innerHTML = '✋';
            handIcon.style.position = 'absolute';
            handIcon.style.top = '10px';
            handIcon.style.right = '10px';
            handIcon.style.fontSize = '24px';
            handIcon.style.color = '#ffb300';
            videoContainer.appendChild(handIcon);
        }
        appendSystemMessage(`${senderName} raised their hand ✋`);
        raisedUsers[senderId] = { id: senderId, name: senderName };

        // Call this inside the whisper listener when `raised === true`
       if (raised && userRole === 'host') {
        playNotificationSound();
      
    }
    }
    // 🔴 Handle Lower
    else {
        if (handIcon) handIcon.remove();
        if (loweredByHost && senderId !== userId) {
            // student’s hand was lowered by host → remove their own raised state
            appendSystemMessage(`Your hand was lowered by the host.`);
            if (isHandRaised) {
                isHandRaised = false;
                document.getElementById('raiseHandBtn').style.background = '';
                document.getElementById('raiseHandBtn').textContent = '✋ Raise Hand';
            }
        } else {
            appendSystemMessage(`${senderName} lowered their hand 🙌`);
        }
        delete raisedUsers[senderId];
    }

    // ✅ Update list for host
    if (userRole === 'host') updateRaisedHandsList();
})
.listenForWhisper('call-on', (data) => {
    const { targetId, targetName, by } = data;
    const targetContainer = document.getElementById(`user-${targetId}`);

    if (!targetContainer) return;

    // ✅ Highlight that user’s video for everyone
    Object.values(document.querySelectorAll('#video-grid > div')).forEach(div => {
        div.style.border = '2px solid #333';
    });
    targetContainer.style.border = '3px solid #4CAF50';
    targetContainer.style.boxShadow = '0 0 10px #4CAF50';

    // 🧑‍🏫 Notify all users
    appendSystemMessage(`${by} called on ${targetName} to speak 🎙️`);

    // 🧑‍🎓 If it’s *your* ID, show a special message
    if (userId == targetId) {
        const toast = document.createElement('div');
        toast.innerText = '🎙️ The teacher has called on you to speak!';
        toast.style.position = 'fixed';
        toast.style.bottom = '20px';
        toast.style.right = '20px';
        toast.style.background = '#4CAF50';
        toast.style.color = '#fff';
        toast.style.padding = '10px 15px';
        toast.style.borderRadius = '8px';
        toast.style.zIndex = '9999';
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 4000);
    }
})
.listenForWhisper('end-speaking', (data) => {
    const { by } = data;

    // Reset all borders
    Object.values(document.querySelectorAll('#video-grid > div')).forEach(div => {
        div.style.border = '2px solid #333';
        div.style.boxShadow = 'none';
    });

    appendSystemMessage(`${by} ended the speaking session 🛑`);
});








    // Listen for new chat messages
    window.Echo.channel(`live-room.${roomId}`)
        .listen('.chat.message', e => appendMessage(e.user.name, e.message));
}




// --- WebRTC logic ---
async function createPeerConnection(userId, userName = 'Guest') {
    const pc = new RTCPeerConnection({ iceServers: [{ urls: 'stun:stun.l.google.com:19302' }] });

    // Add local tracks if available
    if (localStream) {
        localStream.getTracks().forEach(track => pc.addTrack(track, localStream));
    }

    // Handle remote tracks
    pc.ontrack = event => {
        
    console.log('Remote track received for', userId, event.streams);

       let container = document.getElementById(`user-${userId}`);
        if (!container) {
          addParticipant({ id: userId, name: userName, role: userRole });
           container = document.getElementById(`user-${userId}`);
           container = document.createElement('div');
            container.id = `user-${userId}`;
            container.style.textAlign = 'center';
            container.style.margin = '8px';
            container.style.display = 'inline-block';
            container.style.border = '2px solid #333';
            container.style.borderRadius = '8px';
            container.style.width = '200px';
            container.style.position = 'relative';

            const video = document.createElement('video');
            video.id = `video-${userId}`;
            video.autoplay = true;
            video.playsInline = true;
            video.width = 200;
            video.height = 150;
            video.style.borderRadius = '8px';
            container.appendChild(video);

            // Avatar fallback
            const avatarImg = document.createElement('img');
            avatarImg.src = generateAvatar(userName);
            avatarImg.id = `avatar-${userId}`;
            avatarImg.style.position = 'absolute';
            avatarImg.style.top = '10px';
            avatarImg.style.left = '10px';
            avatarImg.style.width = '40px';
            avatarImg.style.height = '40px';
            avatarImg.style.borderRadius = '50%';
            avatarImg.style.border = '2px solid #fff';
            container.appendChild(avatarImg);

            const info = document.createElement('div');
            info.style.marginTop = '5px';
            info.innerText = userName;
            container.appendChild(info);

            videoGrid.appendChild(container);
        }

        const video = container.querySelector('video');
        const avatar = container.querySelector('img');

        if (event.streams[0].getVideoTracks().length > 0) {
            video.srcObject = event.streams[0];
            video.style.display = 'block';
            avatar.style.display = 'none';
        } else {
            video.style.display = 'none';
            avatar.style.display = 'block';
        }

        // Start active speaker detection if audio is present
        if (event.streams[0].getAudioTracks().length > 0) {
            createVolumeAnalyzer(event.streams[0], userId);
        }
    };

    // ICE candidate handling
    pc.onicecandidate = event => {
        if (event.candidate) {
            liveRoomChannel.whisper('ice-candidate', { target: userId, candidate: event.candidate });
        }
    };

    peers[userId] = pc;
    return pc;
}



async function createOffer(userId) {
    const pc = await createPeerConnection(userId);
    const offer = await pc.createOffer();
    await pc.setLocalDescription(offer);
   liveRoomChannel.whisper('offer', { target: userId, sdp: offer });

}

async function handleOffer({ target, sdp, userId: senderId }) {
    if (String(target) !== String(window.userId)) return; // ensure the offer is for YOU
    const pc = await createPeerConnection(senderId);
    await pc.setRemoteDescription(new RTCSessionDescription(sdp));
    const answer = await pc.createAnswer();
    await pc.setLocalDescription(answer);
    liveRoomChannel.whisper('answer', { target: senderId, sdp: answer, userId: window.userId });
}


async function handleAnswer({ target, sdp, userId: senderId }) {
    if (target !== userId) return;
    const pc = peers[senderId];
    if (!pc) return;
    await pc.setRemoteDescription(new RTCSessionDescription(sdp));
}


async function handleCandidate({ target, candidate, userId: senderId }) {
    if (String(target) !== String(window.userId)) return;
    const pc = peers[senderId];
    if (pc && candidate) await pc.addIceCandidate(candidate);
}


// --- Chat logic ---
sendBtn.addEventListener('click', sendMessage);
messageBox.addEventListener('keypress', e => { if (e.key === 'Enter') sendMessage(); });

//send message
async function sendMessage() {
    const message = messageBox.value.trim();
    if (!message) return;
    messageBox.value = '';

    // Append instantly
    appendMessage(userName, message, null, true);

    // Stop typing indicator broadcast
    stopTyping();

    await fetch(`/chat/send`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            roomId: roomId,
            message: message
        })
    });
}

function appendSystemMessage(text) {
    const div = document.createElement('div');
    div.className = 'system-message';
    div.textContent = text;
    div.style.textAlign = 'center';
    div.style.color = '#777';
    div.style.fontStyle = 'italic';
    div.style.margin = '8px 0';
    chatMessages.appendChild(div);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}


// --- Typing indicator logic ---
let typingTimeout;
let typing = false;

messageBox.addEventListener('input', () => {
    if (!typing) {
        typing = true;
        window.Echo.channel(`live-room.${roomId}`)
            .whisper('typing', { user: userName, typing: true });
    }

    clearTimeout(typingTimeout);
    typingTimeout = setTimeout(stopTyping, 1500);
});

function stopTyping() {
    typing = false;
    window.Echo.channel(`live-room.${roomId}`)
        .whisper('typing', { user: userName, typing: false });
}

// Listen for typing events from others
const typingIndicator = document.getElementById('typing-indicator');
window.Echo.channel(`live-room.${roomId}`)
    .listenForWhisper('typing', (e) => {
        if (e.typing && e.user !== userName) {
            typingIndicator.textContent = `${e.user} is typing...`;
        } else {
            typingIndicator.textContent = '';
        }
    });

// --- Listen for new chat messages (with timestamp) ---
window.Echo.channel(`live-room.${roomId}`)
    .listen('.chat.message', e => {
        appendMessage(e.user.name, e.message, e.timestamp);
    });

sendBtn.addEventListener('click', sendMessage);
messageBox.addEventListener('keypress', e => {
    if (e.key === 'Enter') sendMessage();
});

//create avater
function generateAvatar(name, size = 50) {
    const canvas = document.createElement('canvas');
    canvas.width = size;
    canvas.height = size;
    const ctx = canvas.getContext('2d');

    // Generate random background color based on name hash
    let hash = 0;
    for (let i = 0; i < name.length; i++) hash = name.charCodeAt(i) + ((hash << 5) - hash);
    const color = `hsl(${hash % 360}, 70%, 60%)`;
    
    // Draw background
    ctx.fillStyle = color;
    ctx.fillRect(0, 0, size, size);
    
    // Draw initials
    ctx.fillStyle = "#fff";
    ctx.font = `${size/2}px sans-serif`;
    ctx.textAlign = "center";
    ctx.textBaseline = "middle";
    const initials = name.split(' ').map(n => n[0]).join('').toUpperCase();
    ctx.fillText(initials, size/2, size/2);
    
    return canvas.toDataURL(); // returns a base64 image
}

//add user avater
function addUserVideo(userId, userName, stream, avatarUrl=null) {
    

    const container = document.createElement('div');
    container.id = `user-${userId}`;
    container.style.position = 'relative';
    container.style.border = '2px solid #333';
    container.style.margin = '5px';
    container.style.display = 'inline-block';
    container.style.width = '200px';

    // Video element
    const video = document.createElement('video');
    video.autoplay = true;
    video.playsInline = true;
    video.srcObject = stream;
    if(userId === window.userId) video.muted = true;
    video.style.width = '100%';
    container.appendChild(video);

    // Avatar (shown if video not available)
    const avatarImg = document.createElement('img');
    avatarImg.src = avatarUrl || generateAvatar(userName);
    avatarImg.style.position = 'absolute';
    avatarImg.style.top = '10px';
    avatarImg.style.left = '10px';
    avatarImg.style.width = '40px';
    avatarImg.style.height = '40px';
    avatarImg.style.borderRadius = '50%';
    avatarImg.style.border = '2px solid #fff';
    container.appendChild(avatarImg);

    // Display name
    const nameTag = document.createElement('div');
    nameTag.innerText = userName;
    nameTag.style.position = 'absolute';
    nameTag.style.bottom = '5px';
    nameTag.style.left = '5px';
    nameTag.style.background = 'rgba(0,0,0,0.5)';
    nameTag.style.color = 'white';
    nameTag.style.padding = '2px 5px';
    nameTag.style.borderRadius = '5px';
    container.appendChild(nameTag);

    videoGrid.appendChild(container);
}

//add avater to chat message
function addChatMessage(userName, message, avatarUrl=null) {
    const chatBox = document.getElementById('chat-messages');

    const msgContainer = document.createElement('div');
    msgContainer.style.display = 'flex';
    msgContainer.style.margin = '5px 0';
    msgContainer.style.alignItems = 'center';

    const avatarImg = document.createElement('img');
    avatarImg.src = avatarUrl || generateAvatar(userName, 30);
    avatarImg.style.width = '30px';
    avatarImg.style.height = '30px';
    avatarImg.style.borderRadius = '50%';
    avatarImg.style.marginRight = '5px';
    msgContainer.appendChild(avatarImg);

    const textContainer = document.createElement('div');
    textContainer.innerHTML = `<strong>${userName}</strong>: ${message}`;
    textContainer.style.background = '#f1f1f1';
    textContainer.style.padding = '5px 10px';
    textContainer.style.borderRadius = '10px';
    textContainer.style.maxWidth = '70%';
    msgContainer.appendChild(textContainer);

    chatBox.appendChild(msgContainer);
    chatBox.scrollTop = chatBox.scrollHeight;
}

//add participant
function addParticipant(user) {
    let container = document.getElementById(`user-${user.id}`);
    if (!container) {
        container = document.createElement('div');
        container.id = `user-${user.id}`;
        container.style.textAlign = 'center';
        container.style.margin = '8px';
        container.style.display = 'inline-block';

        // Create the video element
        const video = document.createElement('video');
        video.id = `video-${user.id}`;
        video.autoplay = true;
        video.playsInline = true;
        video.width = 300;
        video.height = 200;
        video.style.borderRadius = '8px';
        video.style.border = '2px solid #333';

        // User info section
        const info = document.createElement('div');
        info.style.marginTop = '6px';

        // Status dot
        const statusDot = document.createElement('span');
        statusDot.id = `status-${user.id}`;
        statusDot.style.display = 'inline-block';
        statusDot.style.width = '10px';
        statusDot.style.height = '10px';
        statusDot.style.borderRadius = '50%';
        statusDot.style.marginRight = '6px';
       statusDot.style.background = user.status === 'online' ? '#4CAF50' : '#f44336';

        // User name + role badge
        const name = document.createElement('span');
        name.textContent = user.name;

        const role = document.createElement('span');
        role.textContent = ` ${user.role}`;
        role.style.background = user.role === 'host' ? '#4CAF50' : (user.role === 'student' ? '#2196F3' : '#777');
        role.style.color = '#fff';
        role.style.fontSize = '11px';
        role.style.padding = '2px 6px';
        role.style.borderRadius = '4px';
        role.style.marginLeft = '6px';

        info.appendChild(statusDot);
        info.appendChild(name);
        info.appendChild(role);

        container.appendChild(video);
        container.appendChild(info);
        videoGrid.appendChild(container);
    }

    else {
        // Update status dynamically
        const statusDot = document.getElementById(`status-${user.id}`);
        if (statusDot) statusDot.style.background = user.status === 'online' ? '#4CAF50' : '#f44336';
    }
}

function markUserOffline(userId) {
    const dot = document.getElementById(`status-${userId}`);
    if (dot) dot.style.background = '#777'; // gray = offline
}



// --- Controls: mute, camera, share screen ---
muteBtn.addEventListener('click', () => {
    audioEnabled = !audioEnabled;
    localStream.getAudioTracks().forEach(track => track.enabled = audioEnabled);
    muteBtn.textContent = audioEnabled ? 'Mute' : 'Unmute';
});

cameraBtn.addEventListener('click', () => {
    videoEnabled = !videoEnabled;
    localStream.getVideoTracks().forEach(track => track.enabled = videoEnabled);
    cameraBtn.textContent = videoEnabled ? 'Stop Camera' : 'Start Camera';
});

shareBtn.addEventListener('click', async () => {
    if (!screenStream) {
        try {
            screenStream = await navigator.mediaDevices.getDisplayMedia({ video: true });
            const screenTrack = screenStream.getTracks()[0];
            Object.values(peers).forEach(pc => {
                const sender = pc.getSenders().find(s => s.track.kind === 'video');
                if (sender) sender.replaceTrack(screenTrack);
            });
            localVideo.srcObject = screenStream;
            shareBtn.textContent = 'Stop Share';
            screenTrack.onended = () => stopShare();
        } catch (err) { console.error('Screen share error:', err); }
    } else { stopShare(); }
});

function stopShare() {
    screenStream.getTracks().forEach(track => track.stop());
    screenStream = null;
    const videoTrack = localStream.getVideoTracks()[0];
    Object.values(peers).forEach(pc => {
        const sender = pc.getSenders().find(s => s.track.kind === 'video');
        if (sender) sender.replaceTrack(videoTrack);
    });
    localVideo.srcObject = localStream;
    shareBtn.textContent = 'Share Screen';
}

//Leave class
const leaveBtn = document.getElementById('leaveBtn');

leaveBtn.addEventListener('click', leaveMeeting);

async function leaveMeeting() {
    // 1️⃣ Announce leaving
    if (liveRoomChannel) {
        liveRoomChannel.whisper('user-left', {
            userId: userId,
            userName: userName
        });
    }

    // 2️⃣ Stop local media
    if (localStream) {
        localStream.getTracks().forEach(track => track.stop());
        localVideo.srcObject = null;
    }

    // 3️⃣ Stop screen sharing if active
    if (screenStream) {
        screenStream.getTracks().forEach(track => track.stop());
        screenStream = null;
    }

    // 4️⃣ Close all peer connections
    for (const id in peers) {
        if (peers[id]) peers[id].close();
        delete peers[id];
    }

    // 5️⃣ Leave Echo presence channel
    if (liveRoomChannel) {
        try {
            await liveRoomChannel.leave();
        } catch (err) {
            console.warn('Channel leave failed (ignored):', err);
        }
        liveRoomChannel = null;
    }

    // 6️⃣ Clear remote video elements
    videoGrid.innerHTML = '';

    // 7️⃣ Reset UI
    joinBtn.disabled = false;
    leaveBtn.disabled = true;
    muteBtn.disabled = true;
    cameraBtn.disabled = true;
    shareBtn.disabled = true;
    raiseHandBtn.disabled = true;
    raiseHandBtn.classList.remove('active');
    raiseHandBtn.textContent = '✋ Raise Hand';
    handRaised = false;
    raisedHandsPanel.style.display = 'none';
    raisedHandsList.innerHTML = '';
    Object.keys(raisedUsers).forEach(id => delete raisedUsers[id]);

    joinBtn.innerText = "Join Class Room";

    // 8️⃣ Show feedback
    alert('You have left the class room.');

    // Optional redirect
     window.location.href = '/dashboard';
}




//Create Volume
function createVolumeAnalyzer(stream, userId) {
    const audioContext = new (window.AudioContext || window.webkitAudioContext)();
    const source = audioContext.createMediaStreamSource(stream);
    const analyser = audioContext.createAnalyser();
    analyser.fftSize = 512;
    source.connect(analyser);

    const dataArray = new Uint8Array(analyser.frequencyBinCount);

    function checkVolume() {
        analyser.getByteFrequencyData(dataArray);
        let sum = 0;
        for (let i = 0; i < dataArray.length; i++) sum += dataArray[i];
        const avg = sum / dataArray.length;

        const videoContainer = document.getElementById(`user-${userId}`);
        if (videoContainer) {
            if (avg > 15) { // Threshold for speaking
                videoContainer.style.border = '3px solid #4CAF50'; // green border = speaking
            } else {
                videoContainer.style.border = '2px solid #333'; // normal border
            }
        }
        requestAnimationFrame(checkVolume);
    }
    checkVolume();
}

// --- Raise Hand feature ---
const raiseHandBtn = document.getElementById('raiseHandBtn');
let handRaised = false;

raiseHandBtn.addEventListener('click', () => {
    handRaised = !handRaised;
    raiseHandBtn.classList.toggle('active', handRaised);
    raiseHandBtn.textContent = handRaised ? '🙌 Lower Hand' : '✋ Raise Hand';

    if (liveRoomChannel) {
        liveRoomChannel.whisper('hand-status', {
            userId,
            userName,
            raised: handRaised
        });
    }

    // Display your own message
    appendSystemMessage(handRaised ? 'You raised your hand ✋' : 'You lowered your hand 🙌');
});

// --- Raised Hands Panel (for Host) ---
const raisedHandsPanel = document.getElementById('raisedHandsPanel');
const raisedHandsList = document.getElementById('raisedHandsList');
const raisedUsers = {}; // Track who has hands raised

function updateRaisedHandsList() {
    raisedHandsList.innerHTML = '';

    const entries = Object.values(raisedUsers);
    if (entries.length === 0) {
        raisedHandsPanel.style.display = 'none';
        return;
    }

    raisedHandsPanel.style.display = 'block';
    for (const user of entries) {
        const li = document.createElement('li');
        li.innerHTML = `
            <span>${user.name}</span>
            <div style="display:flex; gap:6px; align-items:center;">
                <button class="call-btn" data-id="${user.id}" style="background:#4CAF50;color:#fff;border:none;border-radius:4px;padding:2px 6px;cursor:pointer;">🎙️</button>
                <button class="lower-btn" data-id="${user.id}" style="background:#f44336;color:#fff;border:none;border-radius:4px;padding:2px 6px;cursor:pointer;">⬇️</button>
            </div>
        `;
        raisedHandsList.appendChild(li);
    }

    // 🎙️ Call button
    document.querySelectorAll('.call-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const targetId = btn.dataset.id;
            const target = raisedUsers[targetId];
            if (!target) return;

            liveRoomChannel.whisper('call-on', {
                targetId: target.id,
                targetName: target.name,
                by: userName
            });
        });
    });

    // ⬇️ Lower button
    document.querySelectorAll('.lower-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const targetId = btn.dataset.id;
            const target = raisedUsers[targetId];
            if (!target) return;

            liveRoomChannel.whisper('hand-status', {
                userId: target.id,
                userName: target.name,
                raised: false,
                loweredByHost: true
            });
        });
    });
}

const endSpeakingBtn = document.getElementById('endSpeakingBtn');

if (userRole === 'host') {
    endSpeakingBtn.style.display = 'inline-block';
}

endSpeakingBtn.addEventListener('click', () => {
    liveRoomChannel.whisper('end-speaking', { by: userName });
});


function playNotificationSound() {
    const audio = new Audio('/sounds/notification.mp3');
    audio.play().catch(() => {}); // prevent auto-play errors
}


window.addEventListener('beforeunload', async () => {
    try {
        await fetch(`/participants/${window.Echo.socketId()}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
    } catch (err) {
        console.warn('Could not delete participant on unload:', err);
    }
});



joinBtn.addEventListener('click', joinRoom);
</script>
</body>
</html>
