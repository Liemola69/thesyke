<?php
session_start();
?>

<form method="post">
    <i class="far fa-times-circle registerClose" id="registerClose3"></i>
    <br>
    <i class="far fa-user"></i>
    <h1>VALITSE KÄYTTÄMÄSI AINEET</h1>
    <div class="checkboxDiv">
    <p class="textGeneric">KOFEIINI
    <input class="checkboxGeneric" type="checkbox" name="given_parameters_stimulants"></p>
    </div>
    <div class="checkboxDiv">
    <p class="textGeneric">UNI-/NUKAHTAMISLÄÄKKEET
    <input class="checkboxGeneric" type="checkbox" name="given_parameters_medicine"></p>
    </div>
    <div class="checkboxDiv">
    <p class="textGeneric">ALKOHOLI
    <input class="checkboxGeneric" type="checkbox" name="given_parameters_alcohol"></p>
    </div>
    <div class="checkboxDiv">
    <p class="textGeneric">TUPAKKA
    <input class="checkboxGeneric" type="checkbox" name="given_parameters_smoke"></p>
    </div>
    <div class="checkboxDiv">
    <p class="textGeneric">HUUMEET
    <input class="checkboxGeneric" type="checkbox" name="given_parameters_drug"></p>
    </div>
    <input class="buttonGeneric" type="submit" name="createUserParametersSubmit" value="Luo tili">
    <br>
    <br>
</form>

<script>
        document.getElementById("registerClose3").addEventListener("click", function(){
        document.querySelector(".registerPopup").style.visibility = "hidden";
        document.location = 'php/resetVariables.php';
    })
</script>