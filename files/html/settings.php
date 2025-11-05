<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="SVXLink Settings">
    <meta name="theme-color" content="#1e3c72">
    <title>Talkgroup Settings</title>
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
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            margin-bottom: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2em;
        }

        .back-button {
            padding: 10px 20px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            font-size: 1em;
            border: none;
            color: white;
            text-decoration: none;
            display: inline-block;
        }

        body.night .back-button {
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
        }

        body.day .back-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .card {
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: all 0.5s ease;
        }

        body.night .card {
            background: rgba(31, 41, 55, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        body.day .card {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .tg-config-item {
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        body.night .tg-config-item {
            background: rgba(55, 65, 81, 0.4);
        }

        body.day .tg-config-item {
            background: rgba(255, 255, 255, 0.1);
        }

        .tg-config-item label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 0.9em;
            opacity: 0.8;
        }

        .input-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 2px solid transparent;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        body.night input[type="text"],
        body.night input[type="number"] {
            background: rgba(55, 65, 81, 0.6);
            color: #e5e7eb;
            border-color: rgba(255, 255, 255, 0.1);
        }

        body.day input[type="text"],
        body.day input[type="number"] {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            border-color: rgba(255, 255, 255, 0.2);
        }

        body.night input:focus {
            outline: none;
            border-color: #06b6d4;
            background: rgba(55, 65, 81, 0.8);
        }

        body.day input:focus {
            outline: none;
            border-color: #08dc6e;
            background: rgba(255, 255, 255, 0.3);
        }

        .delete-button {
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9em;
            transition: all 0.3s ease;
            color: white;
        }

        body.night .delete-button {
            background: linear-gradient(135deg, #991b1b 0%, #7f1d1d 100%);
        }

        body.day .delete-button {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        }

        .delete-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
        }

        .tg-config-item .save-button {
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9em;
            transition: all 0.3s ease;
            color: white;
            margin-top: 0;
        }

        body.night .tg-config-item .save-button {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        }

        body.day .tg-config-item .save-button {
            background: linear-gradient(135deg, #08dc6e 0%, #06b85a 100%);
        }

        .tg-config-item .save-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(6, 182, 212, 0.4);
        }

        .add-button,
        .back-button {
            width: 100%;
            padding: 15px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            font-size: 1.1em;
            transition: all 0.3s ease;
            color: white;
            margin-top: 10px;
        }

        body.night .add-button {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
        }

        body.day .add-button {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        body.night .back-button {
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
        }

        body.day .back-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .add-button:hover,
        .back-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        .button-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 15px;
        }

        .success-message {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
            animation: fadeIn 0.5s ease;
        }

        body.night .success-message {
            background: rgba(5, 150, 105, 0.3);
            color: #6ee7b7;
            border: 2px solid rgba(5, 150, 105, 0.5);
        }

        body.day .success-message {
            background: rgba(16, 185, 129, 0.3);
            color: #fff;
            border: 2px solid rgba(16, 185, 129, 0.5);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .info-box {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.9em;
        }

        body.night .info-box {
            background: rgba(6, 182, 212, 0.2);
            border: 2px solid rgba(6, 182, 212, 0.3);
            color: #cffafe;
        }

        body.day .info-box {
            background: rgba(42, 82, 152, 0.3);
            border: 2px solid rgba(42, 82, 152, 0.4);
            color: #fff;
        }

        @media (max-width: 768px) {
            .input-group {
                grid-template-columns: 1fr;
            }

            .button-group {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body class="night">
    <div class="container">
        <div class="header">
            <h1>⚙️ Talkgroup Settings</h1>
        </div>

        <div id="successMessage" style="display: none;" class="success-message">
            Settings saved successfully!
        </div>

        <div class="card">
            <div id="talkgroupList">
                <!-- Talkgroup configuration items will be populated here -->
            </div>

            <button class="add-button" onclick="addTalkgroup()">+ Add Talkgroup Button</button>

            <a href="mini.php" style="text-decoration: none;">
                <button class="back-button" style="width: 100%; margin-top: 15px;">← Back to Dashboard</button>
            </a>
        </div>
    </div>

    <script>
        // Apply saved theme
        const currentTheme = localStorage.getItem('themeMode') || 'night';
        document.body.className = currentTheme;

        // Default talkgroups
        const defaultTalkgroups = [
            { id: 3109312, name: 'GRUPA 312' },
            { id: 31093121, name: 'W9GIL' },
            { id: 31093123, name: 'K9RCZ' },
            { id: 31093124, name: '441' },
            { id: 260993, name: 'SR9NKU' },
            { id: 260499, name: 'SR9ROBI' }
        ];

        let talkgroups = [];
        const MAX_TALKGROUPS = 12;

        // Load talkgroups from server
        function loadTalkgroups() {
            fetch('talkgroup_config.php')
                .then(response => response.json())
                .then(data => {
                    talkgroups = data;
                    renderTalkgroups();
                })
                .catch(error => {
                    console.error('Error loading talkgroups:', error);
                    // Fallback to defaults if server fails
                    talkgroups = [...defaultTalkgroups];
                    renderTalkgroups();
                });
        }

        // Render talkgroup configuration items
        function renderTalkgroups() {
            const container = document.getElementById('talkgroupList');
            container.innerHTML = talkgroups.map((tg, index) => `
                <div class="tg-config-item">
                    <div class="input-group">
                        <div>
                            <label>Button Name</label>
                            <input type="text" 
                                   id="name-${index}" 
                                   value="${tg.name}" 
                                   placeholder="e.g., LOCAL"
                                   maxlength="20">
                        </div>
                        <div>
                            <label>Talkgroup ID</label>
                            <input type="number" 
                                   id="id-${index}" 
                                   value="${tg.id}" 
                                   placeholder="e.g., 3109312"
                                   min="1"
                                   max="99999999">
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 10px;">
                        <button class="save-button" onclick="saveSingleTalkgroup(${index})">💾 Save</button>
                        <button class="delete-button" onclick="deleteTalkgroup(${index})">🗑️ Delete</button>
                    </div>
                </div>
            `).join('');
        }

        // Add new talkgroup
        function addTalkgroup() {
            if (talkgroups.length >= MAX_TALKGROUPS) {
                alert(`Maximum of ${MAX_TALKGROUPS} talkgroups allowed.`);
                return;
            }

            talkgroups.push({
                id: 0,
                name: 'NEW TG'
            });
            renderTalkgroups();
        }

        // Delete talkgroup
        function deleteTalkgroup(index) {
            if (talkgroups.length <= 1) {
                alert('You must have at least one talkgroup button.');
                return;
            }

            if (confirm('Are you sure you want to delete this talkgroup button?')) {
                talkgroups.splice(index, 1);
                
                // Save to server immediately after deleting
                saveAllToServer();
                
                // Re-render the list
                renderTalkgroups();
            }
        }

        // Save single talkgroup
        function saveSingleTalkgroup(index) {
            const nameInput = document.getElementById(`name-${index}`);
            const idInput = document.getElementById(`id-${index}`);

            const name = nameInput.value.trim();
            const id = parseInt(idInput.value);

            if (!name || name.length === 0) {
                alert(`Please enter a name for this button`);
                return;
            }

            if (!id || id <= 0) {
                alert(`Please enter a valid talkgroup ID`);
                return;
            }

            // Update the talkgroup in the array
            talkgroups[index] = { id, name };

            // Save all talkgroups to server
            saveAllToServer();
        }

        // Save all talkgroups to server
        function saveAllToServer() {
            fetch('talkgroup_config.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(talkgroups)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    const successMsg = document.getElementById('successMessage');
                    successMsg.style.display = 'block';
                    setTimeout(() => {
                        successMsg.style.display = 'none';
                    }, 3000);
                    
                    console.log('Settings saved:', talkgroups);
                } else {
                    alert('Failed to save settings: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error saving settings:', error);
                alert('Error communicating with server');
            });
        }

        // Save settings
        function saveSettings() {
            // Collect values from inputs
            const updatedTalkgroups = [];
            let hasError = false;

            talkgroups.forEach((tg, index) => {
                const nameInput = document.getElementById(`name-${index}`);
                const idInput = document.getElementById(`id-${index}`);

                const name = nameInput.value.trim();
                const id = parseInt(idInput.value);

                if (!name || name.length === 0) {
                    alert(`Please enter a name for button ${index + 1}`);
                    hasError = true;
                    return;
                }

                if (!id || id <= 0) {
                    alert(`Please enter a valid talkgroup ID for button ${index + 1}`);
                    hasError = true;
                    return;
                }

                updatedTalkgroups.push({ id, name });
            });

            if (hasError) {
                return;
            }

            // Save to server
            fetch('talkgroup_config.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(updatedTalkgroups)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    talkgroups = updatedTalkgroups;
                    
                    // Show success message
                    const successMsg = document.getElementById('successMessage');
                    successMsg.style.display = 'block';
                    setTimeout(() => {
                        successMsg.style.display = 'none';
                    }, 3000);
                    
                    console.log('Settings saved:', talkgroups);
                } else {
                    alert('Failed to save settings: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error saving settings:', error);
                alert('Error communicating with server');
            });
        }

        // Initialize on page load
        loadTalkgroups();
    </script>
</body>
</html>
