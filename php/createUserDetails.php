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

<i class="far fa-times-circle" id="createUserDetailsClose"></i>

<?php
    include_once("config/https.php");
    include_once("config/config.php");
    include("forms/formCreateUserDetails.php");

    print_r($data);
    echo session_id();

    if(isset($_POST['createAccountSubmit'])){

    ?>
    <script>
        document.querySelector(".createUserDetailsPopup").style.visibility = "visible";
    </script>
    <?php
        session_start();
    }

    if(isset($_POST['createUserDetailsSubmit'])){

        //$data['first_name'] = $_POST['given_first_name'];
        //$data['last_name'] = $_POST['given_last_name'];
        //$data['age'] = $_POST['given_age'];
        //$data['gender'] = $_POST['given_gender'];
        //$data['height'] = $_POST['given_height'];
        //$data['weight'] = $_POST['given_weight'];
        //$data['parameters_user_agreement'] = $_POST['given_parameters_user_agreement'];
        //$data['parameters_email_marketing'] = $_POST['given_parameters_email_marketing'];
        //$data['parameters_gdpr'] = $_POST['given_parameters_gdpr'];

    }

?>

</body>
</html>