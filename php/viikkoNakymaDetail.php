<?php
    
    $iconName = [
        "fa-utensils", 
        "fa-glass-cheers", 
        "fa-walking", 
        "fa-smoking", 
        "fa-bed", 
        "fa-mug-hot", 
        "fa-pills", 
        "fa-bolt", 
        "fa-cloud-sun-rain", 
        "fa-clock", 
        "fa-mobile-alt", 
        "fa-band-aid"
    ];

    $date = $currentDay;

    // Hae koko viikon ikonit loopilla omiin taulukoihin
    for($i = 0; $i < 7; $i++){
        $paivaOlio = getDateData($user_ID, $date, $DBH);
        
        $food[$i] = $paivaOlio->user_food;
        $alcohol[$i] = $paivaOlio->user_alcohol;
        $activity[$i] = 0;
        $smoke[$i] = $paivaOlio->user_smoke;
        $vitality[$i] = $paivaOlio->user_vitality;
        $coffee[$i] = $paivaOlio->user_stimulant;
        $medicine[$i] = $paivaOlio->user_medicine;
        $stress[$i] = $paivaOlio->user_stress;
        $mood[$i] = $paivaOlio->user_mood;
        $sleepTime[$i] = $paivaOlio->sleep_amount;
        $screentime[$i] = $paivaOlio->user_screen_time;
        $pain[$i] = $paivaOlio->user_pain;

        $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
    }

    // Tallennetaan viikonikonitaulukot yhteen taulukkoon
    $iconsArray = [$food, $alcohol, $activity, $smoke, $vitality, $coffee, $medicine, $stress, $mood, $sleepTime, $screentime, $pain];

    // Summataan jokaisen taulukon sisältö ja lasketaan keskiarvo
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
    
    // Tulosta ikonit ja indikaattorit väreillä
    for($i = 0; $i < 12; $i++){
        echo('<div class="ikoniWrapper"' . getIndicator($icons[$i]) . '>');
            echo('<i class="fas ' . $iconName[$i] . ' ikoni" ' . getIconColor($iconName[$i], $icons[$i]) . '></i>');
            echo('<i ' . getIndicator($icons[$i]) . '></i>');
        echo('</div>');
    }
?>