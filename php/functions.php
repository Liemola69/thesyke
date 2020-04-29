<?php

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
                        17_to_18, 18_to_19, 19_to_20, 20_to_21, 21_to_22, 22_to_23, 23_to_24) 
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
                        . json_encode($activityZonesJSON->samples[23]->{'activity-zones'}) . "');";
        
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
        if($unenLaatu == 0){
            echo('class="fas fa-meh-blank hymio" style="color: var(--liikennevaloHarmaa);"');
        }
        elseif($unenLaatu > 2){
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
        if($unenLaatu == 0){
            echo('class="fas fa-meh-blank hymio-viikko" style="color: var(--liikennevaloHarmaa);"');
        }
        elseif($unenLaatu > 2){
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
    if($value == null){
        echo("var(--liikennevaloHarmaa)");
    }elseif($value >= 28800){
        echo("var(--liikennevaloVihrea)");
    } elseif($value >= 21600 && $value < 28800){
        echo("var(--liikennevaloKeltainen)");
    } elseif($value < 21600 && $value > 0){
        echo("var(--liikennevaloPunainen)");
    }    
}

?>