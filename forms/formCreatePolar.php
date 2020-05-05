<?php
session_start();
?>

<form method="post">
    <i class="far fa-times-circle registerClose" id="registerClose1"></i>
    <br>
    <i class="far fa-user"></i>
    <h1>POLAR-KELLON LISÄYS</h1>
    <p>TULOSSA!</p>
    <p>Polar-kirjautumisen kautta henkilötietojen haku sovellukseen. Täytä tietosi toistaiseksi manuaalisesti.</p>
    <br>
    <input class="buttonGeneric" type="submit" name="createPolarSubmit" value="Ohita">
    <br>
    <br>
</form>

<script>
        document.getElementById("registerClose1").addEventListener("click", function(){
        document.querySelector(".registerPopup").style.visibility = "hidden";
        document.location = 'php/resetVariables.php';
    })
</script>