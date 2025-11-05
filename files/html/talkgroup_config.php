<?php
// talkgroup_config.php - Server-side talkgroup configuration handler

header('Content-Type: application/json');

$configFile = __DIR__ . '/talkgroup_config.json';

// Handle GET request - load configuration
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (file_exists($configFile)) {
        $config = file_get_contents($configFile);
        echo $config;
    } else {
        // Return default configuration if file doesn't exist
        $defaultConfig = [
            ['id' => 3109312, 'name' => 'GRUPA 312'],
            ['id' => 31093121, 'name' => 'W9GIL'],
            ['id' => 31093123, 'name' => 'K9RCZ'],
            ['id' => 31093124, 'name' => '441'],
            ['id' => 260993, 'name' => 'SR9NKU'],
            ['id' => 260499, 'name' => 'SR9ROBI']
        ];
        echo json_encode($defaultConfig);
    }
    exit;
}

// Handle POST request - save configuration
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if ($data === null) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid JSON data']);
        exit;
    }
    
    // Validate data
    if (!is_array($data)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Data must be an array']);
        exit;
    }
    
    // Validate each talkgroup entry
    foreach ($data as $tg) {
        if (!isset($tg['id']) || !isset($tg['name'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Each talkgroup must have id and name']);
            exit;
        }
    }
    
    // Save to file
    $result = file_put_contents($configFile, json_encode($data, JSON_PRETTY_PRINT));
    
    if ($result === false) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Failed to write configuration file']);
    } else {
        echo json_encode(['success' => true, 'message' => 'Configuration saved successfully']);
    }
    exit;
}

// Handle DELETE request - reset to defaults
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if (file_exists($configFile)) {
        unlink($configFile);
    }
    echo json_encode(['success' => true, 'message' => 'Configuration reset to defaults']);
    exit;
}

http_response_code(405);
echo json_encode(['success' => false, 'error' => 'Method not allowed']);
?>
