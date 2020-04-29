<?php
session_start();
?>

<form method="post">
    <i class="far fa-times-circle registerClose" id="registerClose2"></i>
    <br>
    <i class="far fa-user"></i>
    <h1>HENKILÖTIEDOT</h1>
    <input class="textboxGeneric" type="text" placeholder="Etunimi" name="given_first_name">
    <br>
    <input class="textboxGeneric" type="text" placeholder="Sukunimi" name="given_last_name">
    <br>
    <input class="textboxGeneric" type="text" placeholder="Ikä" name="given_age">
    <br>
    <input class="textboxGeneric" type="text" placeholder="Sukupuoli" name="given_gender">
    <br>
    <input class="textboxGeneric" type="text" placeholder="Pituus" name="given_height">
    <br>
    <input class="textboxGeneric" type="text" placeholder="Paino" name="given_weight">
    <br>
    <p class="textGeneric">Hyväksyn käyttöehdot
    <input class="checkboxGeneric" type="checkbox" name="given_parameters_user_agreement">
    </p>
    <p class="textGeneric">Hyväksyn henkilötietojen käsittelyn
    <input class="checkboxGeneric" type="checkbox" name="given_parameters_gdpr">
    </p>
    <p class="textGeneric">Sallin sähköpostimainonnan
    <input class="checkboxGeneric" type="checkbox" name="given_parameters_email_marketing">
    </p>
    <input class="buttonGeneric" type="submit" name="createUserDetailsSubmit" value="Tallenna ja jatka">
    <br>
    <br>
</form>

<script>
        document.getElementById("registerClose2").addEventListener("click", function(){
        document.querySelector(".registerPopup").style.visibility = "hidden";
        document.location = 'php/resetVariables.php';
    })
</script>