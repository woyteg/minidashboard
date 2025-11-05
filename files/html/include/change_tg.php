<?php
require_once __DIR__.'/config.php';         
require_once __DIR__.'/tools.php';

$ip = Get_user_IP();
$net1 = cidr_match($ip, "192.168.0.0/16");
$net2 = cidr_match($ip, "172.16.0.0/12");
$net3 = cidr_match($ip, "127.0.0.0/8");
$net4 = cidr_match($ip, "10.0.0.0/8");
$net5 = cidr_match($ip, REMOTEIP."/32");

if ($net1 || $net2 || $net3 || $net4 || $net5) {
    if (isset($_POST['talkgroup']) && preg_match('/^\d+$/', $_POST['talkgroup'])) {
        $tg = $_POST['talkgroup'];
        $exec = "echo '*91" . $tg . "#' > " . $dtmfctrl . " 2>&1";
        exec($exec, $output);
        echo json_encode(['success' => true, 'talkgroup' => $tg]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid talkgroup']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Unauthorized IP']);
}
?>