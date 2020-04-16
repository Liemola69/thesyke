<?php
session_start();
?>

<form method="post">
    <input class="textboxGeneric" type="text" placeholder="Sähköpostiosoite" name="givenEmail">
    <br>
    <input class="textboxGeneric" type="password" placeholder="Salasana" name="givenPassword">
    <br>
    <input class="textboxGeneric" type="password" placeholder="Salasana uudestaan">
    <br>
    
    <input class="buttonGeneric" type="submit" name="createAccountSubmit" value="Luo tunnus">
    <input class="buttonGeneric" type="reset" value="Tyhjennä">
</form>