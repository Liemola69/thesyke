<?php
    if(isset($_GET['prevDay'])){ // Vaihda edelliseen päivään
        $updatedDay = getPrevDay($_SESSION['currentDay']); // Korjaa päivä edeltäväksi ja tallenna tämän hetkiseksi päiväksi/viikoksi
        $_SESSION['currentDay'] = $updatedDay;
        $_SESSION['currentWeek'] = date('W', strtotime($updatedDay));
        $_SESSION['days'] = getWeekDays($updatedDay); // Hae kuluvan viikon päivät taulukkoon 
        $paivaOlio = getDayData($updatedDay, $DBH); // Hae päivän data oliona
        
    } elseif(isset($_GET['nextDay'])){ // Vaihda seuraavaan päivään
        $updatedDay = getNextDay($_SESSION['currentDay']);
        $_SESSION['currentDay'] = $updatedDay;
        $_SESSION['currentWeek'] = date('W', strtotime($updatedDay));
        $_SESSION['days'] = getWeekDays($updatedDay);
        $paivaOlio = getDayData($updatedDay, $DBH);           
        
    } elseif(isset($_GET['prevWeek'])){  // Vaihda edeltävään viikkoon
        $_SESSION['currentWeek'] = date('W', strtotime('-1 week', strtotime($_SESSION['currentDay']))); // Vaihda kuluvaksi viikoksi edeltävä viikko
        $currentDay = date('Y-m-d', strtotime('monday last week', strtotime($_SESSION['currentDay']))); // Vaihda currentDay muuttuneen viikon maanantaiksi
        $_SESSION['currentDay'] = $currentDay;
        $_SESSION['days'] = getWeekDays($currentDay);
        $paivaOlio = getDayData($currentDay, $DBH);

    } elseif(isset($_GET['nextWeek'])){ // Vaihda seuraavaan viikkoon
        $_SESSION['currentWeek'] = date('W', strtotime('+1 week', strtotime($_SESSION['currentDay'])));
        $currentDay = date('Y-m-d', strtotime('monday next week', strtotime($_SESSION['currentDay'])));
        $_SESSION['currentDay'] = $currentDay;
        $_SESSION['days'] = getWeekDays($currentDay);
        $paivaOlio = getDayData($currentDay, $DBH);

    } elseif(isset($_GET['moveToDay'])){ // Jos painettu päivää viikkonäkymässä
        
        switch($_GET['moveToDay']){
            case 0:
                $currentDay = $_SESSION['days'][0];
                $_SESSION['currentDay'] = $currentDay;
                $paivaOlio = getDayData($currentDay, $DBH);
                break;
            case 1:
                $currentDay = $_SESSION['days'][1];
                $_SESSION['currentDay'] = $currentDay;
                $paivaOlio = getDayData($currentDay, $DBH);
                break;
            case 2:
                $currentDay = $_SESSION['days'][2];
                $_SESSION['currentDay'] = $currentDay;
                $paivaOlio = getDayData($currentDay, $DBH);
                break;
            case 3:
                $currentDay = $_SESSION['days'][3];
                $_SESSION['currentDay'] = $currentDay;
                $paivaOlio = getDayData($currentDay, $DBH);
                break;
            case 4:
                $currentDay = $_SESSION['days'][4];
                $_SESSION['currentDay'] = $currentDay;
                $paivaOlio = getDayData($currentDay, $DBH);
                break;
            case 5:
                $currentDay = $_SESSION['days'][5];
                $_SESSION['currentDay'] = $currentDay;
                $paivaOlio = getDayData($currentDay, $DBH);
                break;
            case 6:
                $currentDay = $_SESSION['days'][6];
                $_SESSION['currentDay'] = $currentDay;
                $paivaOlio = getDayData($currentDay, $DBH);
                break;
        }
    } else{ // Jos ei painettu mitään/ensimmäistä kertaa sivulle -> kuluva päivä
        $currentDay = date("Y-m-d");
        $_SESSION['currentDay'] = $currentDay;
        $_SESSION['currentWeek'] = date('W', strtotime($currentDay));
        $_SESSION['days'] = getWeekDays($currentDay);
        $paivaOlio = getDayData($currentDay, $DBH);
    }
?>