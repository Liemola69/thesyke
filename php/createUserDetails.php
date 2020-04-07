<?php
    session_start();
    include("forms/formCreateUserDetails.php");

    //Session debuggaus, kommentoi pois tarvittaessa
    echo session_id();
    echo "<br>";
    print_r($SESSION);
    print_r($_POST);
    
    //Tarkista onko luo tunnus -painiketta painettu ja tunnus ja salasana tallennettu sessiomuuttujiin
    if(isset($_POST['createAccountSubmit']
    //, $_SESSION['email'], $SESSION['password']
    )){

    ?>
    <script>
        document.querySelector(".createUserDetailsPopup").style.visibility = "visible";
    </script>
    <?php
    session_start();
    }

    //Tallenna syötetyt tiedot sessiomuuttujiin
    if(isset($_POST['createUserDetailsSubmit'])){

        $SESSION['first_name'] = $_POST['given_first_name'];
        $SESSION['last_name'] = $_POST['given_last_name'];
        $SESSION['age'] = $_POST['given_age'];
        $SESSION['gender'] = $_POST['given_gender'];
        $SESSION['height'] = $_POST['given_height'];
        $SESSION['weight'] = $_POST['given_weight'];
        $SESSION['parameters_user_agreement'] = $_POST['given_parameters_user_agreement'];
        $SESSION['parameters_email_marketing'] = $_POST['given_parameters_email_marketing'];
        $SESSION['parameters_gdpr'] = $_POST['given_parameters_gdpr'];

    }

?>
