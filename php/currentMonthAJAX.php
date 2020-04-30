<?php
    include_once("../config/https.php");
    include_once("../config/config.php");
    include_once("functions.php");

    $user_ID = $_SESSION['user_ID'];
    $currentDay = $_SESSION['currentDay'];
    $currentMonth = date('m', strtotime($currentDay));
    $currentYear = date('Y', strtotime($currentDay));
    $loops = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
    
    $searchHymioFromDate = date('Y-m-d', strtotime('first day of this month', strtotime($currentDay)));

    // Hae koko kuukauden hymiöt loopilla
    for($i = 0; $i < $loops; $i++){
        $paivaOlio = getDateData($user_ID, $searchHymioFromDate, $DBH);
        $hymiot[$i] = $paivaOlio->user_sleep_quality;
        $searchHymioFromDate = date('Y-m-d', strtotime('+1 day', strtotime($searchHymioFromDate)));
    }

    echo(json_encode($hymiot));
?>