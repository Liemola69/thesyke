<?php
    include_once("../config/https.php");
    include_once("../config/config.php");
    include_once("functions.php");

    $user_ID = $_SESSION['user_ID'];
    $tempDate = $_GET['iconMonth']; //temp day aina yyyy-mm-01
    $currentMonth = date('m', strtotime($tempDate));
    $currentYear = date('Y', strtotime($tempDate));
    
    // Hae kuinka monta päivää kuukaudessa
    $loops = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

    $icons = [];
    
    // Hae koko kuukauden ikonit loopilla
    for($i = 0; $i < $loops; $i++){
        $paivaOlio = getDateData($user_ID, $tempDate, $DBH);
        
        $food[$i] = $paivaOlio->user_food;
        $alcohol[$i] = $paivaOlio->user_alcohol;
        $activity[$i] = $paivaOlio->user_activity;
        $smoke[$i] = $paivaOlio->user_smoke;
        $vitality[$i] = $paivaOlio->user_vitality;
        $coffee[$i] = $paivaOlio->user_stimulant;
        $medicine[$i] = $paivaOlio->user_medicine;
        $stress[$i] = $paivaOlio->user_stress;
        $mood[$i] = $paivaOlio->user_mood;
        $sleepTime[$i] = $paivaOlio->sleep_amount;
        $screentime[$i] = $paivaOlio->user_screen_time;
        $pain[$i] = $paivaOlio->user_pain;
        
        $tempDate = date('Y-m-d', strtotime('+1 day', strtotime($tempDate)));
    }

    $iconsArray = [$food, $alcohol, $activity, $smoke, $vitality, $coffee, $medicine, $stress, $mood, $sleepTime, $screentime, $pain];

    // Laske kuukauden lukuarvojen keskiarvo
    for($i = 0; $i < count($iconsArray); $i++){
        $summa = 0;
        $jakaja = 0;

        foreach($iconsArray[$i] as $value){
            if($value != null){
                $summa += $value;
                $jakaja += 1;
            }
        }

        if($jakaja == 0){
            $icons[] = round($summa / 1);
        } else{
            $icons[] = round($summa / $jakaja);
        }
    }
    
    // Tulosta ikonien kk-keskiarvo JSONina
    echo(json_encode($icons));
?>