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
    
    <?php
        include_once("config/https.php");
        include_once("config/config.php");
        include("forms/formLogIn.php");

        if(isset($_POST['logInSubmit'])){
    ?>
    
    <script>
        document.querySelector(".loginPopup").style.visibility = "visible";
    </script>
        
    <?php

            $data['userName'] = $_POST['givenLoginName'];

            // Tarkista onko tunnuksia tietokannassa käyttäjätunnuksen perusteella
            $sql = "SELECT * FROM `ts_user` WHERE `email` = :userName;";

            $kysely = $DBH->prepare($sql);
            $kysely -> execute($data);
            $kysely -> setFetchMode(PDO::FETCH_OBJ);
            $vastaus = $kysely -> fetch();

            // Jos löytyi ja tunnus täsmää, sekä isot/pienet kirjaimet täsmää
            if($vastaus != NULL && ($data['userName'] == $vastaus->email)){
                        
                // Pura salasanan suojaus
                if(password_verify($_POST['givenLoginPassword'], $vastaus->password)){
                    $_SESSION['loggedIn'] = true;
                    $_SESSION['user_ID'] = $vastaus->user_ID;
                    header("Location: php/sivurunko.php");
                } else{
                    echo("Väärä salasana!");
    ?>
    
    <script>
        //document.querySelector(".loginPopupContent").classList.toggle("loginPopupContentAnimation", false);
        //document.querySelector(".loginPopupContent").classList.toggle("loginPopupContentAnimation2", true);              
    </script>
    
    <?php
                }
            } else{
                echo("Väärä tunnus!");
                echo"<br />";
                echo("Varmista kirjoitusasu.");
    ?>
        <script>
            //document.querySelector(".loginPopupContent").classList.toggle("loginPopupContentAnimation", false);
            //document.querySelector(".loginPopupContent").classList.toggle("loginPopupContentAnimation2", true); 
        </script>
    <?php
            }
        }
    ?>
</body>