<?php
    include_once("../config/https.php");
    include_once("../config/config.php");
    include_once("functions.php");

    $user_ID = $_SESSION['user_ID'];
    $tempDay = $_GET['tempMonth']; //temp day aina yyyy-mm-01
    $currentMonth = date('m', strtotime($tempDay));
    $currentYear = date('Y', strtotime($tempDay));
    
    // Laske kuinka monta päivää kuukaudessa on
    $loops = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

    // Hae koko kuukauden hymiöt loopilla
    for($i = 0; $i < $loops; $i++){
        $paivaOlio = getDateData($user_ID, $tempDay, $DBH);
        $hymiot[$i] = $paivaOlio->user_sleep_quality;
        $tempDay = date('Y-m-d', strtotime('+1 day', strtotime($tempDay)));
    }

    // Tulosta kuukauden hymiöt kuukausinäkymään JSONina
    echo(json_encode($hymiot));
?>