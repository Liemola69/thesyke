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

<div class="valikkoSivuWrapper">
    <div class="valikkoSivuNavNimi">KÄYTTÖEHDOT</div>
    <div class="valikkoSivuNavKuvake">
        <i id="closeKayttoehdot" class='fas fa-times-circle'></i>
    </div>
    <div class="valikkoSivuBody">
        <h3>Yleiset käyttöehdot</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        <h3>Henkilötietojen käsittely</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        <h3>Henkilörekisteri</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        <h3>Yhteydenotto</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        </div>
</div>

<script>
    document.getElementById("closeKayttoehdot").addEventListener("click", function(){
    document.location = 'sivurunko.php';
    })
</script>

<script src='https://kit.fontawesome.com/a076d05399.js'></script>
<script src="../js/sivurunko.js"></script>
</body>
</html>