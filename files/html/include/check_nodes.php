<?php
header('Content-Type: application/json');

// The actual URL that shows connected nodes
$url = 'http://100.72.254.7/include/svxref.php';

$monitoredNodes = [
    'W9GIL-UHF' => 31093121,
    'KE9CPD-UHF' => 31093124,
    'K9RCZ-VHF' => 31093123,
    'SR9NKU' => 260993,
    'SR9ROBI' => 260499
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$html = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($html === false || $httpCode != 200) {
    echo json_encode([
        'error' => 'Could not fetch data', 
        'nodes' => [], 
        'http_code' => $httpCode
    ]);
    exit;
}

$onlineNodes = [];

foreach ($monitoredNodes as $callsign => $tgId) {
    // Check if callsign appears in the connected nodes HTML
    $isOnline = (stripos($html, $callsign) !== false);
    
    $onlineNodes[] = [
        'callsign' => $callsign,
        'tgId' => $tgId,
        'online' => $isOnline
    ];
}

echo json_encode([
    'nodes' => $onlineNodes, 
    'success' => true
]);
?>