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
    include_once("../config/https.php");
    include_once("../config/config.php");
    
    echo("Login sivu");
    include("../forms/formLogIn.php");

    /** TO-DO
     * Tsekkaa isot/pienet kirjaimet */

    if(isset($_POST['logInSubmit'])){

        $data['userName'] = $_POST['givenName'];

        // Tarkista onko tunnuksia tietokannassa käyttäjätunnuksen perusteella
        $sql = "SELECT * FROM `ts_user` WHERE `email` = :userName;";

        $kysely = $DBH->prepare($sql);
        $kysely -> execute($data);
        $kysely -> setFetchMode(PDO::FETCH_OBJ);
        $vastaus = $kysely -> fetch();

        // Jos löytyi ja tunnus täsmää, sekä isot/pienet kirjaimet täsmää
        if($vastaus != NULL && ($data['userName'] == $vastaus->email)){
            
            // Pura salasanan suojaus
            if(password_verify($_POST['givenPassword'], $vastaus->password)){
                $_SESSION['loggedIn'] = true;
                header("Location: sivurunko.php");
            } else{
                echo("Väärä salasana!");
            }
        } else{
            echo("Väärä tunnus! Varmista isot ja pienet kirjaimet");
        }
    }
?>