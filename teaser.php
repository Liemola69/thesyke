<?php
session_start();
include_once("config/https.php");
include_once("config/config.php");
//Session debuggaus, kommentoi pois tarvittaessa
//echo session_id();
//print_r($_POST);
print_r($_SESSION);
print_r($data);

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
    
<div class="teaserDiv">

    <div class="teaserGridItem">
    <?php
    ?> 
        </div>

    <div class="teaserGridItem">
        <img class="teaserSmallImage" src="images/sleep-zzz.png" alt="ZZZ">
    </div>
    
    <div class="teaserGridItem">
        <img class="teaserImage" src="images/unicorn.png" alt="UNICORN!">
    </div>
    
    <div class="teaserGridItemButton">
        <a href="#" class="buttonDiv" id="loginButton">KIRJAUDU SISÄÄN</a>
    </div>
    
    <div class="teaserGridItemButton">
        <a href="#" class="buttonDiv" id="registerButton">REKISTERÖIDY</a>
    </div>

    <div class="teaserGridItem"> 
    </div>

</div>

<div class="loginPopup popupBackground">
    <div class="loginPopupContent popupContent">
        <?php
            include("php/logIn.php");
        ?>
    </div>
</div>

<div class="registerPopup popupBackground">
    <div class="registerPopupContent popupContent">
        <?php
            include("php/createAccount.php");
        ?>
    </div>
</div>

<div class="createPolarPopup popupBackground">
    <div class="createPolarPopupContent popupContent">
        <?php
            include("php/createPolar.php");
        ?>
    </div>
</div>

<div class="createUserDetailsPopup popupBackground">
    <div class="createUserDetailsPopupContent popupContent">
        <?php
            include("php/createUserDetails.php");
        ?>
    </div>
</div>

<div class="createUserParametersPopup popupBackground">
    <div class="createUserParametersPopupContent popupContent">
        <?php
            include("php/createUserParameters.php");
        ?>
    </div>
</div>

<script>

    document.querySelector(".loginPopupContent").classList.toggle("loginPopupContentAnimation", false);
    document.querySelector(".registerPopupContent").classList.toggle("registerPopupContentAnimation", false);

    document.getElementById("loginButton").addEventListener("click", function(){
        document.querySelector(".loginPopup").style.visibility = "visible";
        //document.querySelector(".loginPopupContent").classList.toggle("loginPopupContentAnimation", true);
        
    })

    document.getElementById("loginClose").addEventListener("click", function(){
        //document.querySelector(".loginPopupContent").classList.toggle("loginPopupContentAnimation", false);
        document.querySelector(".loginPopup").style.visibility = "hidden";
        document.location = 'php/resetVariables.php';

    })

    document.getElementById("registerButton").addEventListener("click", function(){
        document.querySelector(".registerPopup").style.visibility = "visible";
        //document.querySelector(".registerPopupContent").classList.toggle("registerPopupContentAnimation", true);
    })

    //document.getElementById("registerClose").addEventListener("click", function(){
        //document.querySelector(".registerPopupContent").classList.toggle("registerPopupContentAnimation", false);
        //document.querySelector(".registerPopup").style.visibility = "hidden";
        //document.location = 'php/resetVariables.php';
    //})


</script>

<script src='https://kit.fontawesome.com/a076d05399.js'></script>

</body>
</html>