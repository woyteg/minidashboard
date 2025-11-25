<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Reflector Watch">
    <meta name="theme-color" content="#1e3c72">
    <title>Reflector Watch</title>
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

        /* Day Theme - Blue */
        body.day {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: #fff;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Theme Toggle Button */
        .theme-toggle {
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1.5em;
            border: 2px solid transparent;
            user-select: none;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Navigation Container - Bottom Layout */
        .nav-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
            padding: 6px 12px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
            margin: 30px auto 0;
        }

        body.day .nav-container {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .nav-button {
            padding: 6px 12px;
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            font-size: 0.85em;
            border: 2px solid transparent;
            user-select: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
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

        body.night .nav-button,
        body.night .theme-toggle-btn {
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
            border-color: rgba(255, 255, 255, 0.3);
            color: #fff;
        }

        body.day .nav-button,
        body.day .theme-toggle-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: rgba(255, 255, 255, 0.3);
        }

        body.night .nav-button:hover,
        body.night .theme-toggle-btn:hover {
            background: linear-gradient(135deg, #475569 0%, #334155 100%);
        }

        body.day .nav-button:hover,
        body.day .theme-toggle-btn:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }


        .header {
            display: none;
        }

        /* Cards */
        .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .card-header {
            display: none;
        }

        /* Connection Status */
        .connection-status {
            font-size: 1em;
            font-weight: 600;
            padding: 12px 20px;
            border-radius: 15px;
            text-align: center;
            transition: all 0.3s ease;
        }

        /* Last Heard */
        .last-heard-content {
            font-size: 2.5em;
            font-weight: 700;
            padding: 40px;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
            text-align: center;
            line-height: 1.6;
        }

        .callsign-display {
            font-size: 3em;
            font-weight: 700;
            letter-spacing: 6px;
            margin: 20px 0;
        }

        .tg-number {
            font-size: 0.6em;
            opacity: 0.8;
            margin-bottom: 10px;
        }

        .tg-name {
            font-size: 1em;
            margin-bottom: 15px;
        }

        .time-display {
            font-size: 0.8em;
            opacity: 0.7;
        }

        /* Flashing callsign animation */
        @keyframes flashText {
            0%, 100% { 
                color: #fff;
                text-shadow: 0 0 15px rgba(16, 185, 129, 0.6);
            }
            50% { 
                color: #10b981;
                text-shadow: 0 0 25px rgba(16, 185, 129, 0.8);
            }
        }

        @keyframes flashTextNight {
            0%, 100% { 
                color: #e5e7eb;
                text-shadow: 0 0 15px rgba(6, 182, 212, 0.6);
            }
            50% { 
                color: #06b6d4;
                text-shadow: 0 0 25px rgba(6, 182, 212, 0.8);
            }
        }

        body.day .transmitting .callsign-display {
            animation: flashText 1s ease-in-out infinite;
        }

        body.night .transmitting .callsign-display {
            animation: flashTextNight 1s ease-in-out infinite;
        }

        .lh-value {
            display: block;
            margin: 15px 0;
        }

        .lh-row {
            display: none;
        }

        .lh-label {
            display: none;
        }

        .no-data {
            text-align: center;
            opacity: 0.6;
            font-style: italic;
        }

        .opensource-credit {
            text-align: center;
            font-size: 0.7em;
            opacity: 0.5;
            padding: 20px;
            font-style: italic;
            margin-top: 30px;
        }

        /* Flashing animation for transmitting */
        @keyframes flash {
            0%, 100% { 
                border-color: #10b981;
                box-shadow: 0 0 20px rgba(16, 185, 129, 0.4);
            }
            50% { 
                border-color: #34d399;
                box-shadow: 0 0 30px rgba(16, 185, 129, 0.6);
            }
        }

        @keyframes flashNight {
            0%, 100% { 
                border-color: #06b6d4;
                box-shadow: 0 0 20px rgba(6, 182, 212, 0.4);
            }
            50% { 
                border-color: #22d3ee;
                box-shadow: 0 0 30px rgba(6, 182, 212, 0.6);
            }
        }

        body.day .card.transmitting {
            animation: flash 1s ease-in-out infinite;
        }

        body.night .card.transmitting {
            animation: flashNight 1s ease-in-out infinite;
        }

        body.day .card.transmitting .last-heard-content {
            background: rgba(16, 185, 129, 0.08);
        }

        body.night .card.transmitting .last-heard-content {
            background: rgba(6, 182, 212, 0.08);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .theme-toggle {
                top: 10px;
                right: 10px;
                width: 45px;
                height: 45px;
                font-size: 1.3em;
            }

            .connection-status {
                font-size: 0.85em;
                padding: 10px 15px;
            }
            
            .last-heard-content {
                font-size: 1.5em;
                padding: 30px 20px;
            }

            .callsign-display {
                font-size: 2em;
                letter-spacing: 2px;
            }
        }
    </style>
</head>
<body class="day">
    <div class="container">
        <div class="header">
            <h1>📡 Reflector Watch</h1>
        </div>

        <!-- Connection Status -->
        <div class="card" id="connectionCard">
            <div class="card-header">Reflector Status</div>
            <div class="connection-status" id="connectionStatus">
                <span style="display:inline-block;width:12px;height:12px;background:#b0b0b0;border-radius:50%;margin-right:8px;"></span>Checking...
            </div>
        </div>

        <!-- Last Heard -->
        <div class="card" id="lastHeardCard">
            <div class="card-header">Last Heard</div>
            <div class="last-heard-content" id="lastHeardContent">
                <div class="no-data">Waiting for transmission...</div>
            </div>
        </div>

        <!-- Navigation Container -->
        <div class="nav-container">
            <div class="theme-toggle-btn" onclick="toggleTheme()" id="themeToggleBtn">
                <span id="themeIcon">🌙</span>
                <span id="themeText">Night</span>
            </div>
            <a href="mini.php" class="nav-button">
                📊 Dashboard
            </a>
        </div>

        <!-- Credit -->
        <div class="opensource-credit">
            Copyright © 2025 W9GIL - Open Source Project
        </div>
    </div>

    <script>
        let lastHeardStations = [];
        let lastTransmissionTimes = {};
        let transmissionStartTimes = {};
        let pttTimerInterval = null;

        // Theme Toggle
        function toggleTheme() {
            const body = document.body;
            const themeIcon = document.getElementById('themeIcon');
            const themeText = document.getElementById('themeText');
            if (body.classList.contains('day')) {
                body.classList.remove('day');
                body.classList.add('night');
                themeIcon.textContent = '☀️';
                themeText.textContent = 'Day';
                localStorage.setItem('theme', 'night');
            } else {
                body.classList.remove('night');
                body.classList.add('day');
                themeIcon.textContent = '🌙';
                themeText.textContent = 'Night';
                localStorage.setItem('theme', 'day');
            }
        }

        // Load saved theme
        const savedTheme = localStorage.getItem('theme') || 'day';
        document.body.className = savedTheme;
        const themeIcon = document.getElementById('themeIcon');
        const themeText = document.getElementById('themeText');
        themeIcon.textContent = savedTheme === 'day' ? '🌙' : '☀️';
        themeText.textContent = savedTheme === 'day' ? 'Night' : 'Day';

        // Format PTT timer duration
        function formatPTTTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        }

        // Update PTT timer display
        function updatePTTTimer(callsign) {
            if (transmissionStartTimes[callsign]) {
                const elapsed = (Date.now() - transmissionStartTimes[callsign]) / 1000;
                return `PTT Timer: ${formatPTTTime(elapsed)}`;
            }
            return '';
        }

        // Update last heard display
        function updateLastHeard() {
            const content = document.getElementById('lastHeardContent');
            const card = document.getElementById('lastHeardCard');
            
            if (lastHeardStations.length > 0) {
                const station = lastHeardStations[0];
                const now = Date.now();
                
                let timeDisplay = '';
                
                // Handle active transmission
                if (station.active) {
                    // Start PTT timer if not already started
                    if (!transmissionStartTimes[station.callsign]) {
                        transmissionStartTimes[station.callsign] = now;
                    }
                    lastTransmissionTimes[station.callsign] = now;
                    
                    // Show PTT Timer while transmitting
                    timeDisplay = updatePTTTimer(station.callsign);
                    
                    // Start timer update interval if not running
                    if (!pttTimerInterval) {
                        pttTimerInterval = setInterval(() => {
                            if (lastHeardStations[0] && lastHeardStations[0].active) {
                                const updatedTime = updatePTTTimer(lastHeardStations[0].callsign);
                                const timeDisplayElement = document.querySelector('.time-display');
                                if (timeDisplayElement) {
                                    timeDisplayElement.textContent = updatedTime;
                                }
                            }
                        }, 100); // Update every 100ms for smooth timer
                    }
                } else {
                    // Transmission stopped
                    // Clear PTT timer interval
                    if (pttTimerInterval) {
                        clearInterval(pttTimerInterval);
                        pttTimerInterval = null;
                    }
                    
                    // Clear start time for this callsign
                    if (transmissionStartTimes[station.callsign]) {
                        delete transmissionStartTimes[station.callsign];
                    }
                    
                    // Check if we should show "Last heard" prefix
                    if (lastTransmissionTimes[station.callsign]) {
                        const secondsSinceTransmission = (now - lastTransmissionTimes[station.callsign]) / 1000;
                        if (secondsSinceTransmission >= 60) {
                            timeDisplay = `Last heard: ${station.time}`;
                        } else {
                            timeDisplay = station.time;
                        }
                    } else {
                        timeDisplay = station.time;
                    }
                }
                
                content.innerHTML = `
                    <div class="callsign-display">${station.callsign}</div>
                    <div class="tg-number">${station.talkgroup}</div>
                    <div class="tg-name">${station.tgName}</div>
                    <div class="time-display">${timeDisplay}</div>
                `;
                
                // Add flashing effect if transmitting
                if (station.active) {
                    card.classList.add('transmitting');
                } else {
                    card.classList.remove('transmitting');
                }
            } else {
                content.innerHTML = '<div class="no-data">Waiting for transmission...</div>';
                card.classList.remove('transmitting');
                
                // Clear PTT timer interval if no stations
                if (pttTimerInterval) {
                    clearInterval(pttTimerInterval);
                    pttTimerInterval = null;
                }
            }
        }

        // Update connection status styling
        function updateConnectionStatusStyle(status) {
            const statusDiv = document.getElementById('connectionStatus');
            const card = document.getElementById('connectionCard');
            const currentTheme = document.body.className;
            
            if (status === 'CONNECTED') {
                if (currentTheme === 'night') {
                    statusDiv.style.background = 'linear-gradient(135deg, #065f46 0%, #047857 100%)';
                    statusDiv.style.border = '2px solid rgba(6, 95, 70, 0.6)';
                    card.style.border = '3px solid #06b6d4';
                    card.style.boxShadow = '0 0 20px rgba(6, 182, 212, 0.4)';
                } else {
                    statusDiv.style.background = 'linear-gradient(135deg, #065f46 0%, #047857 100%)';
                    statusDiv.style.border = '2px solid rgba(16, 185, 129, 0.6)';
                    card.style.border = '3px solid #10b981';
                    card.style.boxShadow = '0 0 20px rgba(16, 185, 129, 0.4)';
                }
            } else if (status === 'DISCONNECTED') {
                if (currentTheme === 'night') {
                    statusDiv.style.background = 'linear-gradient(135deg, #7f1d1d 0%, #991b1b 100%)';
                    statusDiv.style.border = '2px solid rgba(127, 29, 29, 0.6)';
                    card.style.border = '3px solid #dc2626';
                    card.style.boxShadow = '0 0 20px rgba(220, 38, 38, 0.4)';
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

        // Start fetching data
        fetchReflectorStatus();
        fetchLastHeard();
        
        // Check reflector status every 3 seconds
        setInterval(fetchReflectorStatus, 3000);
        
        // Check transmit status every 1 second
        setInterval(fetchLastHeard, 1000);
    </script>
</body>
</html>
