<?php
session_start();
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Baloo+Da+2&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/styles_test.css">
    <title>teh Syke</title>
</head>
<body>

<i class="far fa-times-circle" id="createUserParametersClose"></i>

<?php
    include_once("config/https.php");
    include_once("config/config.php");
    include("forms/formCreateUserParameters.php");

    print_r($data);
    echo session_id();

    if(isset($_POST['createUserDetailsSubmit'])){

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

        print_r($data);
        echo session_id();
         

    ?>
    <script>
        document.querySelector(".createUserParametersPopup").style.visibility = "visible";
    </script>
    <?php
        
    
    //if(isset($_POST['createUserParametersSubmit'])){

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

    }
}

?>




</body>
</html>