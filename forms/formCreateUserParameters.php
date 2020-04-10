<?php
session_start();
?>

<form method="post">
    <p class="textGeneric">Piristeet
    <input class="checkboxGeneric" type="checkbox" name="given_parameters_stimulants"></p>
    <p class="textGeneric">Alkoholi
    <input class="checkboxGeneric" type="checkbox" name="given_parameters_alcohol"></p>
    <p class="textGeneric">Lääkkeet
    <input class="checkboxGeneric" type="checkbox" name="given_parameters_medicine"></p>
    <p class="textGeneric">Huumeet
    <input class="checkboxGeneric" type="checkbox" name="given_parameters_drug"></p>
    <p class="textGeneric">Tupakka
    <input class="checkboxGeneric" type="checkbox" name="given_parameters_smoke"></p>
    <input class="buttonGeneric" type="submit" name="createUserParametersSubmit" value="Tallenna">
</form>