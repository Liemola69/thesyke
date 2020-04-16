<?php
    session_start();
    include("../forms/formPaivaKysely.php");
    include_once("../config/https.php");
    include_once("../config/config.php");
    

    //Session debuggaus, kommentoi pois tarvittaessa
    //echo session_id();
    //echo "<br>";
    //print_r($_SESSION);
    //print_r($_POST);
    
    //Tallennetaan kyselyn vastaukset SESSION-muuttujiin
    if(isset($_POST['submitPaivaKysely'])){

        $_SESSION['user_sleep_quality'] = (int)$_POST['given_Quality'];
        $_SESSION['user_vitality'] = (int)$_POST['given_Vitality'];
        $_SESSION['user_food'] = (int)$_POST['given_Food'];
        $_SESSION['user_mood'] = (int)$_POST['given_Mood'];
        $_SESSION['user_stress'] = (int)$_POST['given_Stress'];
        $_SESSION['user_pain'] = (int)$_POST['given_Pain'];

       
    }

    
    ?>
<?php
//Painaa "Tuhoa nappulaa" --> kyselyn vastaukset nollaantuu
if(isset($_POST['destroyPaivaKysely'])){
	session_unset();
	session_destroy();
	//Palataan takaisin tälle samalle sivulle jolloin sessio käynnistyy uudelleen
	header("Location: ". $_SERVER['PHP_SELF']);
}
?>


    
