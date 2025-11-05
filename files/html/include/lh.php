<?php
require_once __DIR__.'/config.php';         
require_once __DIR__.'/tools.php';        
require_once __DIR__.'/functions.php';    
setlocale(LC_ALL, ['pl_PL.UTF-8','pl_PL.utf8']);
$json = file_get_contents(__DIR__.'/tgdb.json');
$tgdb_array = json_decode($json,true);
?>
<span style="font-weight: bold;font-size:14px;color:#f3ead3;">
<?php if ($reflector_active) { echo "::&nbsp;Aktywność SVXReflector&nbsp;".$fmnetwork."&nbsp;::"; 
} ?>
</span>
<fieldset class="fframe" style="width:620px;:>
<?php

if ($reflector_active) {
    echo "<form method=\"post\">";
    echo "<table style=\"margin-top:3px;\">";
    echo "<tr height=25px>";
      //echo "<th width=150px>Czas (".date('e').")</th>";
      echo "<th width=80px>Czas</th>";
      echo "<th width=110px>Znak Noda</th>";
      echo "<th width=80px>Numer TG</th>";
      echo "<th width=260px>Nazwa TG</th>";
    echo "</tr>";

    $i = 0;
    for ($i = 0;  ($i <= 24); $i++) { //Last 25 calls
        if (isset($lastHeard[$i])) {
            $listElem = $lastHeard[$i];
            if ($listElem[1] ) {
                //if (isset($svxconfig['GLOBAL']['TIMESTAMP_FORMAT'])) {
                //    $local_time = strftime($svxconfig['GLOBAL']['TIMESTAMP_FORMAT'], strtotime($listElem[0])); 
                //}
                //else {
                //    $local_time = strftime("%d %b, %H:%M:%S", strtotime($listElem[0])); 
                //}
                $local_time = date("M d, g:i A", strtotime($listElem[0]));
                $l_time = ucwords($local_time);
                 echo "<tr height=24px style=\"font-size:12.5px;>\">";
                 echo "<td align=\"left\" style=\"color:white;font-weight:bold;\">".$l_time."</td>";
                if ($listElem[3] == "OFF" ) {$bgcolor=""; $tximg="";
                }
                if ($listElem[3] == "ON" ) {$bgcolor=""; $tximg="<img src=images/talk.gif height=16 alt='TXing' title='TXing' style=\"vertical-align: middle;\">";
                }
                $ref = substr($listElem[1], 0, 3);
                $call=$listElem[1];
                $ssid = strpos($listElem[1], "-");
                if ((!preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $listElem[1]) or $ref=="XLX" or $ref=="YSF" or $ref=="M17" or substr($listElem[1], 0, 2)=="TG" )) {
                    echo "<td ".$bgcolor." align='left' valign='middle' class=mh_call><b>".$listElem[1]."</b>&nbsp;".$tximg."</td>";
                } else {
                    if ($ssid) {
                        $call = substr($listElem[1], 0, $ssid);
                    }
                    echo "<td ".$bgcolor." align=\"left\"><a href=\"http://www.qrz.com/db/".$call."\"  target=\"_blank\" class=\"qrz_link\"><b>".$listElem[1]."</b></a>&nbsp;$tximg</td>";
                }

               $tgnumber = substr($listElem[2],3);
               echo "<td align=\"center\"><span style=\"color:#08dc6e;font-weight:bold;\">".$tgnumber."</span></td>";

               if (array_key_exists($tgnumber,$tgdb_array)) {
               $name=$tgdb_array[$tgnumber];} else  { $name = "-----";}

                if ($tgnumber>=26099900 and $tgnumber<= 26099999) { $name ="🔁 AUTO QSY";
                }
                echo "<td style=\"font-weight:bold;color:white;\" class=\"wrap\"><b>".$name."</b></td>";
                echo"</tr>\n";
            }
        }
    }
    echo "</table>";
    echo "</form>";

} else { 

    if ($system_type=="IS_DUPLEX") { 
        echo "<center>Repeater without connected SVXReflector</center>"; 
        echo "<img src=\"images/ant_tower.png\" width=\"400\">";
    }
    if ($system_type=="IS_SIMPLEX") {
        echo "<center><b>Simplex-Repeater or Hotspot without connected SVXReflector<b></center><br>";
        echo "<img src=\"images/ant_tower.png\" width=\"400\">";
    } 
    else { 
        echo "<center>SVXLINK-System without connected SVXReflector</center>";
    }
}
?>

</fieldset>
