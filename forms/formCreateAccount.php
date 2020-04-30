<?php
session_start();
?>

<form method="post">
    <i class="far fa-times-circle registerClose" id="registerClose"></i>
    <br>
    <i class="far fa-user"></i>
    <h1>TILIN TIEDOT</h1>
    <input class="textboxGeneric" type="text" placeholder="Sähköpostiosoite" name="givenEmail">
    <br>
    <input class="textboxGeneric" type="password" placeholder="Salasana" name="givenPassword">
    <br>
    <input class="textboxGeneric" type="password" placeholder="Salasana uudestaan" name="givenVerifiedPassword">
    <br>
    <input class="buttonGeneric" type="submit" name="createAccountSubmit" value="Tallenna ja jatka">
    <input class="buttonGeneric" type="reset" value="Tyhjennä">
    <br>
    <br>
</form>

<script>
        document.getElementById("registerClose").addEventListener("click", function(){
        document.querySelector(".registerPopup").style.visibility = "hidden";
        document.location = 'php/resetVariables.php';
    })
</script>