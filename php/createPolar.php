<?php
    session_start();
    include("forms/formCreatePolar.php");

    //Session debuggaus, kommentoi pois tarvittaessa
    //echo session_id();
    //echo "<br>";
    //print_r($_SESSION);
    //print_r($_POST);
    
    //Tarkista onko luo tunnus -painiketta painettu ja tunnus ja salasana tallennettu sessiomuuttujiin
    if(isset($_POST['createAccountSubmit'], $_SESSION['email'], $_SESSION['password']
    )){
    ?>
    <script>
        document.querySelector(".createPolarPopup").style.visibility = "visible";
    </script>
    <?php
    }
?>