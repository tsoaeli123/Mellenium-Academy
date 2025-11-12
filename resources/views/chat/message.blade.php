<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Messenger</title>
@vite(['resources/js/app.js'])
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
body { font-family: Arial, sans-serif; background:#f0f2f5; margin:0; display:flex; justify-content:center; height:100vh;}
.container { display:flex; width:900px; background:white; border-radius:8px; overflow:hidden; box-shadow:0 0 8px rgba(0,0,0,0.1); margin-top:40px; }
.sidebar { width:40%; border-right:1px solid #ddd; overflow-y:auto; }
.sidebar h3 { background:#007bff; color:white; margin:0; padding:15px; }
.user { display:flex; justify-content:space-between; align-items:center; padding:10px; border-bottom:1px solid #eee; cursor:pointer; transition:background 0.2s; }
.user:hover { background:#f7f7f7; }
.user-left { display:flex; align-items:center; }
.avatar { width:40px; height:40px; border-radius:50%; margin-right:8px; display:flex; align-items:center; justify-content:center; color:white; font-weight:bold; font-size:16px; }
.username-wrapper { display:flex; flex-direction:column; }
.username { font-weight:500; position:relative; }
.unread-count { font-size:10px; color:white; background:red; border-radius:50%; padding:2px 5px; align-self:flex-start; margin-bottom:2px; display:inline-block; }
.status-dot { width:10px; height:10px; border-radius:50%; background:gray; margin-left:180px; display:inline-block; }
.status-dot.online { background:#31a24c; }
.badge { background:red; color:white; font-size:12px; padding:2px 6px; border-radius:50%; margin-left:5px; display:inline-block; }
.chat-window { flex:1; display:flex; flex-direction:column; }
.chat-header { background:#007bff; color:white; padding:15px; font-weight:bold; display:flex; justify-content:space-between; align-items:center; }
.typing-indicator { font-size:12px; color:#fff; font-weight:normal; }
.messages { flex:1; background:#f9f9f9; overflow-y:auto; padding:15px; display:flex; flex-direction:column; }
.message-wrapper { position:relative; margin-bottom:10px; display:flex; flex-direction:column; }
.message { padding:8px 12px; border-radius:20px; max-width:70%; word-wrap:break-word; position:relative; }
.message.me { background:#0084ff; color:white; align-self:flex-end; border-bottom-right-radius:5px; }
.message.other { background:#e5e5ea; color:black; align-self:flex-start; border-bottom-left-radius:5px; }
.timestamp { font-size:10px; color:#999; margin-left:5px; }
.forwarded-label { font-size:10px; color:#555; margin-bottom:3px; }
.seen-indicator { font-size:10px; color:#fff; margin-left:5px; }

.hover-menu {
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.2s ease, visibility 0.2s ease;
}

.message-wrapper:hover .hover-menu,
.hover-menu:hover {
  display: flex; /* required for layout */
  opacity: 1;
  visibility: visible;
}


.edit-btn, .delete-btn, .forward-btn, .emoji-btn { cursor:pointer; font-size:14px; }
.emoji-reactions { display:flex; gap:2px; margin-top:3px; font-size:14px; cursor:pointer; }
#chat-input-area { display:flex; gap:5px; padding:10px; border-top:1px solid #ddd; align-items:center; }
#messageInput { flex:1; padding:10px; border:1px solid #ccc; border-radius:20px; resize:none; }
button { border:none; background:#007bff; color:white; border-radius:20px; padding:10px 15px; cursor:pointer; }
button:disabled { opacity:0.6; cursor:not-allowed; }
#reply-box { display:none; font-size:12px; color:#555; border-left:2px solid #ccc; padding-left:5px; margin-bottom:5px; }
.file-input { display:none; }
.voice-btn { cursor:pointer; font-size:16px; margin-right:5px; }

.edited-label {
  font-size: 10px;
  color: #ccc;
  margin-left: 5px;
  font-style: italic;
}

/* Forward modal */
#forwardModal {
  display: none;
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  justify-content: center; align-items: center;
  z-index: 1000;
}

#forwardModal .modal-overlay {
  position: absolute;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.4);
  top: 0; left: 0;
}

#forwardModal .modal-box {
  background: white;
  padding: 20px;
  border-radius: 8px;
  width: 320px;
  z-index: 1001;
  box-shadow: 0 3px 10px rgba(0,0,0,0.3);
  display: flex;
  flex-direction: column;
  gap: 10px;
}

#forwardModal h4 {
  margin: 0;
  font-size: 16px;
  border-bottom: 1px solid #eee;
  padding-bottom: 8px;
}

.forward-user {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: #f7f7f7;
  border-radius: 8px;
  padding: 6px 10px;
  margin-top: 5px;
}

.forward-user .avatar {
  width: 32px; height: 32px;
  border-radius: 50%;
  background: #007bff;
  color: white;
  font-weight: bold;
  display: flex; align-items: center; justify-content: center;
}

.forward-user .name {
  flex: 1;
  margin-left: 10px;
  font-weight: 500;
}

.forward-user .forward-btn {
  background: #007bff;
  color: white;
  border: none;
  border-radius: 6px;
  padding: 5px 10px;
  cursor: pointer;
}

.forward-user .forward-btn:hover {
  background: #0056b3;
}

.cancel-btn {
  margin-top: 10px;
  background: #999;
  color: white;
  border: none;
  padding: 8px;
  border-radius: 6px;
  cursor: pointer;
}

.image-preview img {
  transition: transform 0.2s ease;
}
.image-preview img:hover {
  transform: scale(1.03);
}

.stop-send-btn, .cancel-btn {
    margin-left: 8px;
    border: none;
    border-radius: 4px;
    padding: 3px 6px;
    font-size: 12px;
    cursor: pointer;
}
.stop-send-btn {
    background: #ff5c5c;
    color: white;
}
.stop-send-btn:hover {
    background: #ff3333;
}
.cancel-btn {
    background: #ccc;
    color: #333;
}
.cancel-btn:hover {
    background: #999;
}
.voice-duration {
    font-size: 12px;
    color: #555;
    margin-top: 4px;
    text-align: right;
}
.record-duration {
    font-weight: bold;
}



.cancel-btn {
    margin-left: 5px;
    background: #ccc;
    color: #333;
    border: none;
    border-radius: 4px;
    padding: 2px 6px;
    cursor: pointer;
    font-size: 12px;
}
.cancel-btn:hover {
    background: #999;
}

.reply-preview {
    background: #f0f0f0;
    border-left: 3px solid #4a90e2;
    padding: 6px 10px;
    margin-bottom: 6px;
    border-radius: 6px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
    color: #333;
}
.reply-preview .cancel-reply {
    background: none;
    border: none;
    color: #888;
    font-size: 14px;
    cursor: pointer;
}

.reply-bubble {
    background: #e9e9e9;
    border-left: 3px solid #4a90e2;
    padding: 4px 8px;
    border-radius: 5px;
    margin-bottom: 5px;
    font-size: 13px;
}
.reply-bubble .reply-author {
    font-weight: bold;
    font-size: 12px;
    color: #007bff;
}
.reply-bubble .reply-text {
    font-size: 13px;
    color: #333;
}

.message.highlighted {
    animation: flashHighlight 2s ease;
    border: 2px solid #ffd700;
    border-radius: 10px;
}

@keyframes flashHighlight {
    0%   { background-color: #fff6b2; }
    50%  { background-color: #fff6b2; }
    100% { background-color: transparent; }
}

/* --- Responsive (Mobile / Tablet) --- */
@media (max-width: 768px) {
  body { align-items: flex-start; height: auto; }
  .container {
    flex-direction: column;
    width: 100%;
    height: 100vh;
    border-radius: 0;
    margin-top: 0;
  }
}
  /* --- Small screens (phones under 480px) --- */
@media (max-width: 480px) {
  .sidebar {
    height: 100%;
    width: 100%;
    position: absolute;
    z-index: 10;
    background: white;
    transition: transform 0.3s ease;
    transform: translateX(0);
  }

}


</style>
</head>
<body>

<div class="container">
   
  <div class="sidebar">
    <h3><a href="{{route('teacher.dashboard')}}"><i class="fas fa-home"></i></a>  Chats Live</h3>
    @foreach($users as $user)
      <div class="user" onclick="Chat.openChat({{ $user->id }}, '{{ $user->name }}')">
        <div class="user-left">
          <div class="avatar" id="avatar-{{ $user->id }}"></div>
          <div class="username-wrapper">
            <span class="unread-count" id="unread-{{ $user->id }}"></span>
            <span class="username">{{ $user->name }}</span>
            <span class="status-dot" id="status-{{ $user->id }}"></span>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="chat-window">
    <div class="chat-header">
      <div id="chatHeader">Select a user</div>
      <div class="typing-indicator" id="typingIndicator"></div>
    </div>
    <div id="messages" class="messages"></div>

    <div id="chat-input-area">
  <div id="reply-box"></div>
  <button class="voice-btn" id="voiceBtn">🎤</button>
  <button class="file-btn" onclick="document.getElementById('fileInput').click()">📎</button>
  <input type="file" id="fileInput" class="file-input" />
  <div id="filePreview" style="display:none; margin-bottom:5px;"></div>
  <textarea id="messageInput" placeholder="Type a message..." disabled></textarea>
  <button id="sendBtn" disabled>Send</button>
</div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/pusher-js@8.2.0/dist/web/pusher.min.js"></script>
<script>
const currentUser = @json(Auth::user());
let selectedUserId = null;
let selectedFile = null;
let voiceBlob = null;
let rec = null;

let recordStartTime = null;
let recordTimerInterval = null;
let tempVoiceMessageId = null;


const sidebar = document.querySelector('.sidebar');
const header = document.querySelector('.chat-header');

header.addEventListener('click', () => {
  if (window.innerWidth <= 480) sidebar.classList.toggle('hidden');
});


let audioChunks = []; // store chunks while recording
const csrf = document.querySelector('meta[name="csrf-token"]').content;
const EMOJIS = ['👍','❤️','😂','😮','😢','😡'];

// === Avatar initials ===
@foreach($users as $user) { 
    const el = document.getElementById('avatar-{{ $user->id }}');
     if(el){ el.textContent = '{{ strtoupper(substr($user->name,0,2)) }}';
     el.style.backgroundColor = '#' + Math.floor(Math.random()*16777215).toString(16); } 
}
 @endforeach


 //time
function timeAgo(dateStr) {
    const now = new Date();
    const date = new Date(dateStr);
    const seconds = Math.floor((now - date) / 1000);

    const intervals = {
        year: 31536000,
        month: 2592000,
        week: 604800,
        day: 86400,
        hour: 3600,
        minute: 60
    };

    for (const [unit, value] of Object.entries(intervals)) {
        const count = Math.floor(seconds / value);
        if (count >= 1) return `${count} ${unit}${count > 1 ? 's' : ''} ago`;
    }

    return 'just now';
}



// === Core Chat Object ===
window.Chat = {
    openChat(id, name){
        selectedUserId = id;
        document.getElementById('chatHeader').innerText = name;
        document.getElementById('messages').innerHTML = '';
        document.getElementById('messageInput').disabled = false;
        document.getElementById('sendBtn').disabled = false;

        // clear unread badge when opened
        Unread.clear(id);

        // mark messages seen on backend
        fetch(`/chat/${id}/seen`, {method:'POST', headers:{'X-CSRF-TOKEN':csrf}});

        fetch(`/chat/${id}`).then(r=>r.json()).then(msgs=>{
            msgs.forEach(m => Chat.appendMessage(m));
            Chat.scrollToBottom();
        });
    },

appendMessage(m) {
    const wrap = document.createElement('div');
    wrap.className = 'message-wrapper';

    const msg = document.createElement('div');
    msg.className = `message ${m.sender_id === currentUser.id ? 'me' : 'other'}`;
    msg.id = 'message-' + m.id;

    // Hover menu (edit/delete/forward/emoji)
    const menu = document.createElement('div');
    menu.className = 'hover-menu';
    if (m.sender_id === currentUser.id) {
        menu.innerHTML = `
            <span class="edit-btn" onclick="Chat.edit(${m.id})">✏️</span>
            <span class="delete-btn" onclick="Chat.delete(${m.id})">🗑️</span>
        `;
    }
    menu.innerHTML += `
    <span class="reply-btn" onclick="Chat.reply(${m.id})">↩️</span>
    <span class="forward-btn" onclick="Chat.forward(${m.id})">↪️</span>
    <span class="emoji-btn" onclick="Chat.reactionMenu(${m.id})">😊</span>
`;

    wrap.append(menu);

    if (m.reply_to) {
    content += `
        <div class="reply-preview" data-reply-id="${m.reply_to.id}">
            <div class="reply-user">${m.reply_to.sender_name || 'Unknown'}</div>
            <div class="reply-snippet">
                ${m.reply_to.message ? m.reply_to.message.substring(0, 60) : ''}
                ${m.reply_to.file_url ? '📎 File' : ''}
                ${m.reply_to.voice_url ? '🎙 Voice message' : ''}
            </div>
        </div>
    `;
}

// === Click-to-scroll to original replied message ===
setTimeout(() => {
    const replyEl = wrap.querySelector('.reply-preview');
    if (replyEl) {
        replyEl.style.cursor = 'pointer';
        replyEl.onclick = () => {
            const originalId = replyEl.dataset.replyId;
            const target = document.getElementById('message-' + originalId);

            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'center' });
                target.classList.add('highlighted');

                // temporary highlight (yellow flash)
                setTimeout(() => target.classList.remove('highlighted'), 2000);
            } else {
                // Auto-fetch if original not in DOM
            fetch(`/replys/${originalId}`)
            .then(res => res.json())
            .then(original => {
                Chat.appendMessage(original);
                setTimeout(() => {
                    const newTarget = document.getElementById('message-' + original.id);
                    newTarget?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    newTarget?.classList.add('highlighted');
                    setTimeout(() => newTarget?.classList.remove('highlighted'), 2000);
                }, 200);
            })
            .catch(err => console.error('Failed to load original message', err));
            }
        };
    }
}, 0);


    // === Message content ===
    let content = '';
    if (m.is_forwarded) {
        content += `<div class="forwarded-label">Forwarded</div>`;
    }
    if (m.message) {
        content += `<div>${m.message}</div>`;
    }

    // === File / Voice attachments ===
    let media = '';
    if (m.file_url) {
    // Check if it's an image file (by extension or MIME)
    const ext = m.file_url.split('.').pop().toLowerCase();
    const imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (imageTypes.includes(ext)) {
        // 🖼️ Show image inline
        media += `
            <div class="image-preview">
                <img src="${m.file_url}" 
                     alt="Image" 
                     style="max-width:200px; border-radius:10px; margin-top:5px; cursor:pointer;" 
                     onclick="window.open('${m.file_url}', '_blank')" />
            </div>`;
    } else {
        // 📎 Non-image file — show download link
        const fileName = m.file_url.split('/').pop();
        media += `<div><a href="${m.file_url}" target="_blank">📎 ${fileName}</a></div>`;
    }
}



    if (m.voice_url) {
        media += `<audio controls src="${m.voice_url}"></audio>`;
    }

    const timestamp = `<span class="timestamp">${timeAgo(m.created_at)}</span>`;
    const seen = (m.sender_id === currentUser.id && m.seen) ? '✔✔' : '';

    msg.innerHTML = `${content}${media}${timestamp} ${seen}`;
    wrap.append(msg);

    // === Emoji Reactions ===
    if (m.reactions && m.reactions.length) {
        const container = document.createElement('div');
        container.className = 'emoji-reactions';
        m.reactions.forEach(r => {
            const span = document.createElement('span');
            span.textContent = r.emoji;
            span.title = r.user ? r.user.name : '';
            container.append(span);
        });
        wrap.append(container);
    }

    document.getElementById('messages').append(wrap);
},

send() {
    const text = document.getElementById('messageInput').value.trim();

    const hasText = text.length > 0;
    const hasFile = selectedFile instanceof File;
    const hasVoice = voiceBlob instanceof Blob;

    if (!hasText && !hasFile && !hasVoice) {
        console.warn('Nothing to send.');
        return;
    }

    const fd = new FormData();
    fd.append('receiver_id', selectedUserId);

    if (hasText) fd.append('message', text);
    if (hasFile) fd.append('file', selectedFile);

    if (hasVoice) {
    const mimeType = voiceBlob.type || 'audio/ogg';
    let ext = 'ogg';
    if (mimeType === 'audio/mpeg') ext = 'mp3';
    else if (mimeType === 'audio/wav' || mimeType === 'audio/wave') ext = 'wav';
    else if (mimeType === 'audio/webm') ext = 'webm';
    else if (mimeType === 'audio/opus') ext = 'opus';

    fd.append('voice', voiceBlob, `voice_message.${ext}`);

    // Optional: attach duration to FormData
    const audioTemp = document.createElement('audio');
    audioTemp.src = URL.createObjectURL(voiceBlob);
    audioTemp.onloadedmetadata = () => {
        fd.append('voice_duration', Math.floor(audioTemp.duration)); // seconds
    };
}

// Check if replying
const replyBox = document.getElementById('replyPreview');
if (replyBox && replyBox.dataset.replyId) {
    fd.append('reply_to_id', replyBox.dataset.replyId);
}


    fetch('/chats', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrf },
        body: fd
    })
    .then(res => res.json())
    .then(data => {
        if (data.message) {
            Chat.appendMessage(data.message);
            Chat.scrollToBottom();
        }

        // Reset inputs
        document.getElementById('messageInput').value = '';
        selectedFile = null;
        voiceBlob = null;
        document.getElementById('fileInput').value = '';
        document.getElementById('filePreview').innerHTML = '';
        document.getElementById('filePreview').style.display = 'none';

        document.getElementById('replyPreview')?.remove();

    })
    .catch(err => console.error('Send failed', err));
},



    edit(id){
        const el = document.getElementById('message-'+id);
        if(!el) return;
        const timestamp = el.querySelector('.timestamp');
        const originalHTML = el.innerHTML;
        const messageText = el.childNodes[0]?.nodeValue?.trim() || '';
        const textarea = document.createElement('textarea');
        textarea.className = 'edit-textarea';
        textarea.value = messageText;
        textarea.style.width = '100%';
        textarea.style.border = '1px solid #ccc';
        textarea.style.borderRadius = '8px';
        textarea.style.padding = '6px';
        textarea.style.fontSize = '14px';
        textarea.style.resize = 'none';
        el.innerHTML = '';
        el.appendChild(textarea);
        if(timestamp) el.appendChild(timestamp);
        textarea.focus();
        textarea.addEventListener('keydown', e => {
            if(e.key==='Enter' && !e.shiftKey){
                e.preventDefault();
                const newText = textarea.value.trim();
                if(newText.length && newText !== messageText){
                    fetch('/chat/'+id, {
                        method:'PUT',
                        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrf},
                        body: JSON.stringify({message:newText})
                    }).then(res=>res.json()).then(()=> {
                        const editedLabel = `<span class="edited-label">(edited)</span>`;
                        el.innerHTML = `${newText} ${editedLabel} ${timestamp?timestamp.outerHTML:''}`;
                    });
                } else { el.innerHTML = originalHTML; }
            }
        });
        textarea.addEventListener('keydown', e => { if(e.key==='Escape') el.innerHTML = originalHTML; });
        textarea.addEventListener('blur', ()=>{ el.innerHTML = originalHTML; });
    },

    delete(id){
        if(!confirm('Delete this message?')) return;
        fetch('/chat/'+id, {method:'DELETE', headers:{'X-CSRF-TOKEN':csrf}});
        document.getElementById('message-'+id)?.remove();
    },

    //reply message
    reply(id) {
    const msgEl = document.getElementById('message-' + id);
    if (!msgEl) return;

    // Extract a short preview text
    const textPreview = msgEl.textContent.trim().slice(0, 60);

    // Create or update reply preview box
    let replyBox = document.getElementById('replyPreview');
    if (!replyBox) {
        replyBox = document.createElement('div');
        replyBox.id = 'replyPreview';
        replyBox.className = 'reply-preview';
        replyBox.innerHTML = `
            <div class="reply-content"></div>
            <button class="cancel-reply">✖</button>
        `;
        const inputArea = document.getElementById('chat-input-area') || document.querySelector('.input-area');
        inputArea.prepend(replyBox);
        replyBox.querySelector('.cancel-reply').onclick = () => replyBox.remove();
    }

    // Fill in content
    replyBox.querySelector('.reply-content').innerHTML = `<b>Replying to:</b> ${textPreview}`;
    replyBox.dataset.replyId = id;
},



    forward(id){
        // Simplified: show modal and forward to user
        let modal = document.getElementById('forwardModal');
        if(!modal){
            modal = document.createElement('div');
            modal.id = 'forwardModal';
            modal.innerHTML = `
                <div class="modal-overlay"></div>
                <div class="modal-box">
                  <h4>Forward message to:</h4>
                  <div id="forwardUserList" class="user-list"></div>
                  <button class="cancel-btn">Cancel</button>
                </div>`;
            document.body.appendChild(modal);
            modal.querySelector('.cancel-btn').onclick = ()=>modal.style.display='none';
            modal.querySelector('.modal-overlay').onclick = ()=>modal.style.display='none';
        }
        const list = modal.querySelector('#forwardUserList'); list.innerHTML = '';
        fetch('/username').then(res=>res.json()).then(users=>{
            users.filter(u=>u.id!==currentUser.id).forEach(u=>{
                const userEl = document.createElement('div');
                userEl.className = 'forward-user';
                userEl.innerHTML = `
                    <div class="avatar">${u.name[0].toUpperCase()}</div>
                    <span class="name">${u.name}</span>
                    <button class="forward-btn">📤 Forward</button>`;
                userEl.querySelector('.forward-btn').onclick = ()=>{
                    fetch(`/chat/${id}/forward`, {
                        method:'POST',
                        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrf},
                        body: JSON.stringify({receiver_id:u.id})
                    }).then(()=> { modal.style.display='none'; });
                };
                list.appendChild(userEl);
            });
        });
        modal.style.display='flex';
    },

    reactionMenu(id){
        const menu = document.createElement('div');
        menu.style.position='absolute'; menu.style.background='#fff';
        menu.style.padding='3px'; menu.style.borderRadius='10px';
        EMOJIS.forEach(e=>{
            const span = document.createElement('span');
            span.textContent = e;
            span.onclick = ()=> Chat.react(id,e,menu);
            menu.append(span);
        });
        document.body.append(menu);
    },

    react(id, emoji, menu){
    fetch(`/chat/${id}/reaction`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf
        },
        body: JSON.stringify({ emoji })
    }).then(() => {
        menu.remove();
    });
},


    scrollToBottom(){
        const el = document.getElementById('messages');
        el.scrollTop = el.scrollHeight;
    }
};

// === Unread Messages ===
window.Unread = {
    async loadAll() {
    try {
        const res = await fetch('/unreadChat');

        if (!res.ok) {
            console.warn(`Failed to load unread messages: ${res.status}`);
            return; // stop here, don't try to parse
        }

        const data = await res.json(); // directly parse JSON
        data.forEach(row => {
            const el = document.getElementById(`unread-${row.user_id}`);
            if (el) el.textContent = row.unread_count > 0 ? row.unread_count : '';
        });
    } catch (e) {
        console.error(e);
    }
}, 
    increment(userId){
        const el = document.getElementById(`unread-${userId}`);
        if(!el) return;
        let c = parseInt(el.textContent||'0',10); c++;
        el.textContent = c;
        el.style.transform='scale(1.2)';
        setTimeout(()=>el.style.transform='scale(1)',200);
    },
    clear(userId){
        const el = document.getElementById(`unread-${userId}`);
        if(el) el.textContent = '';
    }
};


// === Typing Indicator ===
document.getElementById('messageInput').addEventListener('input', ()=>{
    if(selectedUserId)
        fetch(`/chat/${selectedUserId}/typing`, {method:'POST', headers:{'X-CSRF-TOKEN':csrf}});
});

// === Voice Recording ===
const voiceBtn = document.getElementById('voiceBtn');

const preview = document.getElementById('filePreview');



voiceBtn.onclick = async () => {
    // prevent re-starting if already recording
    if (rec && rec.state === 'recording') return;

    try {
        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
        rec = new MediaRecorder(stream);
        audioChunks = [];
        recordStartTime = Date.now();

        // === Create temporary message bubble ===
        tempVoiceMessageId = 'temp-' + Date.now();
        const messagesEl = document.getElementById('messages');
        const wrap = document.createElement('div');
        wrap.className = 'message-wrapper';
        wrap.id = tempVoiceMessageId;

        const msg = document.createElement('div');
        msg.className = 'message me';
        msg.innerHTML = `
            <div>
                🎙 Recording... 
                <span class="record-duration">00:00</span>
                <button class="stop-send-btn">⏹ Stop & Send</button>
                <button class="cancel-btn">❌ Cancel</button>
            </div>
        `;
        wrap.appendChild(msg);
        messagesEl.appendChild(wrap);
        Chat.scrollToBottom();

        // === Timer update ===
        recordTimerInterval = setInterval(() => {
            const elapsed = Date.now() - recordStartTime;
            const totalSec = Math.floor(elapsed / 1000);
            const min = String(Math.floor(totalSec / 60)).padStart(2, '0');
            const sec = String(totalSec % 60).padStart(2, '0');
            const span = msg.querySelector('.record-duration');
            if (span) span.textContent = `${min}:${sec}`;
        }, 500);

        // === Collect audio chunks ===
        rec.ondataavailable = e => {
            if (e.data.size > 0) audioChunks.push(e.data);
        };

        // === Handle Stop & Send ===
        msg.querySelector('.stop-send-btn').onclick = () => {
            if (rec && rec.state === 'recording') {
                rec.stop();
                clearInterval(recordTimerInterval);
                recordTimerInterval = null;
                voiceBtn.textContent = '🎤';
            }
        };

        // === Handle Cancel ===
        msg.querySelector('.cancel-btn').onclick = () => {
            if (rec && rec.state === 'recording') rec.stop();
            clearInterval(recordTimerInterval);
            recordTimerInterval = null;
            audioChunks = [];
            document.getElementById(tempVoiceMessageId)?.remove();
            voiceBtn.textContent = '🎤';
        };

        // === When recording stops ===
        rec.onstop = async () => {
            if (!audioChunks.length) return;

            const voiceBlob = new Blob(audioChunks, { type: 'audio/ogg' });
            const audioEl = document.createElement('audio');
            audioEl.src = URL.createObjectURL(voiceBlob);

            // Get duration after metadata is loaded
            audioEl.onloadedmetadata = async () => {
                const durationSec = Math.floor(audioEl.duration);
                const min = String(Math.floor(durationSec / 60)).padStart(2, '0');
                const sec = String(durationSec % 60).padStart(2, '0');

                const msgEl = document.getElementById(tempVoiceMessageId);
                if (msgEl) {
                    msgEl.querySelector('.message').innerHTML = `
                        <audio controls src="${audioEl.src}"></audio>
                        <div class="voice-duration">${min}:${sec}</div>
                    `;
                }

                // === Auto-send to backend ===
                const fd = new FormData();
                fd.append('receiver_id', selectedUserId);
                fd.append('voice', voiceBlob, `voice_message.ogg`);
                fd.append('voice_duration', durationSec);

                try {
                    const res = await fetch('/chats', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': csrf },
                        body: fd
                    });
                    const data = await res.json();

                    if (data.message) {
                        // Replace temporary bubble with real message
                        msgEl?.remove();
                        Chat.appendMessage(data.message);
                        Chat.scrollToBottom();
                    }
                } catch (err) {
                    console.error('Voice send failed:', err);
                }

                // cleanup
                audioChunks = [];
                rec = null;
                tempVoiceMessageId = null;
            };
        };

        rec.start();
        voiceBtn.textContent = '⏹️';
    } catch (err) {
        console.error('Microphone access denied or error:', err);
    }
};


// === File Upload ===
document.getElementById('fileInput').onchange = e => {
    const file = e.target.files[0];
    selectedFile = file;

    const preview = document.getElementById('filePreview');
    preview.innerHTML = '';
    if (!file) {
        preview.style.display = 'none';
        return;
    }

    // 🖼️ If it's an image, show thumbnail
    if (file.type.startsWith('image/')) {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.style.maxWidth = '100px';
        img.style.borderRadius = '6px';
        img.style.marginRight = '8px';
        img.onload = () => URL.revokeObjectURL(img.src);
        preview.appendChild(img);
    } 
    // 📄 Otherwise, just show filename
    else {
        const info = document.createElement('span');
        info.textContent = `📎 ${file.name}`;
        preview.appendChild(info);
    }

    // ❌ Add remove button
    const remove = document.createElement('button');
    remove.textContent = '✖';
    remove.style.marginLeft = '10px';
    remove.style.cursor = 'pointer';
    remove.style.background = 'none';
    remove.style.border = 'none';
    remove.style.color = 'red';
    remove.onclick = () => {
        selectedFile = null;
        document.getElementById('fileInput').value = '';
        preview.innerHTML = '';
        preview.style.display = 'none';
    };
    preview.appendChild(remove);

    preview.style.display = 'flex';
    preview.style.alignItems = 'center';
};


// === Send Message ===
document.getElementById('sendBtn').onclick = ()=> Chat.send();

// === Load unread counts on page load ===
document.addEventListener('DOMContentLoaded', ()=> { Unread.loadAll(); });

// === Laravel Echo ===
if(window.Echo){
    window.Echo.private(`chat.${currentUser.id}`)
        .listen('MessageSent', (e)=>{
            const m = e.message;
            if(selectedUserId===m.sender_id){
                Chat.appendMessage(m);
                Chat.scrollToBottom();
                fetch(`/chat/${m.sender_id}/seen`, {method:'POST', headers:{'X-CSRF-TOKEN':csrf}});
            } else { Unread.increment(m.sender_id); }
        })
        .listen('TypingEvent', (e)=>{
            const indicator = document.getElementById('typingIndicator');
            if(selectedUserId===e.user.id){
                indicator.textContent = `${e.user.name} is typing...`;
                setTimeout(()=>indicator.textContent='',1500);
            }
        })
        .listen('MessageReaction', (e) => {
    const msgEl = document.getElementById(`message-${e.messageId}`);
    if (!msgEl) return;

    let container = msgEl.querySelector('.emoji-reactions');
    if (!container) {
        container = document.createElement('div');
        container.className = 'emoji-reactions';
        msgEl.appendChild(container);
    }

    // Avoid duplicates
    const existing = Array.from(container.children).some(span => span.textContent === e.emoji);
    if (!existing) {
        const span = document.createElement('span');
        span.textContent = e.emoji;
        span.title = e.user.name; // optional: show user on hover
        container.appendChild(span);
    }
});


}

// Optional polling for unread
setInterval(()=>{ if(!selectedUserId) Unread.loadAll(); },5000);
</script>


</body>
</html>
