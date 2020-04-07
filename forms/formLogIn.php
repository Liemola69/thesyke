<?php
session_start();
?>

<form method="post">
    <input class="textboxGeneric"  type="text" placeholder="Sähköpostiosoite" name="givenLoginName">
    <br>
    <input class="textboxGeneric"  type="password" placeholder="Salasana" name="givenLoginPassword">
    <br>
    <input class="buttonGeneric" type="submit" value="Kirjaudu sisään" name="logInSubmit">
    <input class="buttonGeneric" type="reset" value="Tyhjennä">
</form>