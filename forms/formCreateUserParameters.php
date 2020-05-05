<?php
session_start();
?>

<form method="post">
    <i class="far fa-times-circle registerClose" id="registerClose3"></i>
    <br>
    <i class="far fa-user"></i>
    <br>
    <h1>VALITSE KÄYTTÄMÄSI AINEET</h1>
    <br>
    <div class="checkboxDiv">
    <p class="textGeneric">KOFEIINI</p>
    <input class="checkboxGeneric" type="checkbox" name="given_parameters_stimulants">
    </div>
    <div class="checkboxDiv">
    <p class="textGeneric">UNILÄÄKKEET</p>
    <input class="checkboxGeneric" type="checkbox" name="given_parameters_medicine">
    </div>
    <div class="checkboxDiv">
    <p class="textGeneric">ALKOHOLI</p>
    <input class="checkboxGeneric" type="checkbox" name="given_parameters_alcohol">
    </div>
    <div class="checkboxDiv">
    <p class="textGeneric">TUPAKKA</p>
    <input class="checkboxGeneric" type="checkbox" name="given_parameters_smoke">
    </div>
    <div class="checkboxDiv">
    <p class="textGeneric">HUUMEET</p>
    <input class="checkboxGeneric" type="checkbox" name="given_parameters_drug">
    </div>
    <br>
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