<?php
session_start();
?>

<form method="post">
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
    <p class="textGeneric">Käyttöehdot
    <input class="checkboxGeneric" type="checkbox" name="given_parameters_user_agreement">
    </p>
    <p class="textGeneric">Sähköpostimarkkinointi
    <input class="checkboxGeneric" type="checkbox" name="given_parameters_email_marketing">
    </p>
    <p class="textGeneric">GDPR
    <input class="checkboxGeneric" type="checkbox" name="given_parameters_gdpr">
    </p>
    <input class="buttonGeneric" type="submit" name="createUserDetailsSubmit" value="Tallenna">
</form>