<?php
    //include("forms/formApua.php");

    //Session debuggaus, kommentoi pois tarvittaessa
    //echo session_id();
    //echo "<br>";
    //print_r($_SESSION);
    //echo "<br>";
    //print_r($_POST);
    
    //Tarkista onko luo tunnus -painiketta painettu ja tunnus ja salasana tallennettu sessiomuuttujiin
    echo "TESTI";
    echo "TESTI";
    if(isset($_POST['apuaSubmit']
    )){
        header("Location: php/sivurunko.php");
    }
?>