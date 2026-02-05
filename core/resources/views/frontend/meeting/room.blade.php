<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $meeting->title }} - Live Session</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        /* Variables and Base */
        :root {
            --primary: #eca413;
            --bg-light: #f8f7f6;
            --bg-dark: #110f0a;
            --surface-dark: #1c1914;
            --border: rgba(255,255,255,0.1);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-dark);
            color: #f1f5f9;
            height: 100vh;
            overflow: hidden;
        }

        /* Material Symbols Robust Implementation */
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined' !important;
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
            font-feature-settings: 'liga';
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            user-select: none;
            vertical-align: middle;
        }
        .fill-icon { font-variation-settings: 'FILL' 1 !important; }

        /* Components (Tailwind Overrides/Additions) */
        header {
            background: rgba(17, 15, 10, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
        }

        header h1 { font-size: 1.125rem; font-weight: 700; color: white; }
        header p { font-size: 0.75rem; color: #94a3b8; }

        .btn-icon {
            padding: 0.5rem;
            border-radius: 0.5rem;
            background: rgba(255,255,255,0.05);
            color: white;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-icon:hover { background: rgba(255,255,255,0.1); }

        .btn-primary {
            background: var(--primary);
            color: var(--bg-dark);
            font-weight: 700;
            padding: 0.375rem 1rem;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
        }

        /* Main Area */
        main { flex: 1; display: flex; overflow: hidden; position: relative; }
        
        #videoArea {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 1rem;
            gap: 1rem;
            overflow: hidden;
            position: relative;
        }

        #mainStage {
            flex: 1;
            background: black;
            border-radius: 0.75rem;
            overflow: hidden;
            border: 1px solid var(--border);
            position: relative;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            max-height: calc(100vh - 340px);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        #mainStage video { 
            max-width: 100%; 
            max-height: 100%; 
            object-fit: contain; 
        }

        #galleryStrip {
            height: 120px;
            display: flex;
            gap: 0.75rem;
            overflow-x: auto;
            padding-bottom: 0.5rem;
            flex-shrink: 0;
        }

        #galleryStrip::-webkit-scrollbar { height: 6px; }
        #galleryStrip::-webkit-scrollbar-thumb { background: #334155; border-radius: 3px; }

        .thumbnail-tile {
            min-width: 200px;
            aspect-ratio: 16/9;
            background: var(--surface-dark);
            border-radius: 0.5rem;
            overflow: hidden;
            border: 1px solid var(--border);
            cursor: pointer;
            position: relative;
            transition: border-color 0.2s;
        }
        .thumbnail-tile:hover { border-color: rgba(255,255,255,0.3); }
        .thumbnail-tile.speaking-border { border-color: var(--primary) !important; box-shadow: 0 0 15px rgba(236, 164, 19, 0.3); }

        .thumbnail-tile video { width: 100%; height: 100%; object-fit: cover; }
        .thumbnail-label {
            position: absolute; bottom: 0.5rem; left: 0.5rem;
            background: rgba(0,0,0,0.6); backdrop-filter: blur(4px);
            padding: 0.125rem 0.375rem; border-radius: 0.25rem;
            font-size: 0.75rem; font-weight: 500;
        }

        /* Sidebar */
        aside {
            width: 320px;
            background: var(--surface-dark);
            border-left: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }
        aside.closed { width: 0; overflow: hidden; border-left: none; }

        .tabs { display: flex; border-bottom: 1px solid var(--border); }
        .tab-btn {
            flex: 1; padding: 1rem;
            background: transparent; border: none;
            color: #94a3b8; font-size: 0.75rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.05em;
            cursor: pointer; border-bottom: 2px solid transparent;
        }
        .tab-btn.active { color: var(--primary); border-bottom-color: var(--primary); }

        /* Footer */
        footer {
            height: 80px;
            background: rgba(17, 15, 10, 0.9);
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            backdrop-filter: blur(12px);
            z-index: 20;
        }

        .control-btn {
            width: 52px; height: 52px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            background: rgba(255,255,255,0.08);
            color: white; border: 1px solid rgba(255,255,255,0.1);
            cursor: pointer; transition: all 0.2s;
            flex-shrink: 0;
        }
        .control-btn:hover { background: rgba(236, 164, 19, 0.2); color: var(--primary); border-color: var(--primary); }
        .control-btn.active-red { background: #ef4444 !important; color: white !important; border-color: #ef4444 !important; }

        .btn-end {
            background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2);
            padding: 0.5rem 1.5rem; border-radius: 0.5rem; font-weight: 700;
            text-transform: uppercase; font-size: 0.875rem; text-decoration: none; display: inline-block;
        }
        .btn-end:hover { background: #ef4444; color: white; }

        /* Toast Notification */
        #connectionStatus {
            position: fixed; top: 1.5rem; left: 50%; transform: translateX(-50%) translateY(-100px);
            background: rgba(17, 15, 10, 0.95); backdrop-filter: blur(12px); border: 1px solid var(--primary);
            color: white; padding: 0.75rem 1.5rem; border-radius: 9999px; font-weight: 600; font-size: 0.875rem;
            z-index: 9999; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); opacity: 0; pointer-events: none;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
        }
        #connectionStatus.show { transform: translateX(-50%) translateY(0); opacity: 1; }

        /* Badge Overlay */
        .badge {
            position: absolute; top: -5px; right: -5px;
            background: #ef4444; color: white;
            font-size: 10px; font-weight: 900;
            min-width: 18px; height: 18px;
            border-radius: 99px; display: flex; align-items: center; justify-content: center;
            border: 2px solid var(--bg-dark); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.5);
            display: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            header { padding: 0.5rem 1rem; }
            header h1 { font-size: 0.875rem; max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
            header p { display: none; }
            
            main { flex-direction: column; height: calc(100vh - 130px); }
            aside { 
                position: absolute; right: 0; top: 0; bottom: 0; z-index: 30; 
                background: var(--surface-dark); width: 100% !important; 
            }
            #rightSidebar:not(.flex) { display: none !important; }
            
            #mainStage { max-height: 40vh; height: 40vh; flex: none; }
            #videoArea { padding: 0.5rem; gap: 0.5rem; flex: 1; overflow-y: auto; }
            #galleryStrip { height: 90px; }
            .thumbnail-tile { min-width: 140px; }
            
            footer { padding: 0 0.5rem; height: 70px; gap: 0.25rem; }
            .desktop-only { display: none; }
            .control-btn { width: 42px; height: 42px; }
            .material-symbols-outlined { font-size: 20px; }
            .btn-end { padding: 0.4rem 0.6rem; font-size: 0.7rem; }
            .tabs .tab-btn { padding: 0.75rem; font-size: 0.7rem; }
        }
    </style>
