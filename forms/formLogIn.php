<?php
session_start();
?>

<form method="post">
    <i class="far fa-times-circle loginClose" id="loginClose"></i>
    <br>
    <i class="far fa-user"></i>
    <br>
    <h1>KIRJAUTUMISTIEDOT</h1>
    <br>
    <input class="textboxGeneric"  type="text" placeholder="Sähköpostiosoite" name="givenLoginName">
    <br>
    <input class="textboxGeneric"  type="password" placeholder="Salasana" name="givenLoginPassword">
    <br>
    <br>
    <input class="buttonGeneric" type="submit" value="Kirjaudu sisään" name="logInSubmit">
    <input class="buttonGeneric" type="reset" value="Tyhjennä">
</form>

<script>
        document.getElementById("loginClose").addEventListener("click", function(){
        document.querySelector(".registerPopup").style.visibility = "hidden";
        document.location = 'php/resetVariables.php';
    })
</script>