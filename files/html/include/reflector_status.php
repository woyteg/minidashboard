<?php
require_once __DIR__.'/config.php';         
require_once __DIR__.'/tools.php';        
require_once __DIR__.'/functions.php';

header('Content-Type: application/json');

if (FMNETWORK == "no active Reflector") {
    $svxrstatus = "No status";
} else {
    $svxrstatus = getSVXRstatus();
}

echo json_encode(['status' => $svxrstatus]);
?>