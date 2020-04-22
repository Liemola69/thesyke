<?php
    include("forms/formKayttoehdot.php");

    //Session debuggaus, kommentoi pois tarvittaessa
    //echo session_id();
    //echo "<br>";
    //print_r($_SESSION);
    //echo "<br>";
    //print_r($_POST);
    
    //Tarkista onko luo tunnus -painiketta painettu ja tunnus ja salasana tallennettu sessiomuuttujiin
    if(isset($_POST['kayttoehdotSubmit']
    )){
        header("Location: php/sivurunko.php");
    }
?>