<?php
    session_start();

    include("../forms/formPaivaKysely.php");
    include_once("../config/https.php");
    include_once("../config/config.php");
    include("../php/functions.php");
    

    //Session debuggaus, kommentoi pois tarvittaessa
    //echo session_id();
    //echo "<br>";
    //print_r($_SESSION);
    //print_r($_POST);
    
    //Tallennetaan kyselyn vastaukset SESSION-muuttujiin


   
   $thisDay =  getDayFormatted($_SESSION['currentDay']);
    

    if(isset($_POST['submitPaivaKysely'])){

        $_SESSION['currentDay'] = $_POST['currentDay'];
        $_SESSION['user_sleep_quality'] = (int)$_POST['given_Quality'];
        $_SESSION['user_vitality'] = (int)$_POST['given_Vitality'];
        $_SESSION['user_food'] = (int)$_POST['given_Food'];
        $_SESSION['user_mood'] = (int)$_POST['given_Mood'];
        $_SESSION['user_stress'] = (int)$_POST['given_Stress'];
        $_SESSION['user_pain'] = (int)$_POST['given_Pain'];
        $_SESSION['user_stimulant'] = (int)$_POST['given_Kofeiini'];
        $_SESSION['user_alcohol'] = (int)$_POST['given_Alkoholi'];
        $_SESSION['user_screen_time'] = (int)$_POST['given_Ruutu'];
        $_SESSION['user_smoke'] = (int)$_POST['given_Smoke'];
        $_SESSION['user_medicine'] = (int)$_POST['given_Medicine'];

        $data['date']=(int) $_SESSION['currentDay'];
        //$data['date_user_ID']= (int)$_SESSION['user_ID'];
        $data['user_sleep_quality'] = (int)$_SESSION['user_sleep_quality'];
        $data['user_vitality'] = (int)$_SESSION['user_vitality'];
        $data['user_food'] = (int)$_SESSION['user_food'];
        $data['user_mood'] = (int)$_SESSION['user_mood'];
        $data['user_stress'] = (int)$_SESSION['user_stress'];
        $data['user_pain'] = (int)$_SESSION['user_pain'];
        $data['user_stimulant'] = (int)$_SESSION['user_stimulant'];
        $data['user_alcohol'] = (int)$_SESSION['user_alcohol'];
        $data['user_screen_time'] = (int)$_SESSION['user_screen_time'];
        $data['user_smoke'] = (int)$_SESSION['user_smoke'];
        $data['user_medicine'] = (int)$_SESSION['user_medicine'];
            
        try{
            // SQL-lause $data-taulukon tiedoille :key -> value
            $sql= "INSERT INTO `ts_date` (`date_user_ID`, `date_ID`, `date`, `user_sleep_quality`,  
            `user_vitality`, `user_pain`, `user_stress`, `user_mood`, `user_stimulant`, `user_alcohol`, 
            `user_food`, `user_medicine`, `user_screen_time`, `user_smoke`)            
            VALUES (12, NULL, :date, :user_sleep_quality, :user_vitality, :user_pain, :user_stress, :user_mood, :user_stimulant,
            :user_alcohol, :user_food, :user_medicine, :user_screen_time, :user_smoke)";
    
        $kysely = $DBH->prepare($sql);
        $kysely->execute($data);

   
        //session_unset();
        //session_destroy();
        
    //Palataan takaisin tälle sivulle
        //header("Location: ". $_SERVER['PHP_SELF']);

    

        } catch(PDOException $e){
        file_put_contents('../log/DBErrors.txt', 'Connection: ' . $e->getMessage() . "\n", FILE_APPEND);

        }
        /*if(isset($_POST['destroyPaivaKysely'])){
            session_unset();
            session_destroy();
            //Palataan takaisin tälle samalle sivulle jolloin sessio käynnistyy uudelleen
            header("Location: ". $_SERVER['PHP_SELF']);
        }*/
        
    }    
    


//Painaa "Tuhoa nappulaa" --> kyselyn vastaukset nollaantuu

?>


    
