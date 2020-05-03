<?php

    /** 
     * Laskee uniajan ja tallentaa nukkumaanmeno-/heräämisajan
     * Uneksi tulkitaan vähintään 0-zonessa 30min
     * Nukahtamishetki valikoidaan niin, että seuraavat 2 tuntia pitää myös olla 0-zonessa +30min
     * Uniaika lasketaan nukahtamis- ja heräämisajan taulukkoindeksien mukaan
     * @param   object $paivaOlio   Kuluva päivä objektina date-taulusta
     * @param   object $previousDay Edeltävä päivä objektina date-taulusta
     * @param   object $DBH         Tietokanta viite
    */
    function calculateSleepData($paivaOlio, $previousDay, $DBH){
        $timeLines = [
            "00_to_01",
            "01_to_02",
            "02_to_03",
            "03_to_04",
            "04_to_05",
            "05_to_06",
            "06_to_07",
            "07_to_08",
            "08_to_09",
            "09_to_10",
            "10_to_11",
            "11_to_12",
            "12_to_13",
            "13_to_14",
            "14_to_15",
            "15_to_16",
            "16_to_17",
            "17_to_18",
            "18_to_19",
            "19_to_20",
            "20_to_21",
            "21_to_22",
            "22_to_23",
            "23_to_24"
        ];
        $sleepTime = 0; // minuuteissa

        //Tarkista tietokannasta onko uniaika/sykli tyhjä
        if($paivaOlio->sleep_amount == null || $paivaOlio->sleep_cycles == null){

            $prevDate_ID = $previousDay->date_ID;
            // Jos edeltävän päivän tietoja ei saatavilla -> ohitetaan koko laskenta
            if($prevDate_ID != null){
                // Haetaan tietokannasta edeltävä päivä
                try{
                    $sql = 'SELECT * FROM `ts_day` WHERE date_ID =' . $prevDate_ID;
                    $kysely = $DBH->prepare($sql);
                    $kysely->execute();
                    $kysely -> setFetchMode(PDO::FETCH_OBJ);
                    $yesterday = $kysely->fetch();
                } catch(PDOException $e){
                    file_put_contents('../log/DBErrors.txt', 'calculateSleepData() failed to get prevday data: ' . $e->getMessage() . "\n", FILE_APPEND);
                }
                
                // Haetaan eilisen päivän tiedot
                for($i = 0; $i < 24; $i++){ 
                    $sek = 0;
                    $min = 0;
                    $tunnit = 0;
                    
                    $temp = json_decode($yesterday->{$timeLines[$i]});
                    
                    $aika = str_replace("PT", "", $temp[0]->inzone);
                    if(!strpbrk($aika, "H")){
                        if(!strpbrk($aika, "M")){
                            $sek = strtok($aika, "S");
                        } else{
                            $min = strtok($aika, "M");
                                                
                            if(!strpbrk($aika, "S")){
                                $sek = 0;
                            } else{
                                $sek = strtok("S");
                            }
                        }
                    } else{
                        $tunnit = 1;
                    }
                    
                    $aika = (round($sek/60) + $min + ($tunnit*60)); //minuuteissa
                    $prevDayTimeLines[$i] = $aika;
                }

                // Haetaan tietokannasta kuluva päivä
                $currentDate_ID = $paivaOlio->date_ID;
                if($currentDate_ID != null){
                    try{
                        $sql = 'SELECT * FROM `ts_day` WHERE date_ID =' . $currentDate_ID;
                        $kysely = $DBH->prepare($sql);
                        $kysely->execute();
                        $kysely -> setFetchMode(PDO::FETCH_OBJ);
                        $today = $kysely->fetch();
                    } catch(PDOException $e){
                        file_put_contents('../log/DBErrors.txt', 'calculateSleepData() failed to get currentday data: ' . $e->getMessage() . "\n", FILE_APPEND);
                    }
                } else{
                    echo('<script>console.log("No data from today")</script>');
                }
                
                // Haetaan kuluvan päivän tiedot
                for($i = 0; $i < 24; $i++){ 
                    $sek = 0;
                    $min = 0;
                    $tunnit = 0;

                    $temp = json_decode($today->{$timeLines[$i]});

                    $aika = str_replace("PT", "", $temp[0]->inzone);
                    if(!strpbrk($aika, "H")){
                        if(!strpbrk($aika, "M")){ 
                            $sek = strtok($aika, "S");
                        } else{ 
                            $min = strtok($aika, "M");
                                                
                            if(!strpbrk($aika, "S")){
                                $sek = 0;
                            } else{
                                $sek = strtok("S");
                            }
                        }
                    } else{
                        $tunnit = 1;
                    }
                    
                    $aika = (round($sek/60) + $min + ($tunnit*60)); //minuuteissa
                    $currentDayTimeLines[$i] = $aika;
                }

                // Edeltävän päivän heräämisaika -> ei oteta uniaikaa huomioon tuplana
                for($i = 0; $i < 24; $i++){
                    if($prevDayTimeLines[$i] >= 30){
                        if(($currentDayTimeLines[$i+1] <= 30) && ($currentDayTimeLines[$i+2] <= 30)){
                            $heraamisAikaPrevDay = $i . ":" . $prevDayTimeLines[$i];
                            $heraamisAikaPrevDayIndeksi = $i;
                            break;
                        }
                    }
                }
                
                // Edeltävän päivän nukkumaanmenoaika
                for($i = ($heraamisAikaPrevDayIndeksi + 1); $i < 24; $i++){
                    if($prevDayTimeLines[$i] >= 30){
                        if($i == 23){ // jos ollaan edeltävän päivän 23-24 slotissa
                            if($currentDayTimeLines[0] >= 30){ // tarkista onko kuluvan päivän 00-01 +30min

                                // Muokkaa nukahtamisajankohta sopivaksi tietokantaan viemistä varten
                                if($i < 10){
                                    if((60 - $prevDayTimeLines[$i]) < 10){
                                        $nukahtamisAikaPrevDay = "0" . $i . ":" . "0" . (60 - $prevDayTimeLines[$i]);
                                    } else{
                                        $nukahtamisAikaPrevDay = "0" . $i . ":" . (60 - $prevDayTimeLines[$i]);
                                    }
                                } else{
                                    if((60 - $prevDayTimeLines[$i]) < 10){
                                        $nukahtamisAikaPrevDay = $i . ":" . "0" . (60 - $prevDayTimeLines[$i]);
                                    } else{
                                        $nukahtamisAikaPrevDay = $i . ":" . (60 - $prevDayTimeLines[$i]);
                                    }
                                }

                                $nukahtamisAikaPrevDayIndeksi = $i;
                                $nukahtamisAika = $previousDay->date . " " . $nukahtamisAikaPrevDay . ":00";
                                break;
                            }
                        } elseif($prevDayTimeLines[$i+1] >= 30 && $prevDayTimeLines[$i+2] >= 30){ // tarkista että vähintään 2h unessa

                            // Muokkaa nukahtamisajankohta sopivaksi tietokantaan viemistä varten
                            if($i < 10){
                                if((60 - $prevDayTimeLines[$i]) < 10){
                                    $nukahtamisAikaPrevDay = "0" . $i . ":" . "0" . (60 - $prevDayTimeLines[$i]);
                                } else{
                                    $nukahtamisAikaPrevDay = "0" . $i . ":" . (60 - $prevDayTimeLines[$i]);
                                }
                            } else{
                                if((60 - $prevDayTimeLines[$i]) < 10){
                                    $nukahtamisAikaPrevDay = $i . ":" . "0" . (60 - $prevDayTimeLines[$i]);
                                } else{
                                    $nukahtamisAikaPrevDay = $i . ":" . (60 - $prevDayTimeLines[$i]);
                                }
                            }

                            $nukahtamisAikaPrevDayIndeksi = $i;
                            $nukahtamisAika = $previousDay->date . " " . $nukahtamisAikaPrevDay . ":00";
                            break;
                        }
                    }
                }
                
                // Jos ei nukahtamisaikaa edeltävänä päivänä
                if(!$nukahtamisAikaPrevDay){

                    // Nukahtamisaika kuluvana päivänä
                    for($i = 0; $i < 24; $i++){
                        if($currentDayTimeLines[$i] >= 30){

                            if($currentDayTimeLines[$i+1] >= 30){ // Tarkista, että seuraavakin tunti 0-zonessa +30min
                                
                                // Muokkaa nukahtamisajankohta sopivaksi tietokantaan viemistä varten
                                if($i < 10){
                                    if((60 - $currentDayTimeLines[$i]) < 10){
                                        $nukahtamisAikaCurrentDay = "0" . $i . ":" . "0" . (60 - $currentDayTimeLines[$i]);
                                    } else{
                                        $nukahtamisAikaCurrentDay = "0" . $i . ":" . (60 - $currentDayTimeLines[$i]);
                                    }
                                } else{
                                    $nukahtamisAikaCurrentDay = $i . ":" . (60 - $currentDayTimeLines[$i]);
                                }
    
                                $nukahtamisAikaCurrentDayIndeksi = $i;
                                $nukahtamisAika = $paivaOlio->date . " " . $nukahtamisAikaCurrentDay . ":00";
                                break;
                            }
                        }
                    }
                }
                
                // Heräämisaika kuluvana päivänä
                for($i = 0; $i < 24; $i++){
                    if($currentDayTimeLines[$i] >= 30){
                        if(($currentDayTimeLines[$i+1] <= 30) && ($currentDayTimeLines[$i+2] <= 30)){ // Jos seuraavalla 2 tunnilla on oltu alle 30min 0-zonessa

                            // Muokkaa nukahtamisajankohta sopivaksi tietokantaan viemistä varten
                            if($i < 10){
                                if($currentDayTimeLines[$i] < 10){
                                    $heraamisAikaCurrentDay = "0" . $i . ":" . "0" . $currentDayTimeLines[$i];
                                } else{
                                    $heraamisAikaCurrentDay = "0" . $i . ":" . $currentDayTimeLines[$i];
                                }
                            } else{
                                $heraamisAikaCurrentDay = $i . ":" . $currentDayTimeLines[$i];
                            }

                            $heraamisAikaCurrentDayIndeksi = $i;
                            $heraamisAika = $paivaOlio->date . " " . $heraamisAikaCurrentDay . ":00";
                            break;
                        }
                    }
                }
                
                // Lasketaan uniaika
                if($nukahtamisAikaPrevDayIndeksi){ //jos nukahtanut edeltävän päivän puolella
                    for($i = $nukahtamisAikaPrevDayIndeksi; $i < 24; $i++){
                        $sleepTime += $prevDayTimeLines[$i];
                    }

                    for($i = 0; $i < ($heraamisAikaCurrentDayIndeksi + 1); $i++){
                        $sleepTime += $currentDayTimeLines[$i];
                    }
                } else{ //jos nukahtanut kuluvan päivän aikana
                    for($i = $nukahtamisAikaCurrentDayIndeksi; $i < ($heraamisAikaCurrentDayIndeksi+1); $i++){
                        $sleepTime += $currentDayTimeLines[$i];
                    }
                }

                $sleepCycle = floor($sleepTime * 60 / 5400);

                // Laske aktiivisuusarvo tietokantaan ja liitä tallennukseen
                $user_activity = calculateActivity($timeLines, $nukahtamisAikaPrevDayIndeksi, $nukahtamisAikaCurrentDayIndeksi, $previousDay, $paivaOlio, $DBH);

                // Tallenna tietokantaan
                try{
                    $sql = 'UPDATE `ts_date` SET 
                    sleep_amount = ' . ($sleepTime*60) .  ', 
                    sleep_cycles = ' . $sleepCycle .  ', 
                    user_activity = ' . $user_activity . ', 
                    sleep_start = "' . $nukahtamisAika . '", 
                    sleep_end = "' . $heraamisAika . '" 
                    WHERE date_user_ID = ' . $paivaOlio->date_user_ID . ' AND date_ID = ' . $currentDate_ID . ';';
                    $kysely = $DBH->prepare($sql);
                    $kysely->execute();
                    echo('<script>console.log("Tiedot päivitetty")</script>');
                } catch(PDOException $e){
                    file_put_contents('../log/DBErrors.txt', 'calculateSleepData() failed to save sleeptime: ' . $e->getMessage() . "\n", FILE_APPEND);
                }
            } else{
                echo('<script>console.log("No data from yesterday, can`t calculate uniaika/sykli")</script>');
            }
        } else{
            echo('<script>console.log("Tiedot löytyy jo")</script>');
        }
    }

    /**
     * Laskee aktiivisuuden 3h nukahtamista edeltävältä ajalta ja palauttaa lukuarvon -5-5, joka tallennetaan tietokantaan
     * @param   array   $timeLines                          Taulukko päivästä jaettuna tunnin mittaisiin jaksoihin
     * @param   integer $nukahtamisAikaPrevDayIndeksi       Nukahtamisajan ilmoittava taulukon indeksi
     * @param   integer $nukahtamisAikaCurrentDayIndeksi    Heräämisajan ilmoittava taulukon indeksi
     * @param   object  $previousDay                        Edeltävä päivä objektina date-taulusta
     * @param   object  $paivaOlio                          Kuluva päivä objektina date-taulusta
     * @param   object  $DBH                                Tietokanta viite
     * 
     * @return  integer Lukuarvo, joka tallennetaan tietokantaan
     */
    function calculateActivity($timeLines, $nukahtamisAikaPrevDayIndeksi, $nukahtamisAikaCurrentDayIndeksi, $previousDay, $paivaOlio, $DBH){

        // Tarkista kumman päivän puolella nukahtanut
        if(isset($nukahtamisAikaCurrentDayIndeksi)){ // Nukahtanut kuluvan päivän puolella
            $i = $nukahtamisAikaCurrentDayIndeksi;
            for($i; $i >= 0; $i--){
                if($i == 0){
                    $prevDay = 3-$nukahtamisAikaCurrentDayIndeksi;
                    for($j = 0; $j < $prevDay; $j++){
                        $prevDayIndeksit[] = 23-$j;
                    }
                    break;
                }
                $currentDayIndeksit[] = $i-1;
            }

            // Haetaan kuluva/edeltävä päivä day-taulusta
            try{ // Kuluva päivä
                $sql = 'SELECT * FROM ts_day WHERE date_ID =' . $paivaOlio->date_ID . ';';
                $kysely = $DBH->prepare($sql);
                $kysely->execute();
                $kysely->setFetchMode(PDO::FETCH_OBJ);
                $currentDayOlio = $kysely->fetch();
            } catch(PDOException $e){
                file_put_contents('../log/DBErrors.txt', 'calculateActivityWarning() failed to get current day data: ' . $e->getMessage() . "\n", FILE_APPEND);
            }

            try{ // Edeltävä päivä
                $sql = 'SELECT * FROM ts_day WHERE date_ID =' . $previousDay->date_ID . ';';
                $kysely = $DBH->prepare($sql);
                $kysely->execute();
                $kysely->setFetchMode(PDO::FETCH_OBJ);
                $prevDayOlio = $kysely->fetch();
            } catch(PDOException $e){
                file_put_contents('../log/DBErrors.txt', 'calculateActivityWarning() failed to get prevday data: ' . $e->getMessage() . "\n", FILE_APPEND);
            }

            // Hae unta 3h edeltävät zonet
            for($i = 0; $i < 3; $i++){
                $todayZones[] = $currentDayOlio->{$timeLines[$currentDayIndeksit[$i]]};
                $prevZones[] = $prevDayOlio->{$timeLines[$prevDayIndeksit[$i]]}; 
                
                $todayZonesJSON[] = json_decode($todayZones[$i]);
                $prevZonesJSON[] = json_decode($prevZones[$i]);
            }

            // Haetaan 3-4 zonet
            for($i = 0; $i < 3; $i++){
                if($todayZonesJSON[$i][3]->inzone != null){
                    $temp[] = $todayZonesJSON[$i][3]->inzone;
                }
                
                if($todayZonesJSON[$i][4]->inzone != null){
                    $temp[] = $todayZonesJSON[$i][4]->inzone;
                } 
                
                if($prevZonesJSON[$i][3]->inzone != null){
                    $temp[] = $prevZonesJSON[$i][3]->inzone;
                }
                
                if($prevZonesJSON[$i][4]->inzone != null){
                    $temp[] = $prevZonesJSON[$i][4]->inzone;
                }
            }

            $aika = 0;

            // Summataan aika 3- ja 4 zonella
            foreach($temp as $value){
                $tunnit = 0;
                $min = 0;
                $sek = 0;

                $zonessa = str_replace("PT", "", $value);
                if(!strpbrk($zonessa, "H")){
                    if(!strpbrk($zonessa, "M")){ 
                        $sek = strtok($zonessa, "S");
                    } else{ 
                        $min = strtok($zonessa, "M");
                                                
                        if(!strpbrk($zonessa, "S")){
                                $sek = 0;
                        } else{
                                $sek = strtok("S");
                        }
                    }
                } else{
                        $tunnit = 1;
                }
                $aika += (round($sek/60) + $min + ($tunnit*60)); //minuuteissa
            }

        } elseif(isset($nukahtamisAikaPrevDayIndeksi)){ // Nukahtanut edeltävän päivän puolella
            $i = $nukahtamisAikaPrevDayIndeksi;
            for($j = 1; $j < 4; $j++){
                $prevDayIndeksit[] = $i-$j;
            }

            // Hae edeltävä päivä day-taulusta
            try{
                $sql = 'SELECT * FROM ts_day WHERE date_ID =' . $previousDay->date_ID . ';';
                $kysely = $DBH->prepare($sql);
                $kysely->execute();
                $kysely->setFetchMode(PDO::FETCH_OBJ);
                $prevDayOlio = $kysely->fetch();
            } catch(PDOException $e){
                file_put_contents('../log/DBErrors.txt', 'calculateActivityWarning() failed to get prevday data: ' . $e->getMessage() . "\n", FILE_APPEND);
            }

            // Haetaan zonet 3h nukahtamista edeltävältä ajalta
            for($i = 0; $i < 3; $i++){
                $prevZones[] = $prevDayOlio->{$timeLines[$prevDayIndeksit[$i]]}; 
                $prevZonesJSON[] = json_decode($prevZones[$i]);
            }

            // Haetaan 3-4 zonet
            for($i = 0; $i < 3; $i++){

                if($prevZonesJSON[$i][3]->inzone != null){
                    $temp[] = $prevZonesJSON[$i][3]->inzone;
                }
                
                if($prevZonesJSON[$i][4]->inzone != null){
                    $temp[] = $prevZonesJSON[$i][4]->inzone;
                }
            }

            // Lasketaan aika 3- ja 4-zonella
            foreach($temp as $value){
                $tunnit = 0;
                $min = 0;
                $sek = 0;

                $zonessa = str_replace("PT", "", $value);
                if(!strpbrk($zonessa, "H")){
                    if(!strpbrk($zonessa, "M")){ 
                        $sek = strtok($zonessa, "S");
                    } else{ 
                        $min = strtok($zonessa, "M");
                                                
                        if(!strpbrk($zonessa, "S")){
                                $sek = 0;
                        } else{
                                $sek = strtok("S");
                        }
                    }
                } else{
                        $tunnit = 1;
                }
                $aika += (round($sek/60) + $min + ($tunnit*60)); //minuuteissa
            }
        }

        // Määritä lukuarvo tietokantaan
        if($aika >= 30){
            return "-5";
        } elseif($aika >= 20){
            return "-3";
        } elseif($aika >= 10){
            return "-1";
        } else{
            return "5";
        }
    }

    /**
     * Tarkistaa Polarin serveriltä, onko uutta dataa tuotu laitteelta
     * Palauttaa transaction id:n, jolla voidaan hakea dataa sovellukseen
     */
    function getPolarActivityTransaction($polar_ID, $polar_token){
        // Hae user-ID:llä activity transactions
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.polaraccesslink.com/v3/users/" . $polar_ID . "/activity-transactions",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_HTTPHEADER => array(
            "Accept: application/json",
            "Authorization: Bearer " . $polar_token,
            "Cookie: NSC_ued1-qspe-xxb-mc-ttm=ffffffffc3a0989545525d5f4f58455e445a4a4229a9"
        )
        ));

        $response = curl_exec($curl);
        $responseJSON = json_decode($response);
        $serverResponse = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        //echo ("Hae user ID:llä activity transactions: " . $serverResponse . "<br>");
        curl_close($curl);

        $transactionID = $responseJSON->{'transaction-id'};

        return $transactionID;
    }

    /**
     * Hakee transaction id:llä listan datasta, jota ei ole vielä tuotu sovellukseen.
     * Palauttaa taulukon, johon tallennettu aktiivisuusdatan id:t 
     */
    function getPolarActivityList($polar_ID, $polar_token, $transactionID){
        // Transaction IDllä activity lista
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.polaraccesslink.com/v3/users/" . $polar_ID . "/activity-transactions/" . $transactionID,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Accept: application/json",
            "Authorization: Bearer " . $polar_token,
            "Cookie: NSC_ued1-qspe-xxb-mc-ttm=ffffffffc3a0989545525d5f4f58455e445a4a4229a9"
        )
        ));

        $response = curl_exec($curl);
        $activityListJSON = json_decode($response);
        $serverResponse = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        //echo ("Transaction ID:llä haettu activity lista" . $transactionID . "<br>");
        curl_close($curl);

        // Jos ei päivitettävää dataa, palauta null
        // Jos on päivitettävää dataa, tallenna taulukkoon activity id:t.
        if(!$activityListJSON || $activityListJSON == null){
            return null;
        } else{
            foreach($activityListJSON->{'activity-log'} as $activityID){
                $activityIDArray[] = basename($activityID);
            }
            return $activityIDArray;
        }
    }

    /**
     * Hakee Aktiivisuus summaryt ja tarkistaa että dataa koko päivältä 24h
     * Tarkistaa tietokannasta (date-taulu), onko samalla päivämäärällä jo tietuetta,
     *  jos ei -> luo uuden tietueen ja täyttää zone-sarakkeet
     *  jos on -> päivittää vain zone-sarakkeet tietueeseen
     * Tarkistaa tietokannasta (day-taulu), onko samalla päivämäärällä jo tietuetta,
     *  jos ei -> luo uuden tietueen ja täyttää kellonaika-sarakkeet
     *  jos on -> päivittää vain kellonaika-sarakkeet tietueeseen
     */
    function getPolarZoneData($polar_ID, $polar_token, $transactionID, $activityIDArray, $user_ID, $DBH){
        // Estää virheilmoituksen, jos Polarilta ei päivitettävää dataa
        if($activityIDArray == null){
            $activityCount = 0;
        } else{
            $activityCount = count($activityIDArray);
        }
        
        for($i = 0; $i < $activityCount; $i++){
            // Hae activity summary
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.polaraccesslink.com/v3/users/" . $polar_ID . "/activity-transactions/" . $transactionID . "/activities/" . $activityIDArray[$i],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Authorization: Bearer " . $polar_token,
                "Cookie: NSC_ued1-qspe-xxb-mc-ttm=ffffffffc3a0989545525d5f4f58455e445a4a4229a9"
            )
            ));

            $response = curl_exec($curl);
            $activitySummaryJSON = json_decode($response);
            curl_close($curl);

            // Ota talteen päivämäärä
            $activityDate = $activitySummaryJSON->date;

            // Hae activityn zonet
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.polaraccesslink.com/v3/users/" . $polar_ID . "/activity-transactions/" . $transactionID . "/activities/" . $activityIDArray[$i] . "/zone-samples",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Authorization: Bearer " . $polar_token,
                "Cookie: NSC_ued1-qspe-xxb-mc-ttm=ffffffffc3a0989545525d5f4f58455e445a4a4229a9"
            )
            ));

            $response = curl_exec($curl);
            $activityZonesJSON = json_decode($response);
            curl_close($curl);

            // Tarkista onko zoneja koko päivältä = 24
            if(count($activityZonesJSON->samples) == 24){

                // Taulukot, joihin haetaan ja summataan aika zonella
                $zoneTunnissa = ["Zone0"=>"","Zone1"=>"","Zone2"=>"","Zone3"=>"","Zone4"=>"","Zone5"=>""];
                $zonePaivassa = [];
                    
                for($j = 0; $j < 24; $j++){ //Käy läpi päivän sisältö
                       
                    for($k = 0; $k < 6; $k++){ //Käy läpi yhden tunnin sisältö
                        $inzone = $activityZonesJSON->samples[$j]->{'activity-zones'}[$k]->inzone;
                        $aika = str_replace("PT", "", $inzone);
                        $tunnit = 0;
                        $min = 0;
                        $sek = 0;
                     
                        if(!strpbrk($aika, "H")){
                            if(!strpbrk($aika, "M")){
                                $sek = strtok($aika, "S");
                            } else{
                                $min = strtok($aika, "M");
                                                    
                                if(!strpbrk($aika, "S")){
                                    $sek = 0;
                                } else{
                                    $sek = strtok("S");
                                }
                            }
                        } else{
                            $tunnit = 1;
                        }
                                            
                        $zoneTunnissa[("Zone".$k)] = ($sek + ($min*60) + ($tunnit*3600));                
                    }  
                    $zonePaivassa[$j] = $zoneTunnissa;
                }

                // Taulukko, joka viedään tietokantaan
                $zonePaivaYhteenveto = ["Zone0"=>"","Zone1"=>"","Zone2"=>"","Zone3"=>"","Zone4"=>"","Zone5"=>""];
                
                for($j = 0; $j < 24; $j++){
                    for($k = 0; $k < 6; $k++){
                        $zonePaivaYhteenveto["Zone".$k] = (int)$zonePaivaYhteenveto["Zone".$k] + (int)$zonePaivassa[$j]["Zone".$k];
                    }
                }

                // Tarkista päivämäärällä onko tietokannassa tietuetta
                try{
                    $sql = 'SELECT * FROM `ts_date` WHERE `date` = "' . $activityDate . '" 
                    AND date_user_ID = "' . $user_ID . '";';
                    $kysely = $DBH->prepare($sql);
                    $kysely->execute();
                    $dateOlemassa = $kysely->fetch();

                    if(!$dateOlemassa){
                        // Jos tietuetta ei ole olemassa -> luodaan uusi ja täytetään zone- ja päivämäärä-sarakkeet
                        try{
                            $sql = 'INSERT INTO `ts_date` (date_user_ID, date, zone_00, zone_01, zone_02, zone_03, zone_04, zone_05)
                            VALUES ("' . 
                            $user_ID . '","' . 
                            $activityDate . '","' . 
                            $zonePaivaYhteenveto["Zone0"] . '","' .
                            $zonePaivaYhteenveto["Zone1"] . '","' .
                            $zonePaivaYhteenveto["Zone2"] . '","' .
                            $zonePaivaYhteenveto["Zone3"] . '","' .
                            $zonePaivaYhteenveto["Zone4"] . '","' .
                            $zonePaivaYhteenveto["Zone5"] . '");';
                            
                            $kysely = $DBH->prepare($sql);
                            $kysely->execute();
                        } catch(PDOException $e){
                            file_put_contents('../log/DBErrors.txt', 'ei olemassa failed, getPolarZoneData(): ' . $e->getMessage() . "\n", FILE_APPEND);
                        }
                        

                    } else{
                        // Jos tietue on olemassa -> päivitetään zone-sarakkeet
                        try{
                            $sql = 'UPDATE `ts_date` SET 
                            zone_00 = ' . $zonePaivaYhteenveto["Zone0"] . ',
                            zone_01 = ' . $zonePaivaYhteenveto["Zone1"] . ', 
                            zone_02 = ' . $zonePaivaYhteenveto["Zone2"] . ',
                            zone_03 = ' . $zonePaivaYhteenveto["Zone3"] . ',
                            zone_04 = ' . $zonePaivaYhteenveto["Zone4"] . ',
                            zone_05 = ' . $zonePaivaYhteenveto["Zone5"] . '
                            WHERE date = "' . $activityDate . '" 
                            AND date_user_ID = "' . $user_ID . '";';
    
                            $kysely = $DBH->prepare($sql);
                            $kysely->execute();
                        } catch(PDOException $e){
                            file_put_contents('../log/DBErrors.txt', 'olemassa failed, getPolarZoneData(): ' . $e->getMessage() . "\n", FILE_APPEND);
                        }
                        
                    }
                } catch(PDOException $e){
                    file_put_contents('../log/DBErrors.txt', 'check date failed at getPolarZoneData(): ' . $e->getMessage() . "\n", FILE_APPEND);
                }

                // Tallenna tietokantaan (day-taulu)
                // Hae päivämäärällä date_ID
                try{
                    $sql = 'SELECT `date_ID` FROM `ts_date` WHERE `date` = "' . $activityDate .'" AND `date_user_ID` = "' . $user_ID . '";';
                    $kysely = $DBH->prepare($sql);
                    $kysely->execute();
                    $date_ID = $kysely->fetch();
                } catch(PDOException $e){
                    file_put_contents('../log/DBErrors.txt', 'failed to check day-table, getPolarZoneData(): ' . $e->getMessage() . "\n", FILE_APPEND);
                }
                
                // Tarkista onko jo olemassa day-taulukossa -> estä duplikaatit
                try{
                    $sql = 'SELECT `date_ID` FROM `ts_day` WHERE `date_ID` = "' . $date_ID[0] . '";';
                    $kysely = $DBH->prepare($sql);
                    $kysely->execute();
                    $dayOlemassa = $kysely->fetch();
                } catch(PDOException $e){
                    file_put_contents('../log/DBErrors.txt', 'failed to check if day exist at day-table, getPolarZoneData(): ' . $e->getMessage() . "\n", FILE_APPEND);
                }

                if($dayOlemassa){ // Jos tietue jo olemassa -> päivitä
                    try{
                        $sql = "UPDATE ts_day SET 
                        00_to_01 = " . "'" . json_encode($activityZonesJSON->samples[0]->{'activity-zones'}) .  "',
                        00_to_01 = '" . json_encode($activityZonesJSON->samples[1]->{'activity-zones'}) .  "',
                        00_to_01 = '" . json_encode($activityZonesJSON->samples[2]->{'activity-zones'}) .  "',
                        00_to_01 = '" . json_encode($activityZonesJSON->samples[3]->{'activity-zones'}) .  "',
                        00_to_01 = '" . json_encode($activityZonesJSON->samples[4]->{'activity-zones'}) .  "',
                        00_to_01 = '" . json_encode($activityZonesJSON->samples[5]->{'activity-zones'}) .  "',
                        00_to_01 = '" . json_encode($activityZonesJSON->samples[6]->{'activity-zones'}) .  "',
                        00_to_01 = '" . json_encode($activityZonesJSON->samples[7]->{'activity-zones'}) .  "',
                        00_to_01 = '" . json_encode($activityZonesJSON->samples[8]->{'activity-zones'}) .  "',
                        00_to_01 = '" . json_encode($activityZonesJSON->samples[9]->{'activity-zones'}) .  "',
                        00_to_01 = '" . json_encode($activityZonesJSON->samples[10]->{'activity-zones'}) .  "',
                        00_to_01 = '" . json_encode($activityZonesJSON->samples[11]->{'activity-zones'}) .  "',
                        00_to_01 = '" . json_encode($activityZonesJSON->samples[12]->{'activity-zones'}) .  "',
                        00_to_01 = '" . json_encode($activityZonesJSON->samples[13]->{'activity-zones'}) .  "',
                        00_to_01 = '" . json_encode($activityZonesJSON->samples[14]->{'activity-zones'}) .  "',
                        00_to_01 = '" . json_encode($activityZonesJSON->samples[15]->{'activity-zones'}) .  "',
                        00_to_01 = '" . json_encode($activityZonesJSON->samples[16]->{'activity-zones'}) .  "',
                        00_to_01 = '" . json_encode($activityZonesJSON->samples[17]->{'activity-zones'}) .  "',
                        00_to_01 = '" . json_encode($activityZonesJSON->samples[18]->{'activity-zones'}) .  "',
                        00_to_01 = '" . json_encode($activityZonesJSON->samples[19]->{'activity-zones'}) .  "',
                        00_to_01 = '" . json_encode($activityZonesJSON->samples[20]->{'activity-zones'}) .  "',
                        00_to_01 = '" . json_encode($activityZonesJSON->samples[21]->{'activity-zones'}) .  "',
                        00_to_01 = '" . json_encode($activityZonesJSON->samples[22]->{'activity-zones'}) .  "',
                        00_to_01 = '" . json_encode($activityZonesJSON->samples[23]->{'activity-zones'}) .  "' 
                        WHERE date_ID = '" . $date_ID[0] . "';";
    
                        $kysely = $DBH->prepare($sql);
                        $kysely->execute();
                    } catch(PDOException $e){
                        file_put_contents('../log/DBErrors.txt', 'failed to update day-table, getPolarZoneData(): ' . $e->getMessage() . "\n", FILE_APPEND);
                    }

                } else{ // Jos ei -> luo uusi tietue

                    try{
                        $sql = "INSERT INTO `ts_day` (date_ID , 00_to_01, 01_to_02, 02_to_03, 03_to_04, 04_to_05, 05_to_06, 06_to_07,
                        07_to_08, 08_to_09, 09_to_10, 10_to_11, 11_to_12, 12_to_13, 13_to_14, 14_to_15, 15_to_16, 16_to_17, 
                        17_to_18, 18_to_19, 19_to_20, 20_to_21, 21_to_22, 22_to_23, 23_to_24, user_ID) 
                        VALUES (" . $date_ID[0] . ",'"
                        . json_encode($activityZonesJSON->samples[0]->{'activity-zones'}) . "','" 
                        . json_encode($activityZonesJSON->samples[1]->{'activity-zones'}) . "','"
                        . json_encode($activityZonesJSON->samples[2]->{'activity-zones'}) . "','"
                        . json_encode($activityZonesJSON->samples[3]->{'activity-zones'}) . "','"
                        . json_encode($activityZonesJSON->samples[4]->{'activity-zones'}) . "','" 
                        . json_encode($activityZonesJSON->samples[5]->{'activity-zones'}) . "','"
                        . json_encode($activityZonesJSON->samples[6]->{'activity-zones'}) . "','"
                        . json_encode($activityZonesJSON->samples[7]->{'activity-zones'}) . "','"
                        . json_encode($activityZonesJSON->samples[8]->{'activity-zones'}) . "','"
                        . json_encode($activityZonesJSON->samples[9]->{'activity-zones'}) . "','"
                        . json_encode($activityZonesJSON->samples[10]->{'activity-zones'}) . "','"
                        . json_encode($activityZonesJSON->samples[11]->{'activity-zones'}) . "','"
                        . json_encode($activityZonesJSON->samples[12]->{'activity-zones'}) . "','"
                        . json_encode($activityZonesJSON->samples[13]->{'activity-zones'}) . "','"
                        . json_encode($activityZonesJSON->samples[14]->{'activity-zones'}) . "','"
                        . json_encode($activityZonesJSON->samples[15]->{'activity-zones'}) . "','"
                        . json_encode($activityZonesJSON->samples[16]->{'activity-zones'}) . "','"
                        . json_encode($activityZonesJSON->samples[17]->{'activity-zones'}) . "','"
                        . json_encode($activityZonesJSON->samples[18]->{'activity-zones'}) . "','"
                        . json_encode($activityZonesJSON->samples[19]->{'activity-zones'}) . "','"
                        . json_encode($activityZonesJSON->samples[20]->{'activity-zones'}) . "','" 
                        . json_encode($activityZonesJSON->samples[21]->{'activity-zones'}) . "','" 
                        . json_encode($activityZonesJSON->samples[22]->{'activity-zones'}) . "','"
                        . json_encode($activityZonesJSON->samples[23]->{'activity-zones'}) . "','"
                        . $user_ID ."');";
        
                        $kysely = $DBH->prepare($sql);
                        $kysely->execute();
                    } catch(PDOException $e){
                        file_put_contents('../log/DBErrors.txt', 'failed to create row at day-table, getPolarZoneData(): ' . $e->getMessage() . "\n", FILE_APPEND);
                    }
                }
            }
        }
    }
    
    /**
     * Kuittaa haetut tiedot Polarille, ettei niitä haeta enää uudestaan
     */
    function commitPolarTransaction($polar_ID, $polar_token, $transactionID){
        $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.polaraccesslink.com/v3/users/" . $polar_ID . "/activity-transactions/" . $transactionID,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Authorization: Bearer " . $polar_token,
                "Cookie: NSC_ued1-qspe-xxb-mc-ttm=ffffffffc3a0989545525d5f4f58455e445a4a4229a9"
            )
            ));

            curl_exec($curl);
            $serverResponse = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            //echo("Commit: " . $serverResponse);
            curl_close($curl);
    }

    function deletePolar($polar_ID, $polar_token, $DBH){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.polaraccesslink.com/v3/users/" . $polar_ID,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "DELETE",
        CURLOPT_HTTPHEADER => array(
            "Accept: application/json",
            "Authorization: Bearer " . $polar_token
        )
        ));

        curl_exec($curl);
        $serverResponse = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $sql = 'UPDATE ts_user SET polar_ID = NULL , polar_token = NULL WHERE polar_ID = "' . $polar_ID . '";';
        $kysely = $DBH->prepare($sql);
        $kysely->execute();

        return $serverResponse;
    }

    function getPolarToken($DBH, $user_ID){
        try{
            $sql = 'SELECT `polar_token` FROM `ts_user` WHERE `user_ID` = "' . $user_ID . '";';
            $kysely = $DBH->prepare($sql);
            $kysely->execute();
            $polar_token = $kysely->fetch()[0];

            if($polar_token != null){
                return $polar_token;
            } else{
                return null;
            }
        } catch(PDOException $e){
            file_put_contents('../log/DBErrors.txt', 'getPolarToken() failed: ' . $e->getMessage() . "\n", FILE_APPEND);
        }
    }
    
    // Palauttaa Polar ID:n tietokannasta
    function getPolarID($DBH, $user_ID){
        try{
            $sql = 'SELECT `polar_ID` FROM `ts_user` WHERE `user_ID` = "' . $user_ID . '";';
            $kysely = $DBH->prepare($sql);
            $kysely->execute();
            $polar_ID = $kysely->fetch()[0];

            if($polar_ID != null){
                return $polar_ID;
            } else{
                return null;
            }
        } catch(PDOException $e){
            file_put_contents('../log/DBErrors.txt', 'getPolarID() failed: ' . $e->getMessage() . "\n", FILE_APPEND);
        }
    }
    
    // Hae Polarilta käyttäjän access token ja tallenna tietokantaan
    function createToken($authCode, $clientEncoded, $DBH, $user_ID){
        // Postmanista saatu POST-kysely
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://polarremote.com/v2/oauth2/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>"grant_type=authorization_code&code=" . $authCode,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded",
                "Accept: application/json;charset=UTF-8",
                "Authorization: Basic " . $clientEncoded,
                "Content-Type: text/plain"
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        
        // Muutetaan vastaus JSON
        $responseJSON = json_decode($response);
        $token = $responseJSON->access_token;
        $polar_ID = $responseJSON->x_user_id;

        // Viedään kantaan käyttäjän token ja polar_ID 
        try{
            $sql = 'UPDATE `ts_user` SET `polar_token` = "' . $token . '", `polar_ID` = "' . $polar_ID . '" WHERE `user_ID` = "' . $user_ID . '";';
            $kysely = $DBH->prepare($sql);
            $kysely->execute();
        } catch(PDOException $e){
            file_put_contents('../log/DBErrors.txt', 'Error saving Polar token: ' . $e->getMessage() . "\n", FILE_APPEND);
        }
        
    }

    // Rekisteröi käyttäjän Polar linkityksen sovellukseen
    function registerUser($DBH, $user_ID){

        // Haetaan käyttäjä oliona
        try{
            $sql = "SELECT * FROM `ts_user` WHERE `user_ID` = " . "'" . $user_ID . "';";
            $kysely = $DBH->prepare($sql);
            $kysely->execute();
            $kysely -> setFetchMode(PDO::FETCH_OBJ);
            $userOlio = $kysely->fetch();
        } catch(PDOException $e){
            file_put_contents('../log/DBErrors.txt', 'Couldnt get userdata to register user, registerUser(): ' . $e->getMessage() . "\n", FILE_APPEND);
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.polaraccesslink.com/v3/users",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => "<register>\n<member-id>" . $userOlio->first_name . " " . $userOlio->last_name . "</member-id>\n</register>",
            CURLINFO_HEADER_OUT => true,
            CURLOPT_HTTPHEADER => array(
                "Host: www.polaraccesslink.com",
                "Content-Type: application/xml",
                "Accept: application/json",
                "Authorization: Bearer " . $userOlio->polar_token
            )
        ));

        $response = curl_exec($curl);
        $serverResponse = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $info = curl_getinfo($curl, CURLINFO_HEADER_OUT);
        if($serverResponse != "200"){
            file_put_contents('../log/DBErrors.txt', 'Couldnt register user, registerUser(), server response code: ' . $serverResponse . "\n" . $info . "\n", FILE_APPEND);
        }
        curl_close($curl);

        // Jos tietokannassa ei pituutta tai painoa
        $responseJSON = json_decode($response);
        $birthday = $responseJSON->birthdate;
        $weight = $responseJSON->weight;
        $height = $responseJSON->height;

        if(($userOlio->weight == 0) && ($userOlio->height == 0) && ($userOlio->birthday == NULL)){
            try{
                $sql = 'UPDATE `ts_user` SET `weight` = "' . $weight . '", `height` = "' . $height . '", `birthday` = "' . $birthday . '" WHERE `user_ID` = "' . $user_ID . '";';
                $kysely = $DBH->prepare($sql);
                $kysely->execute();
            } catch(PDOException $e){
                file_put_contents('../log/DBErrors.txt', 'Couldnt save userdata to database, registerUser(): ' . $e->getMessage() . "\n", FILE_APPEND);
            }
        }
        
        return $serverResponse;

    } 
    
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
        $userOlio = $kysely->fetch();

        if($userOlio){
            return $userOlio;
        } else{
            return null;
        }
    }

    // Hae käyttäjän parametritiedot tietokannasta
    function getUserParameters($user_ID, $DBH){
        $sql = "SELECT * FROM `ts_user_parameters` WHERE `user_ID` = " . "'" . $user_ID . "';";
        $kysely = $DBH->prepare($sql);
        $kysely->execute();
        $kysely -> setFetchMode(PDO::FETCH_OBJ);
        $userParametersOlio = $kysely->fetch();

        if($userParametersOlio){
            return $userParametersOlio;
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


    function getEmail($user_ID, $email, $password, $DBH){

        $sql = "SELECT * FROM `ts_user` WHERE `user_ID` = '" . $user_ID . "';";
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

        if($unenLaatu == null || $unenLaatu == 0){
            echo('class="fas fa-meh-blank hymio" style="color: var(--liikennevaloHarmaa);"');
        } elseif($unenLaatu > 2){
            //fa-laugh
            echo('class="fas fa-laugh hymio" style="color: var(--liikennevaloVihrea);"');
        } elseif($unenLaatu <= 2 && $unenLaatu >= -2){
            //fa-meh
            echo('class="fas fa-meh hymio" style="color: var(--liikennevaloKeltainen);"');
        } elseif($unenLaatu < -2){
            //fa-frown
            echo('class="fas fa-frown hymio" style="color: var(--liikennevaloPunainen);"');
        }
    }

    //ruoka-indikaattori
    function getFoodIndikator($paivaOlio){
        $indikaattori = $paivaOlio->indikator;

        if($indikaattori > 3){
            echo('class="fas fa-laugh hymio-indikaattori"');
        }
        elseif($indikaattori > 0 && $indikaattori < 4){
            //fa-laugh
            echo('class="fas fa-smile hymio-indikaattori"');
        } elseif($indikaattori == 0){
            //fa-meh
            echo('class="fas fa-meh-blank hymio-indikaattori"');
        }elseif($indikaattori < 0 && $indikaattori > -4){
            //fa-meh
            echo('class="fas fa-frown hymio-indikaattori"');
        } elseif($indikaattori < -3){
            //fa-frown
            echo('class="fas fa-sad-tear hymio-indikaattori"');
        }
    }
    //alkoholi-indikaattori
    function getAlcoholIndikator($paivaOlio){
        $alcohol_indikaattori = $paivaOlio->alcohol_indikator;

        if($alcohol_indikaattori > 3){
            echo('class="fas fa-laugh hymio-indikaattori"');
        }
        elseif($alcohol_indikaattori > 0 && $alcohol_indikaattori < 4){
            //fa-laugh
            echo('class="fas fa-smile hymio-indikaattori"');
        } elseif($alcohol_indikaattori == 0){
            //fa-meh
            echo('class="fas fa-meh-blank hymio-indikaattori"');
        }elseif($alcohol_indikaattori < 0 && $alcohol_indikaattori > -4){
            //fa-meh
            echo('class="fas fa-frown hymio-indikaattori"');
        } elseif($alcohol_indikaattori < -3){
            //fa-frown
            echo('class="fas fa-sad-tear hymio-indikaattori"');
        }
    }
    //aktiivisuus-indikaattori
    function getActivityIndikator($paivaOlio){
        $activity_indikaattori = $paivaOlio->activity_indikator;

        if($activity_indikaattori > 3){
            echo('class="fas fa-laugh hymio-indikaattori"');
        }
        elseif($activity_indikaattori > 0 && $activity_indikaattori < 4){
            //fa-laugh
            echo('class="fas fa-smile hymio-indikaattori"');
        } elseif($activity_indikaattori == 0){
            //fa-meh
            echo('class="fas fa-meh-blank hymio-indikaattori"');
        }elseif($activity_indikaattori < 0 && $activity_indikaattori > -4){
            //fa-meh
            echo('class="fas fa-frown hymio-indikaattori"');
        } elseif($activity_indikaattori < -3){
            //fa-frown
            echo('class="fas fa-sad-tear hymio-indikaattori"');
        }
    }
    //tupakointi-indikaattori
    function getSmokeIndikator($paivaOlio){
        $smoke_indikaattori = $paivaOlio->smoke_indikator;
        if($smoke_indikaattori == 0){
            echo('class="fas fa-meh-blank hymio-indikaattori"');
        }elseif($smoke_indikaattori == 1){
            echo('class="fas fa-frown hymio-indikaattori"');
        }elseif($smoke_indikaattori == 2){
            echo('class="fas fa-smile hymio-indikaattori"');
        }
    }

    //vireys-indikaattori
    function getVitalityIndikator($paivaOlio){
        $vitality_indikaattori = $paivaOlio->vitality_indikator;

        if($vitality_indikaattori > 3){
            echo('class="fas fa-laugh hymio-indikaattori"');
        }
        elseif($vitality_indikaattori > 0 && $vitality_indikaattori < 4){
            //fa-laugh
            echo('class="fas fa-smile hymio-indikaattori"');
        } elseif($vitality_indikaattori == 0){
            //fa-meh
            echo('class="fas fa-meh-blank hymio-indikaattori"');
        }elseif($vitality_indikaattori < 0 && $vitality_indikaattori > -4){
            //fa-meh
            echo('class="fas fa-frown hymio-indikaattori"');
        } elseif($vitality_indikaattori < -3){
            //fa-frown
            echo('class="fas fa-sad-tear hymio-indikaattori"');
        }
    }
    //lääke-indikaattori
     function getMedicineIndikator($paivaOlio){
        $medicine_indikaattori = $paivaOlio->medicine_indikator;
        if($medicine_indikaattori == 0){
            echo('class="fas fa-meh-blank hymio-indikaattori"');
        }elseif($medicine_indikaattori == 1){
            echo('class="fas fa-smile hymio-indikaattori"');
        }
    }
    //kofeiinituotteiden-indikaattori
    function getStimulantIndikator($paivaOlio){
        $stimulant_indikaattori = $paivaOlio->stimulant_indikator;

        if($stimulant_indikaattori > 3){
            echo('class="fas fa-laugh hymio-indikaattori"');
        }
        elseif($stimulant_indikaattori > 0 && $stimulant_indikaattori < 4){
            //fa-laugh
            echo('class="fas fa-smile hymio-indikaattori"');
        } elseif($stimulant_indikaattori == 0){
            //fa-meh
            echo('class="fas fa-meh-blank hymio-indikaattori"');
        }elseif($stimulant_indikaattori < 0 && $stimulant_indikaattori > -4){
            //fa-meh
            echo('class="fas fa-frown hymio-indikaattori"');
        } elseif($stimulant_indikaattori < -3){
            //fa-frown
            echo('class="fas fa-sad-tear hymio-indikaattori"');
        }
    }
    //stressi-indikaattori
    function getStressIndikator($paivaOlio){
        $stress_indikaattori = $paivaOlio->stress_indikator;

        if($stress_indikaattori > 3){
            echo('class="fas fa-laugh hymio-indikaattori"');
        }
        elseif($stress_indikaattori > 0 && $stress_indikaattori < 4){
            //fa-laugh
            echo('class="fas fa-smile hymio-indikaattori"');
        } elseif($stress_indikaattori == 0){
            //fa-meh
            echo('class="fas fa-meh-blank hymio-indikaattori"');
        }elseif($stress_indikaattori < 0 && $stress_indikaattori > -4){
            //fa-meh
            echo('class="fas fa-frown hymio-indikaattori"');
        } elseif($stress_indikaattori < -3){
            //fa-frown
            echo('class="fas fa-sad-tear hymio-indikaattori"');
        }
    }
    //mieliala-indikaattori
    function getMoodIndikator($paivaOlio){
        $mood_indikaattori = $paivaOlio->mood_indikator;

        if($mood_indikaattori > 3){
            echo('class="fas fa-laugh hymio-indikaattori"');
        }
        elseif($mood_indikaattori > 0 && $mood_indikaattori < 4){
            //fa-laugh
            echo('class="fas fa-smile hymio-indikaattori"');
        } elseif($mood_indikaattori == 0){
            //fa-meh
            echo('class="fas fa-meh-blank hymio-indikaattori"');
        }elseif($mood_indikaattori < 0 && $mood_indikaattori > -4){
            //fa-meh
            echo('class="fas fa-frown hymio-indikaattori"');
        } elseif($mood_indikaattori < -3){
            //fa-frown
            echo('class="fas fa-sad-tear hymio-indikaattori"');
        }
    }
    //uniaika-indikaattori
    function getSleepAmountIndikator($paivaOlio){
        $sleep_amount_indikaattori = $paivaOlio->sleep_amount_indikator;

        if($sleep_amount_indikaattori > 3){
            echo('class="fas fa-laugh hymio-indikaattori"');
        }
        elseif($sleep_amount_indikaattori > 0 && $sleep_amount_indikaattori < 4){
            //fa-laugh
            echo('class="fas fa-smile hymio-indikaattori"');
        } elseif($sleep_amount_indikaattori == 0){
            //fa-meh
            echo('class="fas fa-meh-blank hymio-indikaattori"');
        }elseif($sleep_amount_indikaattori < 0 && $sleep_amount_indikaattori > -4){
            //fa-meh
            echo('class="fas fa-frown hymio-indikaattori"');
        } elseif($sleep_amount_indikaattori < -3){
            //fa-frown
            echo('class="fas fa-sad-tear hymio-indikaattori"');
        }
    }
    //ruutuaika-indikaattori
    function getScreenTimeIndikator($paivaOlio){
        $screen_time_indikaattori = $paivaOlio->screen_time_indikator;

        if($screen_time_indikaattori > 3){
            echo('class="fas fa-laugh hymio-indikaattori"');
        }
        elseif($screen_time_indikaattori > 0 && $screen_time_indikaattori < 4){
            //fa-laugh
            echo('class="fas fa-smile hymio-indikaattori"');
        } elseif($screen_time_indikaattori == 0){
            //fa-meh
            echo('class="fas fa-meh-blank hymio-indikaattori"');
        }elseif($screen_time_indikaattori < 0 && $screen_time_indikaattori > -4){
            //fa-meh
            echo('class="fas fa-frown hymio-indikaattori"');
        } elseif($screen_time_indikaattori < -3){
            //fa-frown
            echo('class="fas fa-sad-tear hymio-indikaattori"');
        }
    }
    //kipu-indikaattori
    function getPainIndikator($paivaOlio){
        $pain_indikaattori = $paivaOlio->pain_indikator;

        if($pain_indikaattori > 3){
            echo('class="fas fa-laugh hymio-indikaattori"');
        }
        elseif($pain_indikaattori > 0 && $pain_indikaattori < 4){
            //fa-laugh
            echo('class="fas fa-smile hymio-indikaattori"');
        } elseif($pain_indikaattori == 0){
            //fa-meh
            echo('class="fas fa-meh-blank hymio-indikaattori"');
        }elseif($pain_indikaattori < 0 && $pain_indikaattori > -4){
            //fa-meh
            echo('class="fas fa-frown hymio-indikaattori"');
        } elseif($pain_indikaattori < -3){
            //fa-frown
            echo('class="fas fa-sad-tear hymio-indikaattori"');
        }
    }

    // Muuta pääsivun hymiön väri unenlaadun mukaisesti
    function getHymioFromDate($paivaOlio){
        $unenLaatu = $paivaOlio->user_sleep_quality;

        if($unenLaatu == null || $unenLaatu == 0){
            echo('class="fas fa-meh-blank hymio-viikko" style="color: var(--liikennevaloHarmaa);"');
        } elseif($unenLaatu > 2){
            //fa-laugh
            echo('class="fas fa-laugh hymio-viikko" style="color: var(--liikennevaloVihrea);"');
        }elseif($unenLaatu <= 2 && $unenLaatu >= -2){
            //fa-meh
            echo('class="fas fa-meh hymio-viikko" style="color: var(--liikennevaloKeltainen);"');
        } elseif($unenLaatu < -2){
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

    /*function getMonthDays($currentDay){

        $mountDays = ['yksi','kaksi','kolme', '4', '5', '6', '7','8','9', '10', '11', '12', '13','14','15', '16', '17', '18', '19','20','21', '22', '23', '24', '25','26','27', '28', '29', '30', '31'];
        for($i = 0; $i < 31; $i++){
            $mounths[$i] = date('Y-m-d', strtotime($mountDays[$i] . ' this mounth', strtotime($currentDay)));
        }
        
        return $mounths;
    }*/

    // Hakee päivämäärän mukaan kyselyn tiedot tietokannasta ja palauttaa muutos% progressbariin
    function getDayProgressValue($day){
        $pos = 0;
        $neg = 0;

        $icon = [
            "$day->user_food", 
            "$day->user_alcohol", 
            "$day->user_activity", 
            "$day->user_smoke", 
            "$day->user_vitality", 
            "$day->user_stimulant", 
            "$day->user_medicine", 
            "$day->user_stress", 
            "$day->user_mood", 
            "$day->sleep_amount", 
            "$day->user_screen_time", 
            "$day->user_pain"
        ];

        for($i = 0; $i < 12; $i++){
            $value = $icon[$i];

            if($value == 0){
                $pos += 0;
            } elseif($value > 0){
                $pos += $value;
            } else{
                $neg += (-1) * $value;
            }
        }


        if($pos == 0 && $neg == 0){
            $pospro = 0;
            $negpro = 0;
        } elseif($pos == 0){
            $pospro = 0;
            $negpro = 100;
        } elseif($neg == 0){
            $pospro = 100;
            $negpro = 0;
        } else{
            $pospro = round(($pos/($pos+$neg))*100);
            $negpro = 100 - $pospro;
        }

        echo("<div>" . $pospro . " - " . $negpro . "</div>");

        if($pos == 0 && $neg == 0){
            //echo("<div>" . 50 . "-" . 50 . "</div>");
            return 0;
        } elseif($pos == 0){
            //echo("<div>" . 50 . "-" . 50 . "</div>");
            return 1;
        } elseif($neg == 0){
            return 100;
        } else{
            $tulos = round(($pos/($pos+$neg))*100);
            return $tulos;
        }
    }

    //** Ikoni funktiot */
      // < -2 = punainen 
        // < 2 = && > -2 = keltainen 
        // > 2 = vihreä 
        // Ei täytetty = NULL (default) = harmaa 

    // Ruoka
    function getIconColorFood($value){
        if($value==0){
            echo(" var(--liikennevaloHarmaa)");
        }elseif($value > 0){
            echo("var(--liikennevaloVihrea)");
        }elseif($value < 0){
            echo("var(--liikennevaloPunainen)");
        }
    }
  
    // Alkoholi
    function getIconColorAlcohol($value){
        if($value==0){
            echo("var(--liikennevaloHarmaa)");
        }elseif($value > 0){
            echo("var(--liikennevaloVihrea)");
        }elseif($value < 0){
            echo("var(--liikennevaloPunainen)");
        }
    }

    // Vireys
    function getIconColorVitality($value){
        if($value==0){
            echo("var(--liikennevaloHarmaa)");
        }elseif($value > 0){
            echo("var(--liikennevaloVihrea)");
        }elseif($value < 0){
            echo("var(--liikennevaloPunainen)");
        }
    }

    // Piristeet
    function getIconColorStimulant($value){
        if($value==0){
            echo("var(--liikennevaloHarmaa)");
        }elseif($value > 0){
            echo("var(--liikennevaloVihrea)");
        }elseif($value < 0){
            echo("var(--liikennevaloPunainen)");
        }
    }

    // Stressi
    function getIconColorStress($value){
        if($value==0){
            echo("var(--liikennevaloHarmaa)");
        }elseif($value > 0){
            echo("var(--liikennevaloVihrea)");
        }elseif($value < 0){
            echo("var(--liikennevaloPunainen)");
        }
    }

    // Mieliala
    function getIconColorMood($value){
        if($value==0){
            echo("var(--liikennevaloHarmaa)");
        }elseif($value > 0){
            echo("var(--liikennevaloVihrea)");
        }elseif($value < 0){
            echo("var(--liikennevaloPunainen)");
        }
    }

    // Kivut
    function getIconColorPains($value){
        if($value==0){
            echo("var(--liikennevaloHarmaa)");
        }elseif($value > 0){
            echo("var(--liikennevaloVihrea)");
        }elseif($value < 0){
            echo("var(--liikennevaloPunainen)");
        }
    }

     // Lääkkeet (boolean)
    function getIconColorMedicine($value){
        if($value == 1){
            echo("var(--liikennevaloVihrea)");
        } elseif($value==0){
            echo("var(--liikennevaloHarmaa)");
        }
    }

     // ruutuaika
    function getIconColorScreenTime($value){
        if($value==0){
            echo("var(--liikennevaloHarmaa)");
        }elseif($value > 0){
            echo("var(--liikennevaloVihrea)");
        }elseif($value < 0){
            echo("var(--liikennevaloPunainen)");
        }
    }
    // Tupakointi (boolean)
    function getIconColorSmoke($value){
        if($value == 0){
            echo("var(--liikennevaloHarmaa)");
        }elseif($value == 1){
            echo("var(--liikennevaloPunainen)");
        }elseif($value == 2){
            echo("var(--liikennevaloVihrea)");
        }
    }

     // Aktiivisuus
    function getIconColorActivity($value){
        if($value==0){
            echo("var(--liikennevaloHarmaa)");
        }elseif($value > 0){
            echo("var(--liikennevaloVihrea)");
        }elseif($value < 0){
            echo("var(--liikennevaloPunainen)");
        }
    }

    // Nukuttu aika
    function getIconColorSleepAmount($value){
        if($value == null){
            echo("var(--liikennevaloHarmaa)");
        }elseif($value >= 28800){
            echo("var(--liikennevaloVihrea)");
        } elseif($value < 28800){
            echo("var(--liikennevaloPunainen)");
        }
    }

    // Määrittää ikonien värin viikkonäkymän detailsivulla
    function getIconColor($iconName, $value){
        if($iconName == 3){ // Tupakka

            if($value == 0){
                return 'style="color: var(--liikennevaloHarmaa)";';
            }else if($value == 1){
                return 'style="color: var(--liikennevaloPunainen)";';
            }else if($value == 2){
                return 'style="color: var(--liikennevaloVihrea)";';
            }
        } else if($iconName == 6){ // Lääkkeet

            if($value == 1){
                return 'style="color: var(--liikennevaloVihrea)";';
            } else if($value == 0){
                return 'style="color: var(--liikennevaloHarmaa)";';
            }
        } else{ // Muille

            if($value == 0){
                return 'style="color: var(--liikennevaloHarmaa)";';
            }else if($value > 0){
                return 'style="color: var(--liikennevaloVihrea)";';
            }else if($value < 0){
                return 'style="color: var(--liikennevaloPunainen)";';
            }
        }
    }

    // Palauttaa indikaattorin viikkonäkymän detailsivulla keskiarvon mukaisesti
    function getIndicator($value){
        if($value > 3){
            return 'class = "fas fa-laugh hymio-indikaattori" style = "color: var(--liikennevaloVihrea)"';
        } else if($value > 0){
            return 'class = "fas fa-smile hymio-indikaattori" style = "color: var(--liikennevaloVihrea)"';
        } else if($value == 0){
            return 'class = "fas fa-meh-blank hymio-indikaattori" style = "color: var(--liikennevaloHarmaa)"';
        } else if($value < 0 && $value > -4){
            return 'class = "fas fa-frown hymio-indikaattori" style = "color: var(--liikennevaloPunainen)"';
        } else if($value < -3){
            return 'class = "fas fa-sad-tear hymio-indikaattori" style = "color: var(--liikennevaloPunainen)"';
        }
    }
?>