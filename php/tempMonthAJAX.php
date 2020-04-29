<?php
    include_once("../config/https.php");
    include_once("../config/config.php");
    include_once("functions.php");

    $user_ID = $_SESSION['user_ID'];
    $tempDay = $_GET['tempMonth']; //temp day aina yyyy-mm-01
    $currentMonth = date('m', strtotime($tempDay));
    $currentYear = date('Y', strtotime($tempDay));
    $loops = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

    // Hae koko kuukauden hymiöt loopilla
    for($i = 0; $i < $loops; $i++){
        $paivaOlio = getDateData($user_ID, $tempDay, $DBH);
        /*if($paivaOlio->user_sleep_quality == null){
            echo "null" . ";";
        } else{
            echo($paivaOlio->user_sleep_quality . ";");
        }*/
        $hymiot[$i] = $paivaOlio->user_sleep_quality;
        
        $tempDay = date('Y-m-d', strtotime('+1 day', strtotime($tempDay)));
    }

    echo(json_encode($hymiot));
?>