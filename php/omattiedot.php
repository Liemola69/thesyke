<?php
    include_once("../config/https.php");
    include_once("../config/config.php");
    include("../php/functions.php");
?>

<!DOCTYPE html>
<html>
<head>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<link rel="stylesheet" href="../styles/styles_test.css">
<link href="https://fonts.googleapis.com/css?family=Baloo+Da+2&display=swap" rel="stylesheet">
</head>
<body>

    <?php
    // Hae käyttäjän perustiedot userOlio-muuttujaan ja sessiomuuttujiin
    $userOlio = getUserData($_SESSION['user_ID'], $DBH);
    $_SESSION['got_user_ID'] = $userOlio->user_ID;
    $_SESSION['got_email'] = $userOlio->email;
    $_SESSION['got_password'] = $userOlio->password;
    $_SESSION['got_first_name'] = $userOlio->first_name;
    $_SESSION['got_last_name'] = $userOlio->last_name;
    $_SESSION['got_gender'] = $userOlio->gender;
    $_SESSION['got_height'] = $userOlio->height;
    $_SESSION['got_weight'] = $userOlio->weight;
    $_SESSION['got_birthday'] = $userOlio->birthday;

    // Hae käyttäjän parametritiedot userParametersOlio-muuttujaan ja sessiomuuttujiin
    $userParametersOlio = getUserParameters($_SESSION['user_ID'], $DBH);
    $_SESSION['got_parameters_stimulants'] = $userParametersOlio->parameters_stimulants;
    $_SESSION['got_parameters_alcohol'] = $userParametersOlio->parameters_alcohol;
    $_SESSION['got_parameters_medicine'] = $userParametersOlio->parameters_medicine;
    $_SESSION['got_parameters_drug'] = $userParametersOlio->parameters_drug;
    $_SESSION['got_parameters_screen_time'] = $userParametersOlio->parameters_screen_time;
    $_SESSION['got_parameters_smoke'] = $userParametersOlio->parameters_smoke;
    $_SESSION['got_parameters_user_agreement'] = $userParametersOlio->parameters_user_agreement;
    $_SESSION['got_parameters_email_marketing'] = $userParametersOlio->parameters_email_marketing;
    $_SESSION['got_parameters_gdpr'] = $userParametersOlio->parameters_gdpr;

    if ($_SESSION['got_parameters_stimulants'] == '1') {
        $_SESSION['got_parameters_stimulants_checked'] = 'checked';
    }

    if ($_SESSION['got_parameters_alcohol'] == '1') {
        $_SESSION['got_parameters_alcohol_checked'] = 'checked';
    }

    if ($_SESSION['got_parameters_medicine'] == '1') {
        $_SESSION['got_parameters_medicine_checked'] = 'checked';
    }

    if ($_SESSION['got_parameters_drug'] == '1') {
        $_SESSION['got_parameters_drug_checked'] = 'checked';
    }

    if ($_SESSION['got_parameters_screen_time'] == '1') {
        $_SESSION['got_parameters_screen_time_checked'] = 'checked';
    }

    if ($_SESSION['got_parameters_smoke'] == '1') {
        $_SESSION['got_parameters_smoke'] = 'checked';
    }

    if ($_SESSION['got_parameters_user_agreement'] == '1') {
        $_SESSION['got_parameters_user_agreement_checked'] = 'checked';
    }

    if ($_SESSION['got_parameters_email_marketing'] == '1') {
        $_SESSION['got_parameters_email_marketing_checked'] = 'checked';
    }

    if ($_SESSION['got_parameters_gdpr'] == '1') {
        $_SESSION['got_parameters_gdpr_checked'] = 'checked';
    }

    //testiprinttaus sessiomuuttujista, kommentoi pois
    //print_r($_SESSION);

    ?>

    <?php
    if(isset($_POST['saveUserDetails'])){

        //lomakkeen tiedot sessiomuuttujiin

        $_SESSION['email'] = $_POST['email'];
        $_SESSION['first_name'] = $_POST['first_name'];
        $_SESSION['last_name'] = $_POST['last_name'];
        $_SESSION['gender'] = $_POST['gender'];
        $_SESSION['height'] = (int)$_POST['height'];
        $_SESSION['weight'] = (int)$_POST['weight'];
        $_SESSION['birthdate'] = $_POST['birthdate'];

        if(isset($_POST['stimulants'])) {
            $_SESSION['parameters_stimulants'] = '1';
        } else {
            $_SESSION['parameters_stimulants'] = '0';
        }

        if(isset($_POST['stimulants'])) {
            $_SESSION['parameters_alcohol'] = '1';
        } else {
            $_SESSION['parameters_alcohol'] = '0';
        }

        if(isset($_POST['stimulants'])) {
            $_SESSION['parameters_medicine'] = '1';
        } else {
            $_SESSION['parameters_medicine'] = '0';
        }

        if(isset($_POST['drugss'])) {
            $_SESSION['parameters_drug'] = '1';
        } else {
            $_SESSION['parameters_drug'] = '0';
        }

        if(isset($_POST['cigarette'])) {
            $_SESSION['parameters_parameters_smoke'] = '1';
        } else {
            $_SESSION['parameters_parameters_smoke'] = '0';
        }

        if(isset($_POST['user_agreement'])) {
            $_SESSION['parameters_user_agreement'] = '1';
        } else {
            $_SESSION['parameters_user_agreement'] = '0';
        }

        if(isset($_POST['email_marketing'])) {
            $_SESSION['parameters_email_marketing'] = '1';
        } else {
            $_SESSION['parameters_email_marketing'] = '0';
        }

        if(isset($_POST['gdpr'])) {
            $_SESSION['parameters_gdpr'] = '1';
        } else {
            $_SESSION['parameters_gdpr'] = '0';
        }
    

        //tiedot data-muuttujiin
        $data['user_ID']= $_SESSION['user_ID'];


            
            try{
                $sql = 'UPDATE `ts_user` 
                SET
                `email` = "' . $_SESSION['email'] . '",
                `first_name` = "' . $_SESSION['first_name'] . '",
                `last_name` = "' . $_SESSION['last_name'] . '", 
                `gender` = "' . $_SESSION['gender'] . '",
                `height` = "' . $_SESSION['height'] . '", 
                `weight` = "' . $_SESSION['weight'] . '"
                WHERE `user_ID` = "' . $_SESSION['user_ID'] . '" ;';

                $kysely = $DBH->prepare($sql);
                $kysely->execute($data);

                

            }catch(PDOException $e){
                file_put_contents('../log/DBErrors.txt', 'Upadate fails ' . $e->getMessage() . "\n", FILE_APPEND);

            }
            
            header("Location: sivurunko.php");
        }else{
            include("../forms/formOmattiedot.php");
        }

        ?>

    <script>
        document.getElementById("closeOmattiedot").addEventListener("click", function(){
        document.location = 'sivurunko.php';
        })
    </script>

<script src='https://kit.fontawesome.com/a076d05399.js'></script>
<script src="../js/sivurunko.js"></script>
</body>
</html>