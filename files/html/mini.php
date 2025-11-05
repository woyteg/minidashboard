<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="SVXLink">
    <meta name="theme-color" content="#1e3c72">
    <title>Mobile Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
            min-height: 100vh;
            transition: background 0.5s ease, color 0.5s ease;
        }

        /* Night Theme - Grey/Dark */
        body.night {
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
            color: #e5e7eb;
        }

        /* Day Theme - Blue (original night) */
        body.day {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: #fff;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Theme Toggle */
        .theme-toggle-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            padding: 6px 12px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            width: 100%;
        }

        .opensource-credit {
            text-align: center;
            font-size: 0.7em;
            opacity: 0.5;
            padding: 20px;
            font-style: italic;
            margin-top: 30px;
        }

        body.day .theme-toggle-container {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .theme-toggle-btn {
            padding: 6px 12px;
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            font-size: 0.85em;
            border: 2px solid transparent;
            user-select: none;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        body.night .theme-toggle-btn {
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
            border-color: rgba(255, 255, 255, 0.3);
            color: #fff;
        }

        body.day .theme-toggle-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: rgba(255, 255, 255, 0.3);
        }

        body.night .theme-toggle-btn:hover {
            background: linear-gradient(135deg, #475569 0%, #334155 100%);
        }

        body.day .theme-toggle-btn:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }

        .edit-button {
            padding: 6px 12px;
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            font-size: 0.85em;
            border: 2px solid transparent;
            user-select: none;
            text-decoration: none;
            display: inline-block;
        }

        body.night .edit-button {
            background: rgba(245, 158, 11, 0.3);
            color: #fcd34d;
            border-color: rgba(245, 158, 11, 0.4);
        }

        body.day .edit-button {
            background: rgba(245, 158, 11, 0.4);
            color: #fff;
            border-color: rgba(245, 158, 11, 0.5);
        }

        body.night .edit-button:hover {
            background: rgba(245, 158, 11, 0.4);
            border-color: rgba(245, 158, 11, 0.6);
        }

        body.day .edit-button:hover {
            background: rgba(245, 158, 11, 0.5);
            border-color: rgba(245, 158, 11, 0.7);
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
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            position: relative;
            margin: 5% auto;
            padding: 0;
            width: 90%;
            max-width: 700px;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        body.night .modal-content {
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        body.day .modal-content {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .modal-header {
            padding: 20px 25px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 1.5em;
            color: #fff;
        }

        .close {
            color: #fff;
            font-size: 32px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            line-height: 1;
        }

        .close:hover {
            color: #ef4444;
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 20px 25px;
            max-height: 60vh;
            overflow-y: auto;
        }

        .last-call-item {
            padding: 15px;
            margin-bottom: 12px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        body.night .last-call-item {
            background: rgba(55, 65, 81, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        body.day .last-call-item {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .last-call-item:hover {
            transform: translateX(5px);
        }

        body.night .last-call-item:hover {
            background: rgba(55, 65, 81, 0.8);
        }

        body.day .last-call-item:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        .last-call-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .last-call-callsign {
            font-size: 1.3em;
            font-weight: bold;
            color: #fff;
        }

        .last-call-time {
            font-size: 0.9em;
            opacity: 0.7;
        }

        .last-call-tg {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 8px;
        }

        .last-call-tg-number {
            font-size: 1.1em;
            font-weight: bold;
            color: #08dc6e;
        }

        .last-call-tg-name {
            font-size: 0.95em;
            opacity: 0.9;
            text-align: right;
            flex: 1;
            margin-left: 15px;
        }

        @media (max-width: 968px) {
            .modal-content {
                width: 95%;
                margin: 10% auto;
            }
            
            .modal-header h2 {
                font-size: 1.2em;
            }
            
            .last-call-callsign {
                font-size: 1.1em;
            }
        }

        .main-content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        @media (max-width: 968px) {
            .main-content {
                grid-template-columns: 1fr;
            }
            
            .theme-toggle-container {
                padding: 6px 10px;
                gap: 8px;
            }
            
            .theme-toggle-btn, .edit-button {
                padding: 5px 10px;
                font-size: 0.8em;
            }
        }

        .card {
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.5s ease;
        }

        .card#lastHeardCard:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
        }

        body.night .card {
            background: rgba(31, 41, 55, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        body.day .card {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .card h2 {
            margin-bottom: 20px;
            font-size: 1.2em;
            padding-bottom: 10px;
            border-bottom: 2px solid;
        }

        body.night .card h2 {
            border-bottom-color: rgba(255, 255, 255, 0.2);
        }

        body.day .card h2 {
            border-bottom-color: rgba(255, 255, 255, 0.3);
        }

        .last-heard-list {
            max-height: 80vh;
            overflow-y: auto;
        }

        .last-heard-item {
            padding: 12px;
            margin-bottom: 10px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        body.night .last-heard-item {
            background: rgba(55, 65, 81, 0.4);
        }

        body.day .last-heard-item {
            background: rgba(255, 255, 255, 0.05);
        }

        body.night .last-heard-item.active {
            background: rgba(55, 65, 81, 0.6);
        }

        body.day .last-heard-item.active {
            background: rgba(255, 255, 255, 0.05);
        }

        .station-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .callsign {
            font-size: 2.5em;
            font-weight: bold;
        }

        body.night .callsign {
            color: #f3f4f6;
        }

        body.day .callsign {
            color: #ffffff;
        }

        body.night .callsign.active {
            animation: colorBlinkNight 1s infinite;
        }

        body.day .callsign.active {
            animation: colorBlinkDay 1s infinite;
        }

        @keyframes colorBlinkNight {
            0%, 49% { color: #22d3ee; }
            50%, 100% { color: #06b6d4; }
        }

        @keyframes colorBlinkDay {
            0%, 49% { color: #08ff6e; }
            50%, 100% { color: #08dc6e; }
        }

        .timestamp {
            font-size: 0.9em;
        }

        body.night .timestamp {
            color: rgba(229, 231, 235, 0.7);
        }

        body.day .timestamp {
            color: rgba(255, 255, 255, 0.7);
        }

        .talkgroup {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.85em;
            margin-top: 5px;
        }

        body.night .talkgroup {
            background: rgba(6, 182, 212, 0.3);
            color: #cffafe;
        }

        body.day .talkgroup {
            background: rgba(42, 82, 152, 0.6);
        }

        .talkgroup-controls {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 15px;
        }

        .tg-button {
            border: none;
            color: white;
            padding: 15px;
            border-radius: 12px;
            font-size: 1.2em;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
        }

        body.night .tg-button {
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
        }

        body.day .tg-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .tg-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        .tg-button:active {
            transform: translateY(0);
        }

        body.night .tg-button.active {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
            box-shadow: 0 4px 20px rgba(6, 182, 212, 0.4);
        }

        body.day .tg-button.active {
            background: linear-gradient(135deg, #08dc6e 0%, #06b85a 100%);
            box-shadow: 0 4px 20px rgba(8, 220, 110, 0.4);
        }

        .tg-button::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .tg-button:active::before {
            width: 300px;
            height: 300px;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        body.night ::-webkit-scrollbar-track {
            background: rgba(55, 65, 81, 0.3);
            border-radius: 10px;
        }

        body.day ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        body.night ::-webkit-scrollbar-thumb {
            background: rgba(6, 182, 212, 0.5);
            border-radius: 10px;
        }

        body.day ::-webkit-scrollbar-thumb {
            background: rgba(8, 220, 110, 0.5);
            border-radius: 10px;
        }

        body.night ::-webkit-scrollbar-thumb:hover {
            background: rgba(6, 182, 212, 0.7);
        }

        body.day ::-webkit-scrollbar-thumb:hover {
            background: rgba(8, 220, 110, 0.7);
        }

        #connectionStatus {
            text-align: center;
            margin-bottom: 20px;
            padding: 6px;
            border-radius: 10px;
            font-weight: bold;
            font-size: 0.9em;
            transition: all 0.5s ease;
        }
    </style>
</head>
<body class="night">
    <div class="container">
        <div id="connectionStatus">
            <!-- Connection status will be displayed here -->
        </div>
        <div class="main-content">
            <div class="card" id="lastHeardCard" onclick="openLastCallsModal()" style="cursor: pointer;">
                <div class="last-heard-list" id="lastHeardList">
                    <!-- Stations will be populated here -->
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 20px;">
                <div class="card">
                    <div class="talkgroup-controls" id="talkgroupControls">
                        <!-- Talkgroup buttons will be populated here -->
                    </div>
                </div>
                
                <!-- Theme Toggle with Edit Button -->
                <div class="theme-toggle-container">
                    <div class="theme-toggle-btn" onclick="toggleTheme()" id="themeToggleBtn">
                        <span id="themeIcon">🌙</span>
                        <span id="themeText">Night</span>
                    </div>
                    <a href="settings.php" class="edit-button">
                        ⚙️ Edit
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Fixed Footer Copyright -->
    <div class="opensource-credit">
        Copyright © 2025 W9GIL - Open Source
    </div>

    <!-- Last Calls Modal -->
    <div id="lastCallsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>📋 Last 10 Calls</h2>
                <span class="close" onclick="closeLastCallsModal()">&times;</span>
            </div>
            <div class="modal-body" id="lastCallsContent">
                <!-- Last calls will be populated here -->
            </div>
        </div>
    </div>

    <script>
        // Theme Management
        let currentThemeMode = localStorage.getItem('themeMode') || 'night';

        function applyTheme(theme) {
            document.body.className = theme;
            updateConnectionStatusStyle();
            updateThemeToggleButton(theme);
        }

        function updateThemeToggleButton(theme) {
            const icon = document.getElementById('themeIcon');
            const text = document.getElementById('themeText');
            
            if (theme === 'night') {
                icon.textContent = '🌙';
                text.textContent = 'Night';
            } else {
                icon.textContent = '☀️';
                text.textContent = 'Day';
            }
        }

        function toggleTheme() {
            currentThemeMode = currentThemeMode === 'night' ? 'day' : 'night';
            localStorage.setItem('themeMode', currentThemeMode);
            applyTheme(currentThemeMode);
        }

        function setTheme(mode) {
            currentThemeMode = mode;
            localStorage.setItem('themeMode', mode);
            applyTheme(mode);
        }

        // Initialize theme on page load
        window.addEventListener('DOMContentLoaded', () => {
            applyTheme(currentThemeMode);
        });

        // Default talkgroups (will be overridden by user settings if available)
        const defaultTalkgroups = [
            { id: 3109312, name: 'GRUPA 312' },
            { id: 31093121, name: 'W9GIL' },
            { id: 31093123, name: 'K9RCZ' },
            { id: 31093124, name: '441' },
            { id: 260993, name: 'SR9NKU' },
            { id: 260499, name: 'SR9ROBI' }
        ];

        let talkgroups = [];
        let activeTalkgroup = 1;
        let lastHeardStations = [];

        // Load talkgroups from server
        function loadTalkgroups() {
            fetch('talkgroup_config.php')
                .then(response => response.json())
                .then(data => {
                    talkgroups = data;
                    renderTalkgroupButtons();
                })
                .catch(error => {
                    console.error('Error loading talkgroups:', error);
                    // Fallback to defaults if server fails
                    talkgroups = [...defaultTalkgroups];
                    renderTalkgroupButtons();
                });
        }

        // Render talkgroup buttons
        function renderTalkgroupButtons() {
            const container = document.getElementById('talkgroupControls');
            container.innerHTML = ''; // Clear existing buttons
            
            talkgroups.forEach(tg => {
                const button = document.createElement('button');
                button.className = 'tg-button';
                button.innerHTML = `${tg.name}`;
                button.onclick = () => selectTalkgroup(tg.id, button);
                if (tg.id === activeTalkgroup) {
                    button.classList.add('active');
                }
                container.appendChild(button);
            });
        }

        // Select talkgroup
        function selectTalkgroup(tgId, buttonElement) {
            activeTalkgroup = tgId;
            
            // Remove active class from all buttons
            document.querySelectorAll('.tg-button').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Temporarily add active class for visual feedback
            buttonElement.classList.add('active');
            
            // Remove active class after 2 seconds
            setTimeout(() => {
                buttonElement.classList.remove('active');
            }, 2000);
            
            // Send talkgroup change to server
            fetch('include/change_tg.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `talkgroup=${tgId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log(`Successfully switched to TG${tgId}`);
                } else {
                    console.error('Failed to switch talkgroup:', data.error);
                    alert('Failed to switch talkgroup: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error changing talkgroup:', error);
                alert('Error communicating with server');
            });
        }

        // Update last heard list
        function updateLastHeard() {
            const container = document.getElementById('lastHeardList');
            
            if (lastHeardStations.length === 0) {
                container.innerHTML = '<p style="text-align:center; opacity:0.6; padding:20px;">No activity yet...</p>';
                return;
            }

            container.innerHTML = lastHeardStations.map((station, index) => `
                <div class="last-heard-item ${station.active ? 'active' : ''}">
                    <div style="text-align: center;">
                        <div class="callsign ${station.active ? 'active' : ''}">
                            ${station.callsign}
                        </div>
                        <div class="timestamp" style="margin-top: 10px;">${station.time}</div>
                    </div>
                    <div>
                        <div style="margin-top: 15px; text-align: center;">
                            <span class="talkgroup">${station.talkgroup}</span>
                        </div>
                        ${station.tgName ? `<div style="margin-top: 8px; text-align: center; opacity:0.8; font-size: 1.1em;">${station.tgName}</div>` : ''}
                    </div>
                </div>
            `).join('');
        }

        function updateConnectionStatusStyle(status) {
            const statusDiv = document.getElementById('connectionStatus');
            const card = document.getElementById('lastHeardCard');
            const currentTheme = document.body.className;
            
            if (status === 'CONNECTED') {
                if (currentTheme === 'night') {
                    statusDiv.style.background = 'linear-gradient(135deg, #134e4a 0%, #0f766e 100%)';
                    statusDiv.style.border = '2px solid rgba(6, 182, 212, 0.5)';
                    card.style.border = '3px solid #06b6d4';
                    card.style.boxShadow = '0 0 20px rgba(6, 182, 212, 0.4)';
                } else {
                    statusDiv.style.background = 'linear-gradient(135deg, #1e5c3c 0%, #2a8250 100%)';
                    statusDiv.style.border = '2px solid rgba(8, 220, 110, 0.5)';
                    card.style.border = '3px solid #08dc6e';
                    card.style.boxShadow = '0 0 20px rgba(8, 220, 110, 0.4)';
                }
            } else if (status === 'DISCONNECTED') {
                if (currentTheme === 'night') {
                    statusDiv.style.background = 'linear-gradient(135deg, #7f1d1d 0%, #991b1b 100%)';
                    statusDiv.style.border = '2px solid rgba(239, 68, 68, 0.6)';
                    card.style.border = '3px solid #ef4444';
                    card.style.boxShadow = '0 0 20px rgba(239, 68, 68, 0.4)';
                } else {
                    statusDiv.style.background = 'linear-gradient(135deg, #721e1e 0%, #982a2a 100%)';
                    statusDiv.style.border = '2px solid rgba(220, 38, 38, 0.6)';
                    card.style.border = '3px solid #ff0000';
                    card.style.boxShadow = '0 0 20px rgba(255, 0, 0, 0.4)';
                }
            } else if (status === 'CONNECTION ERROR') {
                if (currentTheme === 'night') {
                    statusDiv.style.background = 'linear-gradient(135deg, #713f12 0%, #92400e 100%)';
                    statusDiv.style.border = '2px solid rgba(245, 158, 11, 0.6)';
                    card.style.border = '3px solid #f59e0b';
                    card.style.boxShadow = '0 0 20px rgba(245, 158, 11, 0.4)';
                } else {
                    statusDiv.style.background = 'linear-gradient(135deg, #8a6e1e 0%, #b8942a 100%)';
                    statusDiv.style.border = '2px solid rgba(234, 179, 8, 0.6)';
                    card.style.border = '3px solid #eab308';
                    card.style.boxShadow = '0 0 20px rgba(234, 179, 8, 0.4)';
                }
            } else {
                if (currentTheme === 'night') {
                    statusDiv.style.background = 'linear-gradient(135deg, #374151 0%, #4b5563 100%)';
                    statusDiv.style.border = '2px solid rgba(156, 163, 175, 0.6)';
                    card.style.border = '3px solid #9ca3af';
                    card.style.boxShadow = '0 0 20px rgba(156, 163, 175, 0.2)';
                } else {
                    statusDiv.style.background = 'linear-gradient(135deg, #4a4a4a 0%, #6a6a6a 100%)';
                    statusDiv.style.border = '2px solid rgba(176, 176, 176, 0.6)';
                    card.style.border = '3px solid #b0b0b0';
                    card.style.boxShadow = '0 0 20px rgba(176, 176, 176, 0.2)';
                }
            }
        }

        // Fetch reflector status
        function fetchReflectorStatus() {
            fetch('include/reflector_status.php')
                .then(response => response.json())
                .then(data => {
                    const statusDiv = document.getElementById('connectionStatus');
                    const currentTheme = document.body.className;
                    
                    if (data.status === "Connected") {
                        const dotColor = currentTheme === 'night' ? '#06b6d4' : '#08dc6e';
                        statusDiv.innerHTML = `<span style="display:inline-block;width:12px;height:12px;background:${dotColor};border-radius:50%;margin-right:8px;"></span>CONNECTED - Reflector Online`;
                        updateConnectionStatusStyle('CONNECTED');
                    } else if (data.status === "Not connected") {
                        statusDiv.innerHTML = '<span style="display:inline-block;width:12px;height:12px;background:red;border-radius:50%;margin-right:8px;"></span>DISCONNECTED - Reflector Offline';
                        updateConnectionStatusStyle('DISCONNECTED');
                    } else {
                        statusDiv.innerHTML = '<span style="display:inline-block;width:12px;height:12px;background:#b0b0b0;border-radius:50%;margin-right:8px;"></span>No Reflector Status';
                        updateConnectionStatusStyle('NO STATUS');
                    }
                })
                .catch(error => {
                    console.error('Error fetching reflector status:', error);
                    const statusDiv = document.getElementById('connectionStatus');
                    statusDiv.innerHTML = '<span style="display:inline-block;width:12px;height:12px;background:#eab308;border-radius:50%;margin-right:8px;"></span>CONNECTION ERROR - Cannot reach server';
                    updateConnectionStatusStyle('CONNECTION ERROR');
                });
        }

        // Fetch last heard stations from server
        function fetchLastHeard() {
            fetch('include/lh.php')
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    
                    // Extract table rows
                    const rows = doc.querySelectorAll('table tr');
                    lastHeardStations = [];
                    
                    // Skip header row (index 0), only get first station (index 1)
                    if (rows.length > 1) {
                        const cells = rows[1].querySelectorAll('td');
                        if (cells.length >= 4) {
                            const time = cells[0].textContent.trim();
                            const callsignCell = cells[1];
                            const tgNumber = cells[2].textContent.trim();
                            const tgName = cells[3].textContent.trim();
                            
                            // Extract callsign (remove HTML tags and extra content)
                            let callsign = callsignCell.textContent.trim();
                            
                            // Check if station is transmitting (has talk.gif image)
                            const isActive = callsignCell.innerHTML.includes('talk.gif');
                            
                            lastHeardStations.push({
                                callsign: callsign,
                                time: time,
                                talkgroup: `TG${tgNumber}`,
                                tgName: tgName,
                                active: isActive
                            });
                        }
                    }
                    
                    updateLastHeard();
                })
                .catch(error => {
                    console.error('Error fetching last heard:', error);
                });
        }

        // Last Calls Modal Functions
        function openLastCallsModal() {
            const modal = document.getElementById('lastCallsModal');
            modal.style.display = 'block';
            fetchLastTenCalls();
        }

        function closeLastCallsModal() {
            const modal = document.getElementById('lastCallsModal');
            modal.style.display = 'none';
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('lastCallsModal');
            if (event.target == modal) {
                closeLastCallsModal();
            }
        }

        // Fetch last 10 calls from lh.php
        function fetchLastTenCalls() {
            const contentDiv = document.getElementById('lastCallsContent');
            contentDiv.innerHTML = '<p style="text-align:center; padding:20px;">Loading...</p>';
            
            fetch('include/lh.php')
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    
                    // Extract table rows
                    const rows = doc.querySelectorAll('table tr');
                    const lastCalls = [];
                    
                    // Skip header row (index 0), get up to 10 stations
                    for (let i = 1; i < rows.length && i <= 10; i++) {
                        const cells = rows[i].querySelectorAll('td');
                        if (cells.length >= 4) {
                            const time = cells[0].textContent.trim();
                            const callsignCell = cells[1];
                            const tgNumber = cells[2].textContent.trim();
                            const tgName = cells[3].textContent.trim();
                            
                            // Extract callsign (remove HTML tags and extra content)
                            let callsign = callsignCell.textContent.trim();
                            
                            lastCalls.push({
                                callsign: callsign,
                                time: time,
                                tgNumber: tgNumber,
                                tgName: tgName
                            });
                        }
                    }
                    
                    if (lastCalls.length === 0) {
                        contentDiv.innerHTML = '<p style="text-align:center; opacity:0.6; padding:20px;">No calls recorded yet...</p>';
                    } else {
                        contentDiv.innerHTML = lastCalls.map((call, index) => `
                            <div class="last-call-item">
                                <div class="last-call-header">
                                    <div class="last-call-callsign">${call.callsign}</div>
                                    <div class="last-call-time">${call.time}</div>
                                </div>
                                <div class="last-call-tg">
                                    <div class="last-call-tg-number">TG${call.tgNumber}</div>
                                    <div class="last-call-tg-name">${call.tgName}</div>
                                </div>
                            </div>
                        `).join('');
                    }
                })
                .catch(error => {
                    console.error('Error fetching last calls:', error);
                    contentDiv.innerHTML = '<p style="text-align:center; color:#ef4444; padding:20px;">Error loading calls</p>';
                });
        }

        // Initialize dashboard
        loadTalkgroups();

        // Start fetching data
        fetchReflectorStatus();
        fetchLastHeard();
        
        // Check reflector status every 3 seconds
        setInterval(fetchReflectorStatus, 3000);
        
        // Check transmit status every 1 second for more responsive updates
        setInterval(fetchLastHeard, 1000);
    </script>
</body>
</html>
