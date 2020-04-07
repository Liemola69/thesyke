<?php
    session_start();
    
    //Session debuggaus, kommentoi pois tarvittaessa
    echo session_id();
    echo "<br>";
    print_r($SESSION);
    print_r($_POST);

    include("forms/formCreateUserParameters.php");

    //Tarkista onko Tallenna -painiketta painettu ja onko nimitiedot tallennettu sessiomuuttujiin
    if(isset($_POST['createUserDetailsSubmit']
    //, $_SESSION['first_name'], $SESSION['last_name']
    )){

        $SESSION['parameters_stimulants'] = $_POST['given_parameters_stimulants'];
        $SESSION['parameters_alcohol'] = $_POST['given_parameters_alcohol'];
        $SESSION['parameters_medicine'] = $_POST['given_parameters_medicine'];
        $SESSION['parameters_drug'] = $_POST['given_parameters_drug'];
        $SESSION['parameters_smoke'] = $_POST['given_parameters_smoke']; 

    ?>
    <script>
        document.querySelector(".createUserParametersPopup").style.visibility = "visible";
    </script>
    <?php
    
    /*if(isset($_POST['createUserParametersSubmit'])){

        $data['userName'] = $_POST['givenEmail'];
        $data['userPassword'] = password_hash($_POST['givenPassword'], PASSWORD_BCRYPT);
        $data['first_name'] = $_POST['given_first_name'];
        $data['last_name'] = $_POST['given_last_name'];
        $data['age'] = $_POST['given_age'];
        $data['gender'] = $_POST['given_gender'];
        $data['height'] = $_POST['given_height'];
        $data['weight'] = $_POST['given_weight'];
        $data['parameters_user_agreement'] = $_POST['given_parameters_user_agreement'];
        $data['parameters_email_marketing'] = $_POST['given_parameters_email_marketing'];
        $data['parameters_gdpr'] = $_POST['given_parameters_gdpr'];

        $data['parameters_stimulants'] = $_POST['given_parameters_stimulants'];
        $data['parameters_alcohol'] = $_POST['given_parameters_alcohol'];
        $data['parameters_medicine'] = $_POST['given_parameters_medicine'];
        $data['parameters_drug'] = $_POST['given_parameters_drug'];
        $data['parameters_smoke'] = $_POST['given_parameters_smoke'];

        try{
            // SQL-lause $data-taulukon tiedoille :key -> value
            $sql = "INSERT INTO `ts_user` (`user_ID`, `email`, `password`, `first_name`, `last_name`, `age`, `gender`, `height`)
            
            VALUES (NULL, :userName, :userPassword, :first_name, :last_name, :age, :gender, :height)";
            
            $kysely = $DBH->prepare($sql);
            $kysely->execute($data);

        } catch(PDOException $e){
            file_put_contents('log/DBErrors.txt', 'Connection: ' . $e->getMessage() . "\n", FILE_APPEND);
        //}
        */

    //}
}

?>




</body>
</html>