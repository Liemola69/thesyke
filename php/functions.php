<?php

    
    // Tulostaa nykyisen päivän. Kääntää muotoon dd-mm-yyyy
    function getDayFormatted($currentDay){
        $pvm = explode("-", $currentDay);
        echo($pvm[2] . "-" . $pvm[1] . "-" . $pvm[0]);
    }

    // Hae käyttäjän tiedot tietokannasta
    function getUserData($user_ID, $DBH){
        $sql = "SELECT * FROM `ts_user` WHERE `user_ID` = " . "'" . $user_ID . "';";
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

    // Hae päivän data tietokannasta
    function getDateData($user_ID, $currentDay, $DBH){

        $sql = "SELECT * FROM `ts_date` WHERE `date_user_ID` = '" . $user_ID . "' AND `date` = " . "'" . $currentDay . "';";
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
      // < -2 = punainen 
        // < 2 = && > -2 = keltainen 
        // > 2 = vihreä 
        // Ei täytetty = NULL (default) = harmaa 

    // Ruoka
    function getIconColorFood($value){
        if($value > 2 && $value < 6){
            echo("var(--liikennevaloVihrea)");
        } elseif($value > (-3) && $value < 2){
            echo("var(--liikennevaloKeltainen)");
        } elseif($value < (-2) && $value > (-6)){
            echo("var(--liikennevaloPunainen)");
        }else{
            echo("var(--liikennevaloHarmaa)");
        }
    }

    // Alkoholi
    function getIconColorAlcohol($value){
        if($value > 2 && $value < 6){
            echo("var(--liikennevaloVihrea)");
        } elseif($value > (-3) && $value < 2){
            echo("var(--liikennevaloKeltainen)");
        } elseif($value < (-2) && $value > (-6)){
            echo("var(--liikennevaloPunainen)");
        }else{
            echo("var(--liikennevaloHarmaa)");
        }
    }

    // Vireys
    function getIconColorVitality($value){
        if($value > 2 && $value < 6){
            echo("var(--liikennevaloVihrea)");
        } elseif($value > (-3) && $value < 2){
            echo("var(--liikennevaloKeltainen)");
        } elseif($value < (-2) && $value > (-6)){
            echo("var(--liikennevaloPunainen)");
        }else{
            echo("var(--liikennevaloHarmaa)");
        }
    }

    // Piristeet
    function getIconColorStimulant($value){
        if($value > 2 && $value < 6){
            echo("var(--liikennevaloVihrea)");
        } elseif($value > (-3) && $value < 2){
            echo("var(--liikennevaloKeltainen)");
        } elseif($value < (-2) && $value > (-6)){
            echo("var(--liikennevaloPunainen)");
        }else{
            echo("var(--liikennevaloHarmaa)");
        }
    }

    // Stressi
    function getIconColorStress($value){
        if($value > 2 && $value < 6){
            echo("var(--liikennevaloVihrea)");
        } elseif($value > (-3) && $value < 2){
            echo("var(--liikennevaloKeltainen)");
        } elseif($value < (-2) && $value > (-6)){
            echo("var(--liikennevaloPunainen)");
        }else{
            echo("var(--liikennevaloHarmaa)");
        }
    }

    // Mieliala
    function getIconColorMood($value){
        if($value > 2 && $value < 6){
            echo("var(--liikennevaloVihrea)");
        } elseif($value > (-3) && $value < 2){
            echo("var(--liikennevaloKeltainen)");
        } elseif($value < (-2) && $value > (-6)){
            echo("var(--liikennevaloPunainen)");
        }else{
            echo("var(--liikennevaloHarmaa)");
        }
    }

   

    // Kivut
    function getIconColorPains($value){
        if($value > 2 && $value < 6){
            echo("var(--liikennevaloVihrea)");
        } elseif($value > (-3) && $value < 2){
            echo("var(--liikennevaloKeltainen)");
        } elseif($value < (-2) && $value > (-6)){
            echo("var(--liikennevaloPunainen)");
        }else{
            echo("var(--liikennevaloHarmaa)");
        }
    }

     // Lääkkeet (boolean)
     function getIconColorMedicine($value){
        if($value == 1){
            echo("var(--liikennevaloVihrea)");
        } else{
            echo("var(--liikennevaloHarmaa)");
        }
    }

     // Päihteet (boolean)
     function getIconColorDrugs($value){
        if($value == 1){
            echo("var(--liikennevaloPunainen)");
        } else{
            echo("var(--liikennevaloHarmaa)");
        }
    }
    // Tupakointi (boolean)
    function getIconColorSmoke($value){
        if($value == 1){
            echo("var(--liikennevaloPunainen)");
        } else{
            echo("var(--liikennevaloHarmaa)");
        }
    }

     // Aktiivisuus
     function getIconColorActivity($value){
        echo("var(--liikennevaloHarmaa)");
    }

     //hae tavoiteuniaika tietokannasta (EI TOIMI)
     /*function getSleepGoalData($mapping_sleep_amount, $DBH){

        $sql = "SELECT mapping_sleep_amount FROM ts_parameter_mapping WHERE `user_ID` ='" . $user_ID . "' AND `mapping_sleep_amount` = " . "'" . $mapping_sleep_amount . "';";
        $kysely = $DBH->prepare($sql);
        $kysely->execute();
        $kysely -> setFetchMode(PDO::FETCH_OBJ);
        $vastaus = $kysely->fetch();
    } */


   // Nukuttu aika
   function getIconColorSleepAmount($value){
      
    if($value >= 28800){
        echo("var(--liikennevaloVihrea)");
    } elseif($value >= 21600 && $value < 28800){
        echo("var(--liikennevaloKeltainen)");
    } elseif($value < 21600 && $value > 0){
        echo("var(--liikennevaloPunainen)");
    } else{
        echo("var(--liikennevaloHarmaa)");
    }    
}

?>

