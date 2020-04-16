<?php
    session_start();
    include("forms/formCreateUserParameters.php");

    //Session debuggaus, kommentoi pois tarvittaessa
    //echo session_id();
    //echo "<br>";
    //print_r($_SESSION);
    //print_r($_POST);

    

    //Tarkista onko Tallenna -painiketta painettu ja onko nimitiedot tallennettu sessiomuuttujiin
    if(isset($_POST['createUserDetailsSubmit'], $_SESSION['first_name'], $_SESSION['last_name']
    )){

    ?>
    <script>
        document.querySelector(".createUserParametersPopup").style.visibility = "visible";
    </script>
    <?php
    }

    //Tietojen tallennus sessiotietoihin ja session-tiedoista dataan
    //TODO, validointi

    if(isset($_POST['createUserParametersSubmit'])){

    $_SESSION['parameters_stimulants'] = $_POST['parameters_stimulants'];
    $_SESSION['parameters_alcohol'] = $_POST['parameters_alcohol'];
    $_SESSION['parameters_medicine'] = $_POST['parameters_medicine'];
    $_SESSION['parameters_drug'] = $_POST['parameters_drug'];
    $_SESSION['parameters_smoke'] = $_POST['parameters_smoke']; 

    $data['email'] = $_SESSION['email'];
    $data['password'] = $_SESSION['password'];
    $data['first_name'] = $_SESSION['first_name'];
    $data['last_name']= $_SESSION['last_name'];
    $data['age'] = (int)$_SESSION['age'];
    $data['gender'] = $_SESSION['gender'];
    $data['height'] = (int)$_SESSION['height'];
    $data['aweight'] = (int)$_SESSION['aweight'];
    $data2['parameters_user_agreement'] = $_SESSION['parameters_user_agreement'];
    $data2['parameters_email_marketing'] = $_SESSION['parameters_email_marketing'];
    $data2['parameters_gdpr'] = $_SESSION['parameters_gdpr'];
    $data2['parameters_stimulants'] = $_SESSION['parameters_stimulants'];
    $data2['parameters_alcohol'] = $_SESSION['parameters_alcohol'];
    $data2['parameters_medicine'] = $_SESSION['parameters_medicine'];
    $data2['parameters_drug'] = $_SESSION['parameters_drug'];
    $data2['parameters_smoke'] = $_SESSION['parameters_smoke'];

    

    try{
        // SQL-lause $data-taulukon tiedoille :key -> value
        $sql = "INSERT INTO `ts_user` (`user_ID`, `email`, `password`, `first_name`, `last_name`, `age`, `gender`, `height`, `weight`)            
        VALUES (NULL, :email, :password, :first_name, :last_name, :age, :gender, :height, :aweight)";

        //$sql2 = "INSERT INTO `ts_user_parameters` (`user_ID`, `parameters_ID`, `parameters_stimulants`, `parameters_alcohol`, `parameters_medicine`, `parameters_drug`, `parameters_smoke`)            
        //VALUES (:userID, NULL, :parameters_stimulants, :parameters_alcohol, :parameters_medicine, :parameters_drug, :parameters_smoke)";
      
        $kysely = $DBH->prepare($sql);
        $kysely->execute($data);

        //$kysely2 = $DBH->prepare($sql2);
        //$kysely2->execute($data2);

        

    } catch(PDOException $e){
        file_put_contents('log/DBErrors.txt', 'Connection: ' . $e->getMessage() . "\n", FILE_APPEND);

    }


    ?>
    <script>
        // Get the snackbar DIV
        var x = document.getElementById("snackbar");
      
        // Add the "show" class to DIV
        x.className = "show";
      
        // After 3 seconds, remove the show class from DIV
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
      </script>
    <?php



    header("Location: teaser.php");
    
}
    


     


?>