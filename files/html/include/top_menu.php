<p style="padding-right: 10px; text-align: right; color:yellow;font-size:19px;"> 
<?php
require_once __DIR__.'/config.php';         
require_once __DIR__.'/tools.php';        
$ip= Get_user_IP();
$net1= cidr_match($ip, "192.168.0.0/16");
$net2= cidr_match($ip, "172.16.0.0/12");
$net3= cidr_match($ip, "127.0.0.0/8");
$net4= cidr_match($ip, "10.0.0.0/8");
$net5= cidr_match($ip, REMOTEIP."/32");

echo "<a href=\"/\" style=\"color:".$color_menu[0]."; font-family: 'Oswald', sans-serif; font-size: 14pt;\">Dashboard</a>";


if (!empty($refApi) && ($net1 == true || $net2 == true || $net3 == true || $net4 == true || $net5 == true)) {
    echo " | <a title=\"Mini mobile dashboard\" href=\"/mini.php\" style=\"color:".$color_menu[1]."; font-family: 'Oswald', sans-serif;font-size: 14pt;\">Mobile Dashboard</a>"; 
}
if ($reflector_active) {
    echo " | <a title=\"Wykaz nazw Talk Group\" href=\"/tg.php\" style=\"color:".$color_menu[2]."; font-family: 'Oswald', sans-serif; font-size: 14pt;\">Talk Group</a>"; 
}
if ($net1 == true || $net2 == true || $net3 == true || $net4 == true || $net5 == true) {

    if ($dtmfctrl != "/dev/null") {
        echo " | <a title=\"Klawiatura DTMF\" href=\"/DTMF.php\" style=\"color:".$color_menu[3]."; font-family: 'Oswald', sans-serif; font-size: 14pt;\">DTMF</a>"; 
    }
    echo " | <a title=\"Nagrywanie QSO\" href=\"/QSORec.php\" style=\"color:".$color_menu[4]."; font-family: 'Oswald', sans-serif; font-size: 14pt;\">QSO Rec</a>"; 
    }
    echo " | <a title=\"Live Map\" target=_top href=\"/LiveMap.php\" style=\"color:".$color_menu[5]."; font-family: 'Oswald', sans-serif; font-size: 14pt;\">Live Map</a>";
    echo " | <a title=\"NEWS\" target=_top href=\"/news.php\" style=\"color:".$color_menu[6]."; font-family: 'Oswald', sans-serif; font-size: 14pt;\">News</a>";
    echo " | <a title=\"Strona FM POLAND\" target=_blank href=\"http://www.fm-poland.pl\" style=\"color:white; font-family: 'Oswald', sans-serif; font-size: 14pt;\">FM POLAND</a>";
    if ($net1 == true || $net2 == true || $net3 == true || $net4 == true || $net5 == true) {

    $wps=trim(shell_exec("cat /etc/svxlink/svxlink.conf |grep \"TX=MultiTx\"|cut -d= -f2"));
    $wpts=trim(shell_exec("cat /etc/svxlink/svxlink.conf |grep \"CONNECT_LOGICS\"|cut -d, -f3"));
    if ($wps === "MultiTx" || $wpts === "RXMonLogic") {
       echo " | <a title=\"SVX WEB RX Monitor\" target=_blank href=\"/player/\" style=\"color:cyan; font-family: 'Oswald', sans-serif; font-size: 14pt;\">RXMon</a>"; 
    }
    echo " | <a title=\"Menu Administracyjne\" href=\"/AdminSVX.php\" style=\"color:#dc4d01; ; font-family: 'Oswald', sans-serif; font-size: 14pt;\">Admin</a> "; 
}
?>
</p>
