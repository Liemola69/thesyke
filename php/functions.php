<?php
    
    // Tulostaa nykyisen päivän. Kääntää muotoon dd-mm-yyyy
    function getDayFormatted($currentDay){
        $pvm = explode("-", $currentDay);
        echo($pvm[2] . "-" . $pvm[1] . "-" . $pvm[0]);
    }

    // Hae päivän data tietokannasta
    function getDayData($currentDay, $DBH){

        $sql = "SELECT * FROM `ts_date` WHERE `date` = " . "'" . $currentDay . "';";
        $kysely = $DBH->prepare($sql);
        $kysely->execute();
        $kysely -> setFetchMode(PDO::FETCH_OBJ);
        $vastaus = $kysely->fetch();

        if($vastaus){
            return $vastaus;
        } else{
            return null;
        }
    }

    // Palauta päivän uniaika formatoituna hh tuntia mm minuuttia
    function getUniAika($paivaOlio){
        if($paivaOlio->sleep_amount == NULL){
            return "- tuntia - min";
        } else{
            $tunnit = $paivaOlio->sleep_amount/3600 % 3600;
            $minuutit = ($paivaOlio->sleep_amount/60) % 60;
            return $tunnit . " tuntia " . $minuutit . " min";
        }
    }

    // Palauta päivän unisyklit
    function getUniSykli($paivaOlio){
        if($paivaOlio->sleep_cycles == NULL){
            return " - ";
        } else{
            return $paivaOlio->sleep_cycles;
        }
    }

    // Muuttaa pääsivun ison hymiön värin unenlaadun mukaan
    function getHymio($paivaOlio){
        $unenLaatu = $paivaOlio->user_sleep_quality;

        if($unenLaatu == 3){
            //fa-laugh
            echo('class="fas fa-laugh hymio" style="color: var(--liikennevaloVihrea);"');
        } elseif($unenLaatu == 2){
            //fa-meh
            echo('class="fas fa-meh hymio" style="color: var(--liikennevaloKeltainen);"');
        } elseif($unenLaatu == 1){
            //fa-frown
            echo('class="fas fa-frown hymio" style="color: var(--liikennevaloPunainen);"');
        }
    }

    // Muuta pääsivun hymiön väri unenlaadun mukaisesti
    function getHymioFromDate($paivaOlio){
        $unenLaatu = $paivaOlio->user_sleep_quality;

        if($unenLaatu == 3){
            //fa-laugh
            echo('class="fas fa-laugh hymio-viikko" style="color: var(--liikennevaloVihrea);"');
        } elseif($unenLaatu == 2){
            //fa-meh
            echo('class="fas fa-meh hymio-viikko" style="color: var(--liikennevaloKeltainen);"');
        } elseif($unenLaatu == 1){
            //fa-frown
            echo('class="fas fa-frown hymio-viikko" style="color: var(--liikennevaloPunainen);"');
        }
    }

    // Palauta edeltävän päivän päivämäärä
    function getPrevDay($currentDay){
        return date('Y-m-d', strtotime('-1 day', strtotime($currentDay)));
    }

    // Palauta seuraavan päivän päivämäärä
    function getNextDay($currentDay){
        return date('Y-m-d', strtotime('+1 day', strtotime($currentDay)));
    }

    // Palauta viikonpäivät taulukkona
    function getWeekDays($currentDay){

        $weekDays = ['monday','tuesday','wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        for($i = 0; $i < 7; $i++){
            $days[$i] = date('Y-m-d', strtotime($weekDays[$i] . ' this week', strtotime($currentDay)));
        }
        
        return $days;
    }

    //** Ikoni funktiot */
    // Ruoka
    function getIconColorFood($value){
        // 5-2 vihreä
        // 1-(-1) keltsi
        // (-2)-(-5)
        if($value > 1){
            echo("var(--liikennevaloVihrea)");
        } elseif($value > (-2)){
            echo("var(--liikennevaloKeltainen)");
        } else{
            echo("var(--liikennevaloPunainen)");
        }
    }

    // Alkoholi
    function getIconColorAlcohol($value){
        if($value > 1){
            echo("var(--liikennevaloVihrea)");
        } elseif($value > (-2)){
            echo("var(--liikennevaloKeltainen)");
        } else{
            echo("var(--liikennevaloPunainen)");
        }
    }

    // Aktiivisuus
    function getIconColorActivity($value){
        echo("var(--liikennevaloHarmaa)");
    }

    // Tupakointi
    function getIconColorSmoke($value){
        // 5-2 vihreä
        // 1-(-1) keltsi
        // (-2)-(-5)
        if($value > 1){
            echo("var(--liikennevaloVihrea)");
        } elseif($value > (-2)){
            echo("var(--liikennevaloKeltainen)");
        } else{
            echo("var(--liikennevaloPunainen)");
        }
    }

    // Vireys
    function getIconColorVitality($value){
        echo("var(--liikennevaloHarmaa)");
    }

    // Piristeet
    function getIconColorStimulant($value){
        // 5-2 vihreä
        // 1-(-1) keltsi
        // (-2)-(-5)
        if($value > 1){
            echo("var(--liikennevaloVihrea)");
        } elseif($value > (-2)){
            echo("var(--liikennevaloKeltainen)");
        } else{
            echo("var(--liikennevaloPunainen)");
        }
    }
    
    // Lääkkeet
    function getIconColorMedicine($value){
        if($value == 1){
            echo("var(--liikennevaloVihrea)");
        } else{
            echo("var(--liikennevaloHarmaa)");
        }
    }

    // Stressi
    function getIconColorStress($value){
        // 5-2 vihreä
        // 1-(-1) keltsi
        // (-2)-(-5)
        if($value > 1){
            echo("var(--liikennevaloVihrea)");
        } elseif($value > (-2)){
            echo("var(--liikennevaloKeltainen)");
        } else{
            echo("var(--liikennevaloPunainen)");
        }
    }

    // Mieliala
    function getIconColorMood($value){
        // 5-2 vihreä
        // 1-(-1) keltsi
        // (-2)-(-5)
        if($value > 1){
            echo("var(--liikennevaloVihrea)");
        } elseif($value > (-2)){
            echo("var(--liikennevaloKeltainen)");
        } else{
            echo("var(--liikennevaloPunainen)");
        }
    }

    // Nukuttu aika
    function getIconColorSleepAmount($value){
        echo("var(--liikennevaloHarmaa)");
    }

    // Päihteet
    function getIconColorDrugs($value){
        if($value == 1){
            echo("var(--liikennevaloPunainen)");
        } else{
            echo("var(--liikennevaloHarmaa)");
        }
    }

    // Kivut
    function getIconColorPains($value){
        // 5-2 vihreä
        // 1-(-1) keltsi
        // (-2)-(-5)
        if($value > 1){
            echo("var(--liikennevaloVihrea)");
        } elseif($value > (-2)){
            echo("var(--liikennevaloKeltainen)");
        } else{
            echo("var(--liikennevaloPunainen)");
        }
    }
?>