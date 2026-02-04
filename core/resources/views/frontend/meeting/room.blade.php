<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $meeting->title }} - DBIM Meeting</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1754cf;
            --primary-glow: rgba(23, 84, 207, 0.4);
            --bg-dark: #0a0a0f;
            --bg-card: #15151e;
            --bg-card-hover: #1c1c28;
            --border: #2a2a3a;
            --text: #ffffff;
            --text-muted: #8b8b9e;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-dark);
            color: var(--text);
            height: 100vh;
            overflow: hidden;
        }

        /* Layout */
        .meeting-container {
            display: grid;
            grid-template-rows: auto 1fr auto;
            height: 100vh;
        }

        /* Top Bar */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            background: linear-gradient(180deg, rgba(21, 21, 30, 0.95) 0%, transparent 100%);
            position: relative;
            z-index: 100;
        }

        .meeting-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .meeting-info h1 {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--text);
        }

        .meeting-badge {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.375rem 0.75rem;
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.3);
            border-radius: 100px;
            font-size: 0.75rem;
            color: var(--success);
        }

        .meeting-badge .dot {
            width: 6px;
            height: 6px;
            background: var(--success);
            border-radius: 50%;
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }

        .top-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            font-size: 0.8125rem;
            font-weight: 600;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
        }

        .btn-secondary {
            background: var(--bg-card);
            color: var(--text-muted);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: var(--bg-card-hover);
            color: var(--text);
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            filter: brightness(1.1);
        }

        /* Video Grid */
        .video-area {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
            position: relative;
            overflow: hidden;
        }

        .video-grid {
            display: grid;
            gap: 1rem;
            width: 100%;
            max-width: 1400px;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }

        /* 2 participants: side by side */
        .video-grid[data-count="2"] {
            grid-template-columns: 1fr 1fr;
        }

        /* 3-4 participants: 2x2 */
        .video-grid[data-count="3"],
        .video-grid[data-count="4"] {
            grid-template-columns: 1fr 1fr;
            max-width: 1000px;
        }

        .video-tile {
            position: relative;
            background: var(--bg-card);
            border-radius: 1rem;
            overflow: hidden;
            aspect-ratio: 16/9;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .video-tile:hover {
            border-color: var(--border);
        }

        .video-tile.speaking {
            border-color: var(--primary);
            box-shadow: 0 0 30px var(--primary-glow);
        }

        .video-tile video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .video-tile .avatar-placeholder {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        }

        .avatar-circle {
            width: 80px;
            height: 80px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 700;
            color: white;
        }

        .video-label {
            position: absolute;
            bottom: 0.75rem;
            left: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .name-tag {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            padding: 0.375rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.8125rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .mic-status {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            border-radius: 50%;
            margin-left: 0.25rem;
        }

        .mic-status svg {
            width: 14px;
            height: 14px;
            fill: var(--success);
        }

        .mic-status.muted svg {
            fill: var(--danger);
        }

        .speaker-indicator {
            display: none;
            background: var(--primary);
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.6875rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .video-tile.speaking .speaker-indicator {
            display: flex;
        }

        .video-actions {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            display: flex;
            gap: 0.5rem;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .video-tile:hover .video-actions {
            opacity: 1;
        }

        .video-action-btn {
            width: 32px;
            height: 32px;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            border: none;
            border-radius: 0.5rem;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            transition: background 0.15s ease;
        }

        .video-action-btn:hover {
            background: rgba(0, 0, 0, 0.8);
        }

        /* Local Video (Floating) */
        .local-video-container {
            position: fixed;
            bottom: 100px;
            right: 1.5rem;
            width: 200px;
            border-radius: 0.75rem;
            overflow: hidden;
            background: var(--bg-card);
            border: 2px solid var(--border);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
            z-index: 200;
            transition: all 0.3s ease;
            cursor: grab;
        }

        .local-video-container.minimized {
            width: 120px;
        }

        .local-video-container.speaking {
            border-color: var(--primary);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5), 0 0 20px var(--primary-glow);
        }

        .local-video-container video {
            width: 100%;
            aspect-ratio: 16/9;
            object-fit: cover;
            display: block;
        }

        .local-video-controls {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 0.5rem;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .local-name {
            font-size: 0.6875rem;
            font-weight: 600;
            color: white;
        }

        .minimize-btn {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            padding: 0.25rem;
            opacity: 0.7;
            transition: opacity 0.15s ease;
        }

        .minimize-btn:hover {
            opacity: 1;
        }

        /* Control Bar */
        .control-bar {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
            background: linear-gradient(0deg, rgba(10, 10, 15, 0.98) 0%, transparent 100%);
            position: relative;
            z-index: 100;
        }

        .controls-center {
            display: flex;
            gap: 0.5rem;
            padding: 0.5rem;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 1rem;
        }

        .control-btn {
            width: 48px;
            height: 48px;
            border-radius: 0.75rem;
            border: none;
            background: transparent;
            color: var(--text);
            font-size: 1.25rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s ease;
        }

        .control-btn:hover {
            background: var(--bg-card-hover);
        }

        .control-btn.active {
            background: rgba(255, 255, 255, 0.1);
        }

        .control-btn.muted {
            background: rgba(239, 68, 68, 0.2);
            color: var(--danger);
        }

        .control-btn.end-call {
            background: var(--danger);
            color: white;
            width: auto;
            padding: 0 1.25rem;
            gap: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .control-btn.end-call:hover {
            filter: brightness(1.1);
        }

        /* Side Panels */
        .side-panel {
            position: fixed;
            top: 0;
            right: -400px;
            width: 380px;
            height: 100vh;
            background: var(--bg-card);
            border-left: 1px solid var(--border);
            z-index: 300;
            display: flex;
            flex-direction: column;
            transition: right 0.3s ease;
        }

        .side-panel.open {
            right: 0;
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem;
            border-bottom: 1px solid var(--border);
        }

        .panel-header h2 {
            font-size: 1rem;
            font-weight: 700;
        }

        .close-btn {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 0.5rem;
            font-size: 1.25rem;
            transition: color 0.15s ease;
        }

        .close-btn:hover {
            color: var(--text);
        }

        .panel-body {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
        }

        .panel-footer {
            padding: 1rem;
            border-top: 1px solid var(--border);
        }

        /* Chat Messages */
        .chat-message {
            margin-bottom: 1rem;
        }

        .chat-message .sender {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 0.25rem;
        }

        .chat-message .content {
            background: var(--bg-dark);
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            line-height: 1.5;
        }

        .chat-message.private .sender {
            color: var(--danger);
        }

        .chat-input-row {
            display: flex;
            gap: 0.5rem;
        }

        .chat-input {
            flex: 1;
            background: var(--bg-dark);
            border: 1px solid var(--border);
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            color: var(--text);
            font-family: inherit;
            font-size: 0.875rem;
            outline: none;
            transition: border-color 0.15s ease;
        }

        .chat-input:focus {
            border-color: var(--primary);
        }

        .send-btn {
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 0.5rem;
            padding: 0 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: filter 0.15s ease;
        }

        .send-btn:hover {
            filter: brightness(1.1);
        }

        /* Context Menu */
        .context-menu {
            position: fixed;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 0.75rem;
            padding: 0.5rem;
            min-width: 180px;
            z-index: 1000;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
            display: none;
        }

        .context-menu-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.625rem 0.875rem;
            font-size: 0.8125rem;
            color: var(--text);
            border-radius: 0.5rem;
            cursor: pointer;
            transition: background 0.15s ease;
        }

        .context-menu-item:hover {
            background: var(--bg-card-hover);
        }

        .context-menu-item.danger {
            color: var(--danger);
        }

        /* Settings Panel */
        .settings-section {
            margin-bottom: 1.5rem;
        }

        .settings-section label {
            display: block;
            font-size: 0.6875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
        }

        .settings-select {
            width: 100%;
            background: var(--bg-dark);
            border: 1px solid var(--border);
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            color: var(--text);
            font-family: inherit;
            font-size: 0.875rem;
            outline: none;
            cursor: pointer;
        }

        .settings-select:focus {
            border-color: var(--primary);
        }

        /* Status Badge */
        #connectionStatus {
            position: fixed;
            top: 1rem;
            left: 50%;
            transform: translateX(-50%);
            background: var(--bg-card);
            border: 1px solid var(--border);
            padding: 0.5rem 1rem;
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 500;
            z-index: 100;
            display: none;
        }

        #connectionStatus.show {
            display: block;
        }

        /* Animations */
        @keyframes speaking-pulse {
            0%, 100% { box-shadow: 0 0 30px var(--primary-glow); }
            50% { box-shadow: 0 0 50px var(--primary-glow); }
        }

        .video-tile.speaking {
            animation: speaking-pulse 2s infinite;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .video-grid {
                grid-template-columns: 1fr;
            }
            
            .local-video-container {
                width: 120px;
                bottom: 90px;
                right: 0.75rem;
            }

            .side-panel {
                width: 100%;
                right: -100%;
            }

            .control-btn {
                width: 44px;
                height: 44px;
            }
        }
    </style>
</head>
<body>
    <div class="meeting-container">
        <!-- Top Bar -->
        <header class="top-bar">
            <div class="meeting-info">
                <h1>{{ $meeting->title }}</h1>
                <div class="meeting-badge">
                    <span class="dot"></span>
                    <span id="statusText">Connecting...</span>
                </div>
            </div>
            <div class="top-actions">
                <button class="btn btn-secondary" onclick="copyRoomLink()">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 5H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-1M8 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M8 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2m0 0h2a2 2 0 0 1 2 2v3"/></svg>
                    Copy Link
                </button>
                @if($meeting->host_id === auth()->id())
                <form action="{{ route('meeting.end', $meeting) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger">End Meeting</button>
                </form>
                @endif
            </div>
        </header>

        <!-- Video Area -->
        <main class="video-area">
            <div class="video-grid" id="videoGrid" data-count="1">
                <!-- Remote videos injected here -->
                <div class="video-tile" id="placeholderTile">
                    <div class="avatar-placeholder">
                        <div class="avatar-circle">
                            <svg width="40" height="40" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        </div>
                    </div>
                    <div class="video-label">
                        <div class="name-tag">Waiting for others...</div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Floating Local Video -->
        <div class="local-video-container" id="localVideoContainer">
            <video id="localVideo" autoplay muted playsinline></video>
            <div class="local-video-controls">
                <span class="local-name">You</span>
                <button class="minimize-btn" onclick="toggleLocalMinimize()">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Control Bar -->
        <footer class="control-bar">
            <div class="controls-center">
                <button class="control-btn" id="micBtn" onclick="toggleMic()" title="Toggle microphone">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg>
                </button>
                <button class="control-btn" id="camBtn" onclick="toggleCam()" title="Toggle camera">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/></svg>
                </button>
                <button class="control-btn" id="screenBtn" onclick="toggleScreen()" title="Share screen">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M21 3H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h5v2h8v-2h5c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 14H3V5h18v12z"/></svg>
                </button>
                <button class="control-btn" id="chatBtn" onclick="toggleChat()" title="Chat">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/></svg>
                </button>
                <button class="control-btn" id="settingsBtn" onclick="toggleSettings()" title="Settings">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M19.14 12.94c.04-.31.06-.63.06-.94 0-.31-.02-.63-.06-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.04.31-.06.63-.06.94s.02.63.06.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/></svg>
                </button>
                <a href="{{ route('meeting.index') }}" class="control-btn end-call">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M12 9c-1.6 0-3.15.25-4.6.72v3.1c0 .39-.23.74-.56.9-.98.49-1.87 1.12-2.66 1.85-.18.18-.43.28-.7.28-.28 0-.53-.11-.71-.29L.29 13.08c-.18-.17-.29-.42-.29-.7 0-.28.11-.53.29-.71C3.34 8.78 7.46 7 12 7s8.66 1.78 11.71 4.67c.18.18.29.43.29.71 0 .28-.11.53-.29.71l-2.48 2.48c-.18.18-.43.29-.71.29-.27 0-.52-.1-.7-.28-.79-.73-1.68-1.36-2.66-1.85-.33-.16-.56-.5-.56-.9v-3.1C15.15 9.25 13.6 9 12 9z"/></svg>
                    Leave
                </a>
            </div>
        </footer>
    </div>

    <!-- Chat Panel -->
    <aside class="side-panel" id="chatPanel">
        <div class="panel-header">
            <h2>Chat</h2>
            <button class="close-btn" onclick="toggleChat()">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="panel-body" id="chatMessages"></div>
        <div class="panel-footer">
            <div class="chat-input-row">
                <input type="text" class="chat-input" id="chatInput" placeholder="Type a message...">
                <button class="send-btn" onclick="sendMessage()">Send</button>
            </div>
        </div>
    </aside>

    <!-- Settings Panel -->
    <aside class="side-panel" id="settingsPanel">
        <div class="panel-header">
            <h2>Settings</h2>
            <button class="close-btn" onclick="toggleSettings()">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="panel-body">
            <div class="settings-section">
                <label>Camera</label>
                <select class="settings-select" id="cameraSelect" onchange="switchCamera()"></select>
            </div>
            <div class="settings-section">
                <label>Microphone</label>
                <select class="settings-select" id="micSelect" onchange="switchMic()"></select>
            </div>
        </div>
    </aside>

    <!-- Context Menu -->
    <div class="context-menu" id="contextMenu">
        <div class="context-menu-item" id="menuPrivateChat">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/></svg>
            Private message
        </div>
        <div class="context-menu-item" id="menuInviteSpeaker">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg>
            Invite to speak
        </div>
        <div class="context-menu-item danger" id="menuMute">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M16.5 12c0-1.77-1.02-3.29-2.5-4.03v2.21l2.45 2.45c.03-.2.05-.41.05-.63zm2.5 0c0 .94-.2 1.82-.54 2.64l1.51 1.51C20.63 14.91 21 13.5 21 12c0-4.28-2.99-7.86-7-8.77v2.06c2.89.86 5 3.54 5 6.71zM4.27 3L3 4.27 7.73 9H3v6h4l5 5v-6.73l4.25 4.25c-.67.52-1.42.93-2.25 1.18v2.06c1.38-.31 2.63-.95 3.69-1.81L19.73 21 21 19.73l-9-9L4.27 3zM12 4L9.91 6.09 12 8.18V4z"/></svg>
            Mute
        </div>
    </div>

    <!-- Connection Status -->
    <div id="connectionStatus"></div>

    <script src="https://unpkg.com/peerjs@1.5.2/dist/peerjs.min.js"></script>
    <script>
        // Constants
        const roomCode = '{{ $meeting->room_code }}'.replace(/[^a-zA-Z0-9]/g, '');
        const userId = '{{ auth()->id() }}';
        const userName = '{{ auth()->user()->name }}';
        const isHost = {{ $meeting->host_id === auth()->id() ? 'true' : 'false' }};
        const hostPeerId = `DBIM_ROOM_${roomCode}_HOST`;

        // State
        let localStream = null;
        let peer = null;
        let activeCalls = {};
        let dataConnections = {};
        let peerNames = {};
        let audioContext = null;
        let localAnalyser = null;
        let remoteAnalysers = {};
        let activeSpeakerId = null;

        const iceConfig = {
            iceServers: [
                { urls: 'stun:stun.l.google.com:19302' },
                { urls: 'turn:openrelay.metered.ca:80', username: 'openrelayproject', credential: 'openrelayproject' },
                { urls: 'turn:openrelay.metered.ca:443', username: 'openrelayproject', credential: 'openrelayproject' }
            ],
            iceCandidatePoolSize: 2
        };

        // Video constraints for lower bandwidth
        const videoConstraints = {
            video: { width: { ideal: 640 }, height: { ideal: 480 }, frameRate: { ideal: 24, max: 30 } },
            audio: { echoCancellation: true, noiseSuppression: true, autoGainControl: true }
        };

        // UI Helpers
        function setStatus(text) {
            document.getElementById('statusText').innerText = text;
        }

        function showToast(msg) {
            const el = document.getElementById('connectionStatus');
            el.innerText = msg;
            el.classList.add('show');
            setTimeout(() => el.classList.remove('show'), 3000);
        }

        function updateGridCount() {
            const count = document.querySelectorAll('#videoGrid .video-tile:not(#placeholderTile)').length + 1;
            document.getElementById('videoGrid').setAttribute('data-count', Math.min(count, 6));
        }

        // Panel Toggles
        function toggleChat() {
            document.getElementById('settingsPanel').classList.remove('open');
            document.getElementById('chatPanel').classList.toggle('open');
        }

        function toggleSettings() {
            document.getElementById('chatPanel').classList.remove('open');
            document.getElementById('settingsPanel').classList.toggle('open');
        }

        function toggleLocalMinimize() {
            document.getElementById('localVideoContainer').classList.toggle('minimized');
        }

        // Draggable Local Video
        (function() {
            const el = document.getElementById('localVideoContainer');
            let isDragging = false, offsetX, offsetY;

            el.addEventListener('mousedown', (e) => {
                if (e.target.closest('button')) return;
                isDragging = true;
                offsetX = e.clientX - el.offsetLeft;
                offsetY = e.clientY - el.offsetTop;
                el.style.cursor = 'grabbing';
            });

            document.addEventListener('mousemove', (e) => {
                if (!isDragging) return;
                el.style.left = (e.clientX - offsetX) + 'px';
                el.style.top = (e.clientY - offsetY) + 'px';
                el.style.right = 'auto';
                el.style.bottom = 'auto';
            });

            document.addEventListener('mouseup', () => {
                isDragging = false;
                el.style.cursor = 'grab';
            });
        })();

        // Audio Analysis
        function setupAudioAnalysis(stream, pId = 'local') {
            if (!audioContext) audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const source = audioContext.createMediaStreamSource(stream);
            const analyser = audioContext.createAnalyser();
            analyser.fftSize = 256;
            source.connect(analyser);
            if (pId === 'local') localAnalyser = analyser;
            else remoteAnalysers[pId] = analyser;
        }

        function startSpeakerDetection() {
            const data = new Uint8Array(128);
            setInterval(() => {
                let loudest = null, max = 0;

                if (localAnalyser) {
                    localAnalyser.getByteFrequencyData(data);
                    let avg = data.reduce((a, b) => a + b, 0) / data.length;
                    if (avg > 35) { max = avg; loudest = 'local'; }
                }

                for (const [pId, analyser] of Object.entries(remoteAnalysers)) {
                    analyser.getByteFrequencyData(data);
                    let avg = data.reduce((a, b) => a + b, 0) / data.length;
                    if (avg > max && avg > 35) { max = avg; loudest = pId; }
                }

                if (activeSpeakerId !== loudest) {
                    activeSpeakerId = loudest;
                    document.querySelectorAll('.video-tile, .local-video-container').forEach(el => el.classList.remove('speaking'));
                    if (loudest === 'local') {
                        document.getElementById('localVideoContainer').classList.add('speaking');
                    } else if (loudest && document.getElementById(`v-${loudest}`)) {
                        document.getElementById(`v-${loudest}`).classList.add('speaking');
                    }
                }
            }, 600);
        }

        // Context Menu
        let contextTargetPId = null;
        const contextMenu = document.getElementById('contextMenu');

        function showContextMenu(e, pId) {
            e.preventDefault();
            contextTargetPId = pId;
            contextMenu.style.display = 'block';
            contextMenu.style.left = e.clientX + 'px';
            contextMenu.style.top = e.clientY + 'px';
            document.getElementById('menuInviteSpeaker').style.display = isHost ? 'flex' : 'none';
            document.getElementById('menuMute').style.display = isHost ? 'flex' : 'none';
        }

        document.addEventListener('click', () => contextMenu.style.display = 'none');

        document.getElementById('menuPrivateChat').onclick = () => {
            const msg = prompt(`Message to ${peerNames[contextTargetPId] || 'participant'}:`);
            if (msg && dataConnections[contextTargetPId]?.open) {
                dataConnections[contextTargetPId].send({ type: 'PRIVATE_CHAT', name: userName, text: msg });
                appendMessage(`To ${peerNames[contextTargetPId]}`, msg, true);
            }
        };

        document.getElementById('menuMute').onclick = () => {
            if (dataConnections[contextTargetPId]?.open) {
                dataConnections[contextTargetPId].send({ type: 'HOST_CMD', cmd: 'MUTE' });
                showToast('Mute command sent');
            }
        };

        document.getElementById('menuInviteSpeaker').onclick = () => {
            if (dataConnections[contextTargetPId]?.open) {
                dataConnections[contextTargetPId].send({ type: 'HOST_CMD', cmd: 'UNMUTE' });
                showToast('Invite sent');
            }
        };

        // PeerJS
        async function startApp() {
            try {
                setStatus('Accessing camera...');
                localStream = await navigator.mediaDevices.getUserMedia(videoConstraints);
                document.getElementById('localVideo').srcObject = localStream;
                await populateDevices();
                initPeer();
            } catch (err) {
                setStatus('Camera error');
                console.error(err);
            }
        }

        function initPeer() {
            const myId = isHost ? hostPeerId : `DBIM_P_${roomCode}_${userId}_${Date.now() % 10000}`;
            peer = new Peer(myId, { host: '0.peerjs.com', port: 443, path: '/', secure: true, config: iceConfig });

            peer.on('open', () => {
                setStatus(isHost ? 'Meeting Live' : 'Connected');
                if (!isHost) connectToHost();
            });

            peer.on('call', (call) => { call.answer(localStream); handleCall(call); });
            peer.on('connection', (conn) => setupDataConnection(conn));
            peer.on('error', (err) => { setStatus('Connection error'); console.error(err); });
        }

        function connectToHost() {
            callPeer(hostPeerId);
            connectDataToPeer(hostPeerId);
        }

        function callPeer(pId) {
            if (activeCalls[pId]) return;
            const call = peer.call(pId, localStream);
            if (call) handleCall(call);
        }

        function connectDataToPeer(pId) {
            if (dataConnections[pId]) return;
            const conn = peer.connect(pId, { reliable: true });
            if (conn) setupDataConnection(conn);
        }

        function handleCall(call) {
            activeCalls[call.peer] = call;
            
            call.on('stream', (stream) => {
                addVideoTile(call.peer, stream);
            });
            
            call.on('close', () => {
                console.log('Call closed:', call.peer);
                removeVideoTile(call.peer);
            });
            
            call.on('error', (err) => {
                console.error('Call error:', call.peer, err);
                removeVideoTile(call.peer);
            });

            // Monitor ICE connection state for disconnections
            if (call.peerConnection) {
                call.peerConnection.oniceconnectionstatechange = () => {
                    const state = call.peerConnection.iceConnectionState;
                    console.log(`ICE state for ${call.peer}:`, state);
                    if (state === 'disconnected' || state === 'failed' || state === 'closed') {
                        setTimeout(() => {
                            // Check if still disconnected after 3 seconds
                            if (call.peerConnection && 
                                (call.peerConnection.iceConnectionState === 'disconnected' || 
                                 call.peerConnection.iceConnectionState === 'failed' ||
                                 call.peerConnection.iceConnectionState === 'closed')) {
                                console.log('Removing stale connection:', call.peer);
                                removeVideoTile(call.peer);
                            }
                        }, 3000);
                    }
                };
            }
        }

        function setupDataConnection(conn) {
            dataConnections[conn.peer] = conn;
            conn.on('open', () => {
                conn.send({ type: 'IDENTITY', peerId: peer.id, name: userName, isHost });
                if (isHost) broadcastPeerList();
            });
            conn.on('data', handleData);
            conn.on('close', () => {
                console.log('Data connection closed:', conn.peer);
                removeVideoTile(conn.peer);
            });
            conn.on('error', (err) => {
                console.error('Data connection error:', conn.peer, err);
                removeVideoTile(conn.peer);
            });
        }

        function handleData(data) {
            if (data.type === 'IDENTITY') {
                peerNames[data.peerId] = data.name;
                updateVideoName(data.peerId, data.name);
                if (isHost) broadcastPeerList();
            } else if (data.type === 'PEER_LIST' && !isHost) {
                data.peers.forEach(p => {
                    if (p.peerId !== peer.id && !activeCalls[p.peerId]) {
                        callPeer(p.peerId);
                        connectDataToPeer(p.peerId);
                    }
                });
            } else if (data.type === 'CHAT') {
                appendMessage(data.name, data.text);
                notifyChat();
            } else if (data.type === 'PRIVATE_CHAT') {
                appendMessage(`From ${data.name}`, data.text, true);
                notifyChat();
            } else if (data.type === 'HOST_CMD') {
                if (data.cmd === 'MUTE') {
                    localStream.getAudioTracks().forEach(t => t.enabled = false);
                    document.getElementById('micBtn').classList.add('muted');
                    showToast('You were muted by host');
                    broadcastMicStatus(false);
                } else if (data.cmd === 'UNMUTE') {
                    localStream.getAudioTracks().forEach(t => t.enabled = true);
                    document.getElementById('micBtn').classList.remove('muted');
                    showToast('Host invited you to speak');
                    broadcastMicStatus(true);
                }
            } else if (data.type === 'MIC_STATUS') {
                updateMicStatus(data.peerId, data.micOn);
            }
        }

        function broadcastPeerList() {
            const list = Object.keys(activeCalls).map(pId => ({ peerId: pId, name: peerNames[pId] || 'Unknown' }));
            list.push({ peerId: peer.id, name: userName });
            Object.values(dataConnections).forEach(c => { if (c.open) c.send({ type: 'PEER_LIST', peers: list }); });
        }

        // Video Tiles
        function addVideoTile(pId, stream) {
            if (document.getElementById(`v-${pId}`)) return;
            
            const placeholder = document.getElementById('placeholderTile');
            if (placeholder) placeholder.remove();

            const tile = document.createElement('div');
            tile.id = `v-${pId}`;
            tile.className = 'video-tile';
            tile.oncontextmenu = (e) => showContextMenu(e, pId);

            const video = document.createElement('video');
            video.srcObject = stream;
            video.autoplay = true;
            video.playsInline = true;

            const label = document.createElement('div');
            label.className = 'video-label';
            label.innerHTML = `
                <div class="name-tag">${peerNames[pId] || 'Connecting...'}</div>
                <div class="mic-status" id="mic-${pId}">
                    <svg viewBox="0 0 24 24"><path d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/><path d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/></svg>
                </div>
                <div class="speaker-indicator">Speaking</div>
            `;

            tile.appendChild(video);
            tile.appendChild(label);
            document.getElementById('videoGrid').appendChild(tile);
            updateGridCount();

            // Auto-minimize local if many participants
            if (Object.keys(activeCalls).length >= 2) {
                document.getElementById('localVideoContainer').classList.add('minimized');
            }
        }

        function removeVideoTile(pId) {
            document.getElementById(`v-${pId}`)?.remove();
            delete activeCalls[pId];
            delete dataConnections[pId];
            delete remoteAnalysers[pId];
            updateGridCount();
        }

        function updateVideoName(pId, name) {
            const nameTag = document.querySelector(`#v-${pId} .name-tag`);
            if (nameTag) nameTag.innerText = name;
        }

        // Chat
        function appendMessage(sender, text, isPrivate = false) {
            const container = document.getElementById('chatMessages');
            const msg = document.createElement('div');
            msg.className = 'chat-message' + (isPrivate ? ' private' : '');
            msg.innerHTML = `<div class="sender">${sender}</div><div class="content">${text}</div>`;
            container.appendChild(msg);
            container.scrollTop = container.scrollHeight;
        }

        function sendMessage() {
            const input = document.getElementById('chatInput');
            const text = input.value.trim();
            if (!text) return;
            appendMessage('You', text);
            Object.values(dataConnections).forEach(c => { if (c.open) c.send({ type: 'CHAT', name: userName, text }); });
            input.value = '';
        }

        function notifyChat() {
            if (!document.getElementById('chatPanel').classList.contains('open')) {
                document.getElementById('chatBtn').style.background = 'rgba(16, 185, 129, 0.3)';
                setTimeout(() => document.getElementById('chatBtn').style.background = '', 2000);
            }
        }

        document.getElementById('chatInput').onkeypress = (e) => { if (e.key === 'Enter') sendMessage(); };

        // Controls
        function toggleMic() {
            const track = localStream.getAudioTracks()[0];
            if (track) {
                track.enabled = !track.enabled;
                document.getElementById('micBtn').classList.toggle('muted', !track.enabled);
                broadcastMicStatus(track.enabled);
            }
        }

        function broadcastMicStatus(micOn) {
            Object.values(dataConnections).forEach(c => {
                if (c.open) c.send({ type: 'MIC_STATUS', peerId: peer.id, micOn });
            });
        }

        function updateMicStatus(peerId, micOn) {
            const micEl = document.getElementById(`mic-${peerId}`);
            if (micEl) {
                if (micOn) {
                    micEl.classList.remove('muted');
                } else {
                    micEl.classList.add('muted');
                }
            }
        }

        function toggleCam() {
            const track = localStream.getVideoTracks()[0];
            if (track) {
                track.enabled = !track.enabled;
                document.getElementById('camBtn').classList.toggle('muted', !track.enabled);
            }
        }

        let screenTrack = null;
        let isScreenSharing = false;

        async function toggleScreen() {
            if (isScreenSharing) {
                // Stop screen sharing
                if (screenTrack) screenTrack.stop();
                document.getElementById('localVideo').srcObject = localStream;
                const camTrack = localStream.getVideoTracks()[0];
                for (const call of Object.values(activeCalls)) {
                    if (call.peerConnection) {
                        const senders = call.peerConnection.getSenders();
                        const videoSender = senders.find(s => s.track && s.track.kind === 'video');
                        if (videoSender && camTrack) {
                            await videoSender.replaceTrack(camTrack);
                        }
                    }
                }
                isScreenSharing = false;
                document.getElementById('screenBtn').classList.remove('active');
                return;
            }

            try {
                const stream = await navigator.mediaDevices.getDisplayMedia({ video: true });
                screenTrack = stream.getVideoTracks()[0];
                
                // Replace track in all active calls
                for (const call of Object.values(activeCalls)) {
                    if (call.peerConnection) {
                        const senders = call.peerConnection.getSenders();
                        const videoSender = senders.find(s => s.track && s.track.kind === 'video');
                        if (videoSender) {
                            await videoSender.replaceTrack(screenTrack);
                        }
                    }
                }
                
                document.getElementById('localVideo').srcObject = stream;
                isScreenSharing = true;
                document.getElementById('screenBtn').classList.add('active');
                
                screenTrack.onended = () => {
                    toggleScreen(); // This will stop sharing
                };
            } catch (e) {
                console.log('Screen share cancelled or failed:', e);
            }
        }

        async function populateDevices() {
            const devices = await navigator.mediaDevices.enumerateDevices();
            const camSel = document.getElementById('cameraSelect');
            const micSel = document.getElementById('micSelect');
            camSel.innerHTML = '';
            micSel.innerHTML = '';
            devices.forEach((d, i) => {
                const opt = document.createElement('option');
                opt.value = d.deviceId;
                opt.text = d.label || `Device ${i + 1}`;
                if (d.kind === 'videoinput') camSel.appendChild(opt);
                else if (d.kind === 'audioinput') micSel.appendChild(opt);
            });
        }

        async function switchCamera() {
            const id = document.getElementById('cameraSelect').value;
            const stream = await navigator.mediaDevices.getUserMedia({ video: { deviceId: { exact: id } } });
            const track = stream.getVideoTracks()[0];
            localStream.getVideoTracks().forEach(t => { localStream.removeTrack(t); t.stop(); });
            localStream.addTrack(track);
            document.getElementById('localVideo').srcObject = localStream;
            Object.values(activeCalls).forEach(c => {
                const sender = c.peerConnection?.getSenders().find(s => s.track?.kind === 'video');
                if (sender) sender.replaceTrack(track);
            });
        }

        async function switchMic() {
            const id = document.getElementById('micSelect').value;
            const stream = await navigator.mediaDevices.getUserMedia({ audio: { deviceId: { exact: id } } });
            const track = stream.getAudioTracks()[0];
            localStream.getAudioTracks().forEach(t => { localStream.removeTrack(t); t.stop(); });
            localStream.addTrack(track);
            Object.values(activeCalls).forEach(c => {
                const sender = c.peerConnection?.getSenders().find(s => s.track?.kind === 'audio');
                if (sender) sender.replaceTrack(track);
            });
        }

        function copyRoomLink() {
            navigator.clipboard.writeText(window.location.href);
            showToast('Link copied!');
        }

        // Start
        startApp();
    </script>
</body>
</html>
