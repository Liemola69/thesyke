<?php
    // Hae käyttäjäntiedot userOlio-muuttujaan
    $userOlio = getUserData($_SESSION['user_ID'], $DBH);
    $user_ID = $userOlio->user_ID;
    //print_r($userOlio);
    
    //$mappingOlio = getSleepGoalData($_SESSION['mapping_sleep_amount'], $DBH);
    //$mapping_sleep_amount = $mappingOlio->mapping_sleep_amount;


    if(isset($_GET['prevDay'])){ // Vaihda edelliseen päivään
        $updatedDay = getPrevDay($_SESSION['currentDay']); // Korjaa päivä edeltäväksi ja tallenna tämän hetkiseksi päiväksi/viikoksi
        $_SESSION['currentDay'] = $updatedDay;
        $_SESSION['currentWeek'] = date('W', strtotime($updatedDay));
        $_SESSION['days'] = getWeekDays($updatedDay); // Hae kuluvan viikon päivät taulukkoon 
        $paivaOlio = getDateData($user_ID, $updatedDay, $DBH); // Hae päivän data oliona
        
    } elseif(isset($_GET['nextDay'])){ // Vaihda seuraavaan päivään
        $updatedDay = getNextDay($_SESSION['currentDay']);
        $_SESSION['currentDay'] = $updatedDay;
        $_SESSION['currentWeek'] = date('W', strtotime($updatedDay));
        $_SESSION['days'] = getWeekDays($updatedDay);
        $paivaOlio = getDateData($user_ID, $updatedDay, $DBH);           
        
    } elseif(isset($_GET['prevWeek'])){  // Vaihda edeltävään viikkoon
        $_SESSION['currentWeek'] = date('W', strtotime('-1 week', strtotime($_SESSION['currentDay']))); // Vaihda kuluvaksi viikoksi edeltävä viikko
        $currentDay = date('Y-m-d', strtotime('monday last week', strtotime($_SESSION['currentDay']))); // Vaihda currentDay muuttuneen viikon maanantaiksi
        $_SESSION['currentDay'] = $currentDay;
        $_SESSION['days'] = getWeekDays($currentDay);
        $paivaOlio = getDateData($user_ID, $currentDay, $DBH);

    } elseif(isset($_GET['nextWeek'])){ // Vaihda seuraavaan viikkoon
        $_SESSION['currentWeek'] = date('W', strtotime('+1 week', strtotime($_SESSION['currentDay'])));
        $currentDay = date('Y-m-d', strtotime('monday next week', strtotime($_SESSION['currentDay'])));
        $_SESSION['currentDay'] = $currentDay;
        $_SESSION['days'] = getWeekDays($currentDay);
        $paivaOlio = getDateData($user_ID, $currentDay, $DBH);

    } elseif(isset($_GET['moveToDay'])){ // Jos painettu päivää viikkonäkymässä
        
        switch($_GET['moveToDay']){
            case 0:
                $currentDay = $_SESSION['days'][0];
                $_SESSION['currentDay'] = $currentDay;
                $paivaOlio = getDateData($user_ID, $currentDay, $DBH);
                break;
            case 1:
                $currentDay = $_SESSION['days'][1];
                $_SESSION['currentDay'] = $currentDay;
                $paivaOlio = getDateData($user_ID, $currentDay, $DBH);
                break;
            case 2:
                $currentDay = $_SESSION['days'][2];
                $_SESSION['currentDay'] = $currentDay;
                $paivaOlio = getDateData($user_ID, $currentDay, $DBH);
                break;
            case 3:
                $currentDay = $_SESSION['days'][3];
                $_SESSION['currentDay'] = $currentDay;
                $paivaOlio = getDateData($user_ID, $currentDay, $DBH);
                break;
            case 4:
                $currentDay = $_SESSION['days'][4];
                $_SESSION['currentDay'] = $currentDay;
                $paivaOlio = getDateData($user_ID, $currentDay, $DBH);
                break;
            case 5:
                $currentDay = $_SESSION['days'][5];
                $_SESSION['currentDay'] = $currentDay;
                $paivaOlio = getDateData($user_ID, $currentDay, $DBH);
                break;
            case 6:
                $currentDay = $_SESSION['days'][6];
                $_SESSION['currentDay'] = $currentDay;
                $paivaOlio = getDateData($user_ID, $currentDay, $DBH);
                break;
        }
    } else{ // Jos ei painettu mitään/ensimmäistä kertaa sivulle -> kuluva päivä
        $currentDay = date("Y-m-d");
        $_SESSION['currentDay'] = $currentDay;
        $_SESSION['currentWeek'] = date('W', strtotime($currentDay));
        $_SESSION['days'] = getWeekDays($currentDay);
        $paivaOlio = getDateData($user_ID, $currentDay, $DBH);
    }

?>

<?php
                            //aseta aikavyöhyke
    date_default_timezone_set('Europe/Finland');
                                //saa edellinen ja seuraava kuukausi
    if(isset($_GET['ym'])){
        $ym = $_GET['ym'];
    }else{
                                        //tämä kuukausi
        $ym=date('Y-m');
    }
                                    //tarkistetaan muoto
     $timestamp = strtotime($ym,"-01");
    if($timestamp === false){
        $timestamp = time();
    }
                                    //nykyinen päivä
    $today = date('Y-m-d', time());
                                    //kalenterin otsikolle
    $html_title = date('Y / m', $timestamp);


                                    //edellisen ja tulevan kuukauden linkit .... mktime(tunti, minuti, sekunti, kuukausi, päivä, vuosi)
    $prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)-1, 1, date('Y', $timestamp)));
    $next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));
                                //Kuukauden päivät
    $day_count = date('t', $timestamp);
                                    //0:sun, 1:Mon, 2:Tue..
    $str = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));

                                    //Kalenterin luominen
    $weeks = array();
    $week = '';
                                    //add empty cell
    $week .= str_repeat('<td></td>', $str);

    for( $day = 1; $day <= $day_count; $day++, $str++){
    $date = $ym.'-'.$day;

    if($today == $date){
        $week .= '<td class="today">'.$day;
    }else{
        $week .= '<td>'.$day;
    }
    $week .= '</td>';
                                        //Viikon loppuminen tai kuukauden loppuminen
    if($str % 7 == 6 || $day == $day_count){
    if($day == $day_count){
                                                //lisää tyhjä ruutu
        $week .= str_repeat('<td></td>', 6 - ($str % 7));
    }
    $weeks[] = '<tr>'.$week.'</tr>';
                                        //valmistautuminen uuteen viikkoon
    $week = '';
        }
    }
?>