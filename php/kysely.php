<?php
    include_once("../config/https.php");
    include_once("../config/config.php");
    include("../php/functions.php");
    
?>
<!DOCTYPE html>
<html>
<head>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<link rel="stylesheet" href="../styles/kysely.css">
</head>
<body>

<nav id="ylaNavKysely">
        <div id="sivunNimi">PÄIVÄKYSELY</div>
        <a href="sivurunko.php?moveToDay=<?php echo($_SESSION['currentDay']);?>" id="closeMenu" class='fas fa-times-circle' style='text-decoration:none;'></a>      
    </nav>
    <br>
    <div class="kyselyOtsikko">&emsp;<?php getDayFormatted($_SESSION['currentDay']); 
    //echo($currentDay);
    ?>
    päivän kysely 
    </div>
    <div class=slideSivu>


<?php   

    $paivaOlio = getDateData($_SESSION["user_ID"], $_SESSION['currentDay'], $DBH);

    if(isset($_POST['submitPaivaKysely'])){


        $date_ID = "SELECT `date_ID` FROM `ts_date` WHERE `date_user_ID` = ". "'" . $_SESSION["user_ID"] . "' AND `date` = " . "'" . $_SESSION['currentDay'] . "';";
        //echo($date_ID);
            $kysely = $DBH->prepare($date_ID);
            $kysely->execute(); 
            
            $dateIDExisits = $kysely->fetch(); //boolean false=ei löytynyt, true=löytyi
           //echo($dateIDExisits[0]);
           

        //kyselystä
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

        //indikaattorit
        $_SESSION['indikator'] = (int)$_POST['given_Food'];
        $_SESSION['alcohol_indikator'] = (int)$_POST['given_Alkoholi'];
        //$_SESSION['activity_indikator'] = (int)$_POST['given_Activity'];
        $_SESSION['smoke_indikator'] = (int)$_POST['given_Smoke'];
        $_SESSION['vitality_indikator'] = (int)$_POST['given_Vitality'];
        $_SESSION['stimulant_indikator'] = (int)$_POST['given_Kofeiini'];
        $_SESSION['medicine_indikator'] = (int)$_POST['given_Medicine'];
        $_SESSION['stress_indikator'] = (int)$_POST['given_Stress'];
        $_SESSION['mood_indikator'] = (int)$_POST['given_Mood'];
        //$_SESSION['sleep_amount_indikator'] = (int)$_POST['given_Sleep_amount'];
        $_SESSION['screen_time_indikator'] = (int)$_POST['given_Ruutu'];
        $_SESSION['pain_indikator'] = (int)$_POST['given_Pain'];


        //haetut tiedot
        $data['date']= $_SESSION['currentDay'];
        $data['date_user_ID']= $_SESSION['user_ID'];

        //$data['date_ID'] = (int)$_SESSION['date_ID'];

        //indikaattori
        $data['indikator']= $_SESSION['indikator'];
        $data['alcohol_indikator']= $_SESSION['alcohol_indikator'];
        //$data['activity_indikator']= $_SESSION['activity_indikator'];
        $data['smoke_indikator']= $_SESSION['smoke_indikator'];
        $data['vitality_indikator']= $_SESSION['vitality_indikator'];
        $data['stimulant_indikator']= $_SESSION['stimulant_indikator'];
        $data['medicine_indikator']= $_SESSION['medicine_indikator'];
        $data['stress_indikator']= $_SESSION['stress_indikator'];
        $data['mood_indikator']= $_SESSION['mood_indikator'];
        //$data['sleep_amount_indikator']= $_SESSION['sleep_amount_indikator'];
        $data['screen_time_indikator']= $_SESSION['screen_time_indikator'];
        $data['pain_indikator']= $_SESSION['pain_indikator'];

        //kyselystä
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
            
        

            if(!$dateIDExisits[0]){

        try{
            $sql= "INSERT INTO `ts_date` (`date_user_ID`, `date`, `user_sleep_quality`,  
                `user_vitality`, `user_pain`, `user_stress`, `user_mood`, `user_stimulant`, `user_alcohol`, 
                `user_food`, `user_medicine`, `user_screen_time`, `user_smoke`, `indikator`, `alcohol_indikator`, `smoke_indikator`, 
                `vitality_indikator`, `stimulant_indikator`, `medicine_indikator`, `stress_indikator`, `mood_indikator`, `screen_time_indikator`, `pain_indikator`)            
                VALUES (:date_user_ID, :date, :user_sleep_quality, :user_vitality, :user_pain, :user_stress, :user_mood, :user_stimulant,
                :user_alcohol, :user_food, :user_medicine, :user_screen_time, :user_smoke, :indikator, :alcohol_indikator, :smoke_indikator, 
                :vitality_indikator, :stimulant_indikator, :medicine_indikator, :stress_indikator, :mood_indikator, :screen_time_indikator, :pain_indikator)";

                $kysely2 = $DBH->prepare($sql);
                $kysely2->execute($data);

        }catch(PDOException $e){
            file_put_contents('../log/DBErrors.txt', 'INSERT INTO fail: ' . $e->getMessage() . "\n", FILE_APPEND);
    
            }        

            }
            else{
            try{
                $sql = 'UPDATE `ts_date` 
                SET `user_sleep_quality` = "' . $_SESSION['user_sleep_quality'] . '", `user_vitality` = "' . $_SESSION['user_vitality'] . '",
                `user_pain` = "' . $_SESSION['user_pain'] . '", `user_stress` = "' . $_SESSION['user_stress'] . '",
                `user_mood` = "' . $_SESSION['user_mood'] . '", `user_stimulant` = "' . $_SESSION['user_stimulant'] . '",
                `user_alcohol` = "' . $_SESSION['user_alcohol'] . '", `user_food` = "' . $_SESSION['user_food'] . '",
                `user_medicine` = "' . $_SESSION['user_medicine'] . '", `user_screen_time` = "' . $_SESSION['user_screen_time'] . '", 
                `user_smoke` = "' . $_SESSION['user_smoke'] .'", `indikator` = "' . $_SESSION['indikator'] . '",
                 `alcohol_indikator` = "' . $_SESSION['alcohol_indikator'] . '", `smoke_indikator` = "' . $_SESSION['smoke_indikator'] . '",
                 `vitality_indikator` = "' . $_SESSION['vitality_indikator'] . '", `stimulant_indikator` = "' . $_SESSION['stimulant_indikator'] . '",
                 `medicine_indikator` = "' . $_SESSION['medicine_indikator'] . '",`stress_indikator` = "' . $_SESSION['stress_indikator'] . '" ,
                 `mood_indikator` = "' . $_SESSION['mood_indikator'] . '", `screen_time_indikator` = "' . $_SESSION['screen_time_indikator'] . '",
                 `pain_indikator` = "' . $_SESSION['pain_indikator'] . '" 
                WHERE `date_user_ID` = "' . $_SESSION['user_ID'] . '" AND `date` = "' . $_SESSION['currentDay'] . '";';

                $kysely = $DBH->prepare($sql);
                $kysely->execute($data);
            }catch(PDOException $e){
                file_put_contents('../log/DBErrors.txt', 'Upadate fails ' . $e->getMessage() . "\n", FILE_APPEND);

            }
        
            }
            header("Location: sivurunko.php?moveToDay=" . $_SESSION['currentDay']);
        }else{
        include("../forms/formPaivaKysely.php");
    }
    
    

?>
</div>
<script src='https://kit.fontawesome.com/a076d05399.js'></script>
<script src="../js/sivurunko.js"></script>
</body>
</html>


    