</head>
<body>
    
    <!-- Toast -->
    <div id="connectionStatus"></div>

    <!-- Header -->
    <header class="flex justify-between items-center">
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2" style="background: rgba(236,164,19,0.1); padding: 4px 12px; border-radius: 100px; border: 1px solid rgba(236,164,19,0.2);">
                <span style="width: 8px; height: 8px; background: red; border-radius: 50%; display: inline-block;"></span>
                <span id="statusText" style="font-size: 10px; font-weight: 700; color: var(--primary); text-transform: uppercase;">Connecting...</span>
            </div>
            <div>
                <h1>{{ $meeting->title }}</h1>
                <p>Host: {{ $meeting->host->name }}</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <button class="btn-icon" onclick="toggleSettings()">
                <span class="material-symbols-outlined">settings</span>
            </button>
            <button class="btn-primary" onclick="copyRoomLink()">
                <span class="material-symbols-outlined" style="font-size: 18px;">link</span> Invite
            </button>
        </div>
    </header>

    <main>
        <!-- Main Content -->
        <div id="videoArea">
            
            <!-- Main Stage -->
            <div id="mainStage">
                <video id="mainVideo" autoplay playsinline muted></video>
                
                <div class="absolute" style="top: 1rem; left: 1rem;">
                    <div style="background: rgba(0,0,0,0.6); padding: 4px 12px; border-radius: 6px; display: flex; items-center; gap: 6px; border: 1px solid var(--border);">
                        <span class="material-symbols-outlined text-primary fill-icon" style="color: var(--primary); font-size: 16px;">verified</span>
                        <span id="mainLabel" style="font-size: 12px; font-weight: 500;">Active Speaker</span>
                    </div>
                </div>
            </div>

            <!-- Gallery Strip -->
            <div id="galleryStrip">
                <!-- Local User (Self) -->
                <div class="thumbnail-tile" id="thumb-local" onclick="setMainStage('local')">
                    <video id="localVideo" autoplay muted playsinline></video>
                    <div class="thumbnail-label">You</div>
                </div>
                <!-- Remotes added here -->
            </div>
        </div>

        <!-- Sidebar -->
        <aside id="rightSidebar">
            <div class="tabs">
                <button class="tab-btn active" id="tabChat" onclick="switchTab('chat')">Chat</button>
                <button class="tab-btn" id="tabPeople" onclick="switchTab('people')">People</button>
            </div>

            <!-- Chat Content -->
            <div id="chatContainer" style="flex: 1; overflow-y: auto; padding: 1rem; display: flex; flex-direction: column; gap: 0.5rem;"></div>

             <!-- People Content -->
             <div id="peopleContainer" style="display: none; flex: 1; overflow-y: auto; padding: 1rem; display: flex; flex-direction: column; gap: 0.5rem;">
                <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.5rem; background: rgba(255,255,255,0.05); border-radius: 0.5rem;">
                    <div style="width: 32px; height: 32px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; color: black;">{{ substr(auth()->user()->name, 0, 1) }}</div>
                    <span style="font-size: 0.875rem; font-weight: 500;">You ({{ auth()->user()->name }})</span>
                </div>
             </div>

            <!-- Chat Input -->
            <div id="chatInputArea" style="padding: 1rem; background: rgba(255,255,255,0.02); border-top: 1px solid var(--border);">
                <div class="relative" style="display: flex; align-items: center;">
                    <input id="chatInput" placeholder="Message..." type="text" onkeypress="if(event.key === 'Enter') sendMessage()" style="width: 100%; padding: 0.5rem 2.5rem 0.5rem 1rem; background: rgba(0,0,0,0.3); border: 1px solid var(--border); border-radius: 0.5rem; color: white; outline: none;">
                    <button onclick="sendMessage()" style="position: absolute; right: 0.5rem; background: none; border: none; color: var(--primary); cursor: pointer;">
                        <span class="material-symbols-outlined">send</span>
                    </button>
                </div>
            </div>
        </aside>
    </main>

    <!-- Footer Controls -->
    <footer>
        <div class="desktop-only" style="display: flex; flex-direction: column;">
            <span style="font-size: 10px; font-weight: 700; color: #64748b; letter-spacing: 1px; text-transform: uppercase;">Duration</span>
            <span id="durationTimer" style="font-family: monospace; font-size: 14px; font-weight: 700; color: var(--primary);">00:00:00</span>
        </div>

        <div class="flex items-center gap-4">
            <button class="control-btn" id="micBtn" onclick="toggleMic()">
                <span class="material-symbols-outlined">mic</span>
            </button>
            <button class="control-btn" id="camBtn" onclick="toggleCam()">
                <span class="material-symbols-outlined">videocam</span>
            </button>
            <div style="width: 1px; height: 24px; background: rgba(255,255,255,0.1); margin: 0 0.5rem;"></div>
            <button class="control-btn" id="screenBtn" onclick="toggleScreen()">
                <span class="material-symbols-outlined">present_to_all</span>
            </button>
            <button class="control-btn relative" onclick="toggleSidebar()">
                <span class="material-symbols-outlined">chat</span>
                <span id="unreadBadge" class="badge">0</span>
            </button>
        </div>

        <div>
            @if($meeting->host_id === auth()->id())
            <form action="{{ route('meeting.end', $meeting) }}" method="POST">
                @csrf
                <button type="submit" class="btn-end">End Session</button>
            </form>
            @else
            <a href="{{ route('meeting.index') }}" class="btn-end" style="background: rgba(255,255,255,0.1); color: white; border: none;">
                Leave
            </a>
            @endif
        </div>
    </footer>

    <!-- Settings Modal -->
    <div id="settingsModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden flex items-center justify-center">
        <div class="bg-surface-dark border border-white/10 rounded-2xl p-6 w-96 shadow-2xl">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold">Settings</h3>
                <button onclick="toggleSettings()" class="text-slate-400 hover:text-white"><span class="material-symbols-outlined">close</span></button>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Camera</label>
                    <select id="cameraSelect" onchange="switchCamera()" class="w-full bg-black/20 border border-white/10 rounded-lg px-3 py-2 text-sm focus:ring-primary focus:border-primary"></select>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-500 mb-2">Microphone</label>
                    <select id="micSelect" onchange="switchMic()" class="w-full bg-black/20 border border-white/10 rounded-lg px-3 py-2 text-sm focus:ring-primary focus:border-primary"></select>
                </div>
            </div>
        </div>
    </div>

    <!-- WebRTC Logic -->
    <script src="https://unpkg.com/peerjs@1.5.2/dist/peerjs.min.js"></script>
    <script>
        // --- CONFIG & STATE ---
        const roomCode = '{{ $meeting->room_code }}'.replace(/[^a-zA-Z0-9]/g, '');
        const userId = '{{ auth()->id() }}';
        const userName = '{{ auth()->user()->name }}';
        const isHost = {{ $meeting->host_id === auth()->id() ? 'true' : 'false' }};
        const hostPeerId = `DBIM_ROOM_${roomCode}_HOST`;

        let localStream = null;
        let peer = null;
        let activeCalls = {};
        let dataConnections = {};
        let peerNames = {};
        let activeSpeakerId = 'local';
        let startTime = Date.now();
        let isScreenSharing = false;
        let screenTrack = null;

        const mainVideo = document.getElementById('mainVideo');
        const mainLabel = document.getElementById('mainLabel');

        const iceConfig = {
            iceServers: [
                { urls: 'stun:stun.l.google.com:19302' },
                { urls: 'turn:openrelay.metered.ca:80', username: 'openrelayproject', credential: 'openrelayproject' },
                { urls: 'turn:openrelay.metered.ca:443', username: 'openrelayproject', credential: 'openrelayproject' }
            ]
        };

        let unreadMessages = 0;
        let activeTab = 'chat';

        // --- UI FUNCS ---
        function setStatus(text) { document.getElementById('statusText').innerText = text; }
        
        let toastTimeout = null;
        function showToast(msg) {
            const el = document.getElementById('connectionStatus');
            clearTimeout(toastTimeout);
            el.innerText = msg;
            el.classList.add('show');
            toastTimeout = setTimeout(() => el.classList.remove('show'), 3000);
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('rightSidebar');
            const isClosing = !sidebar.classList.contains('hidden');
            
            if (isClosing) {
                sidebar.classList.add('hidden');
                sidebar.classList.remove('flex');
            } else {
                sidebar.classList.remove('hidden');
                sidebar.classList.add('flex');
                if (activeTab === 'chat') resetUnread();
            }
        }
        
        function resetUnread() {
            unreadMessages = 0;
            const badge = document.getElementById('unreadBadge');
            badge.innerText = '0';
            badge.style.display = 'none';
        }

        function updateClock() {
            const elapsed = Math.floor((Date.now() - startTime) / 1000);
            const h = Math.floor(elapsed / 3600).toString().padStart(2, '0');
            const m = Math.floor((elapsed % 3600) / 60).toString().padStart(2, '0');
            const s = (elapsed % 60).toString().padStart(2, '0');
            document.getElementById('durationTimer').innerText = `${h}:${m}:${s}`;
        }
        setInterval(updateClock, 1000);

        function toggleSettings() {
            const modal = document.getElementById('settingsModal');
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                modal.style.display = 'flex';
            } else {
                modal.classList.add('hidden');
                modal.style.display = 'none';
            }
        }

        function switchTab(tab) {
            const chatC = document.getElementById('chatContainer');
            const pplC = document.getElementById('peopleContainer');
            const chatI = document.getElementById('chatInputArea');
            const btnChat = document.getElementById('tabChat');
            const btnPpl = document.getElementById('tabPeople');
            activeTab = tab;

            if (tab === 'chat') {
                chatC.style.display = 'flex'; chatI.style.display = 'block'; pplC.style.display = 'none';
                btnChat.classList.add('active'); btnPpl.classList.remove('active');
                if (!document.getElementById('rightSidebar').classList.contains('hidden')) resetUnread();
            } else {
                chatC.style.display = 'none'; chatI.style.display = 'none'; pplC.style.display = 'flex';
                btnPpl.classList.add('active'); btnChat.classList.remove('active');
            }
        }

        function copyRoomLink() {
            navigator.clipboard.writeText(window.location.href);
            showToast('Link copied to clipboard!');
        }

        // --- VIDEO LOGIC ---
        
        function setMainStage(pId) {
            console.log('Switching main stage to:', pId);
            activeSpeakerId = pId;
            
            // Highlight thumbnail
            document.querySelectorAll('#galleryStrip > div').forEach(el => el.classList.remove('speaking-border'));
            
            if (pId === 'local') {
                if (localStream) {
                    mainVideo.srcObject = localStream;
                    mainVideo.muted = true; // Always mute self on main stage
                    mainLabel.innerText = "You (Active Speaker)";
                    document.getElementById('thumb-local').classList.add('speaking-border');
                }
            } else {
                const call = activeCalls[pId];
                if (call && call.remoteStream) {
                    mainVideo.srcObject = call.remoteStream;
                    mainVideo.muted = false;
                    mainLabel.innerText = peerNames[pId] || "Participant";
                    const tile = document.getElementById(`thumb-${pId}`);
                    if (tile) tile.classList.add('speaking-border');
                }
            }
        }

        function addVideoTile(pId, stream) {
            if (document.getElementById(`thumb-${pId}`)) return;
            
            const gallery = document.getElementById('galleryStrip');
            const tile = document.createElement('div');
            tile.id = `thumb-${pId}`;
            tile.className = 'thumbnail-tile';
            tile.onclick = () => setMainStage(pId);
            
            const vid = document.createElement('video');
            vid.srcObject = stream;
            vid.autoplay = true;
            vid.playsInline = true;
            
            const label = document.createElement('div');
            label.className = 'thumbnail-label';
            label.innerText = peerNames[pId] || 'Participant';
            label.id = `name-${pId}`;

            tile.appendChild(vid);
            tile.appendChild(label);
            gallery.appendChild(tile);
             
            addPeopleEntry(pId, peerNames[pId]);

            if (Object.keys(activeCalls).length === 1) {
                setMainStage(pId);
            }
        }

        function removeVideoTile(pId) {
            document.getElementById(`thumb-${pId}`)?.remove();
            document.getElementById(`person-${pId}`)?.remove();
            if (activeSpeakerId === pId) setMainStage('local');
            delete activeCalls[pId];
            delete dataConnections[pId];
        }

        function addPeopleEntry(pId, name) {
            const container = document.getElementById('peopleContainer');
            const entry = document.createElement('div');
            entry.id = `person-${pId}`;
            entry.className = 'flex items-center gap-3 p-2 hover:bg-white/5 rounded-lg';
            entry.innerHTML = `
                <div class="size-8 rounded-full bg-slate-700 flex items-center justify-center text-xs font-bold">${name ? name.charAt(0) : '?'}</div>
                <span class="text-sm font-medium" id="pname-${pId}">${name || 'Connecting...'}</span>
            `;
            container.appendChild(entry);
        }

        // --- WEBRTC CORE ---
        
        async function startApp() {
            // Check for mobile and hide sidebar if needed
            if (window.innerWidth <= 768) {
                document.getElementById('rightSidebar').classList.add('hidden');
            }

            try {
                setStatus('Accessing camera...');
                localStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
                document.getElementById('localVideo').srcObject = localStream;
                setMainStage('local'); // Default to self
                
                await populateDevices();
                initPeer();
            } catch (err) {
                setStatus('Camera Access Denied');
                console.error(err);
                showToast('Could not access camera/mic');
            }
        }


        function initPeer() {
            const myId = isHost ? hostPeerId : `DBIM_P_${roomCode}_${userId}_${Date.now() % 1000}`;
            peer = new Peer(myId, { config: iceConfig });

            peer.on('open', () => {
                setStatus('Live');
                if (!isHost) connectToHost();
            });

            peer.on('call', (call) => {
                call.answer(localStream);
                handleCall(call);
            });
            
            peer.on('connection', (conn) => setupDataConnection(conn));
            peer.on('error', (err) => {
                console.error(err);
                if (err.type === 'peer-unavailable') {
                    // Retry host connection if failed
                    if (!isHost) setTimeout(connectToHost, 2000);
                }
            });
        }

        function connectToHost() {
            const call = peer.call(hostPeerId, localStream);
            if (call) handleCall(call);
            const conn = peer.connect(hostPeerId);
            if (conn) setupDataConnection(conn);
        }

        function handleCall(call) {
            activeCalls[call.peer] = call;
            call.on('stream', (stream) => { 
                call.remoteStream = stream; // Store for switching
                addVideoTile(call.peer, stream); 
            });
            call.on('close', () => removeVideoTile(call.peer));
            call.on('error', () => removeVideoTile(call.peer));
        }

        function setupDataConnection(conn) {
            dataConnections[conn.peer] = conn;
            conn.on('open', () => {
                conn.send({ type: 'IDENTITY', name: userName });
                if (isHost) broadcastPeerList(); // Helper to share everyone's ID
            });
            conn.on('data', handleData);
            conn.on('close', () => removeVideoTile(conn.peer));
        }

        function handleData(data) {
            if (data.type === 'CHAT') {
                appendMessage(data.name, data.text);
            } else if (data.type === 'IDENTITY') {
                peerNames[this.peer] = data.name;
                updateName(this.peer, data.name);
            }
        }
        
        function updateName(pId, name) {
            if (document.getElementById(`name-${pId}`)) document.getElementById(`name-${pId}`).innerText = name;
            if (document.getElementById(`pname-${pId}`)) document.getElementById(`pname-${pId}`).innerText = name;
            if (activeSpeakerId === pId) mainLabel.innerText = name;
        }

        // --- CONTROLS ---

        // --- CONTROLS ---

        function toggleMic() {
            const track = localStream.getAudioTracks()[0];
            if (track) {
                track.enabled = !track.enabled;
                const btn = document.getElementById('micBtn');
                // Use .active-red for the "off" state
                if (!track.enabled) {
                    btn.classList.add('active-red');
                    btn.innerHTML = '<span class="material-symbols-outlined">mic_off</span>';
                } else {
                    btn.classList.remove('active-red');
                    btn.innerHTML = '<span class="material-symbols-outlined">mic</span>';
                }
            }
        }

        function toggleCam() {
             const track = localStream.getVideoTracks()[0];
            if (track) {
                track.enabled = !track.enabled;
                const btn = document.getElementById('camBtn');
                if (!track.enabled) {
                    btn.classList.add('active-red');
                    btn.innerHTML = '<span class="material-symbols-outlined">videocam_off</span>';
                } else {
                    btn.classList.remove('active-red');
                    btn.innerHTML = '<span class="material-symbols-outlined">videocam</span>';
                }
            }
        }

        async function toggleScreen() {
             if (isScreenSharing) {
                screenTrack.stop();
                screenTrack = null;
                document.getElementById('screenBtn').classList.remove('text-primary'); // This might also need fixing if text-primary isnt a class
                document.getElementById('screenBtn').style.color = ''; // Reset color
                
                // Switch back to camera
                const camTrack = localStream.getVideoTracks().find(t => t.kind === 'video' && t.label !== 'screen'); // Simplified finding
                 // Actually easier to just re-get user media or finding the disabled track
                 // For now, simpler to reload or just get new stream
                 // But let's try replacing track
                 const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                 const newTrack = stream.getVideoTracks()[0];
                 replaceTrackInCalls(newTrack);
                 document.getElementById('localVideo').srcObject = stream; // Preview
                 isScreenSharing = false;
                 return;
            }

            if (!navigator.mediaDevices || !navigator.mediaDevices.getDisplayMedia) {
                showToast('Screen sharing not supported on this device');
                return;
            }

            try {
                const stream = await navigator.mediaDevices.getDisplayMedia({ video: true });
                screenTrack = stream.getVideoTracks()[0];
                replaceTrackInCalls(screenTrack);
                
                // Show screen in local preview too, but muted
                document.getElementById('localVideo').srcObject = stream;
                
                // document.getElementById('screenBtn').classList.add('text-primary'); // FIX: Tailwind class
                document.getElementById('screenBtn').style.color = '#eca413'; // Manual primary color
                
                isScreenSharing = true;

                screenTrack.onended = () => {
                    toggleScreen(); // Handle external stop
                };
            } catch (err) {
                console.log('Screen share cancelled');
            }
        }

        function replaceTrackInCalls(newTrack) {
            Object.values(activeCalls).forEach(call => {
                const sender = call.peerConnection.getSenders().find(s => s.track.kind === 'video');
                if (sender) sender.replaceTrack(newTrack);
            });
            // Update local stream object for future new calls
            const oldVideo = localStream.getVideoTracks()[0];
            if (oldVideo) localStream.removeTrack(oldVideo);
            localStream.addTrack(newTrack);
        }

        // --- CHAT ---
        function appendMessage(sender, text) {
            const sidebar = document.getElementById('rightSidebar');
            const isChatHidden = sidebar.classList.contains('hidden') || activeTab !== 'chat';
            
            if (isChatHidden && sender !== 'You') {
                unreadMessages++;
                const badge = document.getElementById('unreadBadge');
                badge.innerText = unreadMessages > 99 ? '99+' : unreadMessages;
                badge.style.display = 'flex';
            }

            const div = document.createElement('div');
            div.style.display = 'flex';
            div.style.flexDirection = 'column';
            div.style.gap = '4px';
            div.style.marginBottom = '12px';
            
            div.innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 10px; font-weight: 700; color: #94a3b8; text-transform: uppercase;">${sender}</span>
                    <span style="font-size: 10px; opacity: 0.5;">${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>
                </div>
                <div style="background: rgba(255,255,255,0.05); border-radius: 8px; padding: 10px; font-size: 14px; line-height: 1.5; border: 1px solid rgba(255,255,255,0.05); color: #e2e8f0;">
                    ${text}
                </div>
            `;
            const chatC = document.getElementById('chatContainer');
            chatC.appendChild(div);
            // Auto scroll
            chatC.scrollTop = chatC.scrollHeight;
        }

        function sendMessage() {
            const input = document.getElementById('chatInput');
            const text = input.value.trim();
            if (!text) return;
            appendMessage('You', text);
            Object.values(dataConnections).forEach(c => c.send({ type: 'CHAT', name: userName, text }));
            input.value = '';
        }

        // --- DEVICES ---
        async function populateDevices() {
            const devs = await navigator.mediaDevices.enumerateDevices();
            const cSelect = document.getElementById('cameraSelect');
            const mSelect = document.getElementById('micSelect');
            if(!cSelect) return;
            cSelect.innerHTML = ''; mSelect.innerHTML = '';
            
            devs.forEach(d => {
                const opt = document.createElement('option');
                opt.value = d.deviceId;
                opt.text = d.label || d.kind;
                if (d.kind === 'videoinput') cSelect.appendChild(opt);
                if (d.kind === 'audioinput') mSelect.appendChild(opt);
            });
        }
        
        async function switchCamera() {
            const id = document.getElementById('cameraSelect').value;
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: { deviceId: { exact: id } } });
                const newTrack = stream.getVideoTracks()[0];
                replaceTrackInCalls(newTrack);
                
                // Update local preview
                // If local is strictly main stage
                if (mainVideo.srcObject === localStream) {
                   mainVideo.srcObject = stream; 
                }
                 document.getElementById('localVideo').srcObject = stream;
            } catch(e) { console.error(e); }
        }

        async function switchMic() {
            const id = document.getElementById('micSelect').value;
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: { deviceId: { exact: id } } });
                const newTrack = stream.getAudioTracks()[0];
                
                Object.values(activeCalls).forEach(call => {
                    const sender = call.peerConnection.getSenders().find(s => s.track.kind === 'audio');
                    if (sender) sender.replaceTrack(newTrack);
                });
                
                const oldTrack = localStream.getAudioTracks()[0];
                if(oldTrack) localStream.removeTrack(oldTrack);
                localStream.addTrack(newTrack);
            } catch(e) { console.error(e); }
        }

        // Start
        startApp();

    </script>
</body>
</html>
