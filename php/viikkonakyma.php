<?php

    $weekdays = ["Maanantai", "Tiistai", "Keskiviikko", "Torstai", "Perjantai", "Lauantai", "Sunnuntai"];

    for($i = 0; $i < 7; $i++){
        $day = getDateData($user_ID, $_SESSION['days'][$i], $DBH);
        if($_SESSION['days'][$i] == $_SESSION['currentDay']){
            echo('<li class="viikkoNakymaTietue highlight">');
        } else{
            echo('<li class="viikkoNakymaTietue">');
        }

        echo('<div id="viikonpaiva">' . $weekdays[$i] . '</div>');
        echo('<div class="viikkoPvm">');
            getDayFormatted($_SESSION['days'][$i]);
        echo('</div>');
        echo('<i ');
            if($day == null){
                echo('class="fas fa-meh-blank hymio-viikko" style="color: var(--liikennevaloHarmaa);">');
            } else{
                echo(getHymioFromDate($day) . ">");
            }
        echo('</i>');
        echo('<div class="progressViikko">');
        echo('<progress class="attributes_balance progressBarViikko" value="' . getDayProgressValue($day) . '" min="0" max="100"></progress>');
        echo('</div>');
    }

?>