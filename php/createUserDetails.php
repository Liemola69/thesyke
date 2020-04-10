<?php
    session_start();
    include("forms/formCreateUserDetails.php");

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
        document.querySelector(".createUserDetailsPopup").style.visibility = "visible";
    </script>
    <?php
    }

    //Tallenna syötetyt tiedot sessiomuuttujiin, kun Tallenna-painiketta painettu
    //TODO, validointi
    if(isset($_POST['createUserDetailsSubmit'])){

        $_SESSION['first_name'] = $_POST['given_first_name'];
        $_SESSION['last_name'] = $_POST['given_last_name'];
        $_SESSION['age'] = (int)$_POST['given_age'];
        $_SESSION['gender'] = $_POST['given_gender'];
        $_SESSION['height'] = (int)$_POST['given_height'];
        $_SESSION['aweight'] = (int)$_POST['given_weight'];
        $_SESSION['parameters_user_agreement'] = $_POST['given_parameters_user_agreement'];
        $_SESSION['parameters_email_marketing'] = $_POST['given_parameters_email_marketing'];
        $_SESSION['parameters_gdpr'] = $_POST['given_parameters_gdpr'];

    }

?>
