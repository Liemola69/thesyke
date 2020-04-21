<?php
session_start();


?>
<!DOCTYPE html>
<html>
<head>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<link rel="stylesheet" href="../styles/kysely.css">

<body>

<nav id="ylaNav">
        <div id="sivunNimi">PÄIVÄKYSELY </div>
        <a href="sivurunko.php" id="closeMenu" class='fas fa-times-circle' style='text-decoration:none;'></a>
        
    </nav>


    <div class=slideSivu>

<form method="post">


<div class="slidecontainer">
<div><label for="myQuality">Miten nukuit viime yönä:</label><br></div>
<div><span class="fas fa-frown" style="color: var(--liikennevaloPunainen);"></span>&ensp;
<input type="range" min="-5" max="5" value="0" step="1" class="slider" id="myQuality" name="given_Quality">&ensp;<span class="fas fa-grin" style="color: var(--liikennevaloVihrea);font-size:20px"></span></div>


<div><label for="myVitality">Minkälainen vireytesi on tänään:</label><br></div>
<div><span class="fas fa-frown" style="color: var(--liikennevaloPunainen);"></span>&ensp;
<input type="range" min="-5" max="5" value="0" step="1" class="slider" id="myVitality" name="given_Vitality">&ensp;<span class="fas fa-grin" style="color: var(--liikennevaloVihrea);font-size:20px"></span></div>


<div><label for="myFood">Miten söit eilen:</label><br></div>
  <div><span class="fas fa-frown" style="color: var(--liikennevaloPunainen);"></span>&ensp;
  <input type="range" min="-5" max="5" value="0" step="1" class="slider" id="myFood" name="given_Food"></span>&ensp;<span class="fas fa-grin" style="color: var(--liikennevaloVihrea);font-size:20px"></span></div>
    

  <div><label for="myMood">Minkälainen oli mielialasi eilen:</label><br></div>
  <div><span class="fas fa-frown" style="color: var(--liikennevaloPunainen);"></span>&ensp;
  <input type="range" min="-5" max="5" value="0" step="1" class="slider" id="myMood" name="given_Mood">&ensp;<span class="fas fa-grin" style="color: var(--liikennevaloVihrea);font-size:20px"></span></div>
    

  <div><label for="myStress">Stressitasosi eilen:</label><br></div>
  <div><span class="fas fa-frown" style="color: var(--liikennevaloPunainen);"></span>&ensp;
  <input type="range" min="-5" max="5" value="0" step="1" class="slider" id="myStress" name="given_Stress"></span>&ensp;<span class="fas fa-grin" style="color: var(--liikennevaloVihrea);font-size:20px"></span></div>
    

  <div><label for="myPain">Kuvaile kiputilojasi eilen:</label><br></div>
  <div><span class="fas fa-frown" style="color: var(--liikennevaloPunainen);"></span>&ensp;
  <input type="range" min="-5" max="5" value="0" step="1" class="slider" id="myPain" name="given_Pain"></span>&ensp;<span class="fas fa-grin" style="color: var(--liikennevaloVihrea);font-size:20px"></span></div>
  
  <div style ="text-align:start;margin-left:20px">Eilen...</div>
    <div>..nautitut kofeiiniannokset:</div>
  <div><input type="radio" id="male" name="given_Kofeiini" value="5">
  <label for="male">0-2 annosta</label>
  <input type="radio" id="female" name="given_Kofeiini" value="2">
  <label for="female">3-4 annosta</label><br>
  <input type="radio" id="other" name="given_Kofeiini" value="-2">
  <label for="other">4-5 annosta</label>
  <input type="radio" id="other" name="given_Kofeiini" value="-5">
  <label for="other">Yli viisi</label></div>
  
  <br>
  <div>..nautitut alkoholiannokset:</div>
  <div><input type="radio" id="male1" name="given_Alkoholi" value="5">
  <label for="male1">En yhtään</label>
  <input type="radio" id="female1" name="given_Alkoholi" value="3">
  <label for="female1">Yhden</label>
  <input type="radio" id="other1" name="given_Alkoholi" value="-1">
  <label for="other1">2-3</label><br>
  <input type="radio" id="other11" name="given_Alkoholi" value="-3">
  <label for="other11">4-6</label>
  <input type="radio" id="other111" name="given_Alkoholi" value="-5">
  <label for="other111">yli 6</label></div>
  <br>

  <div>..ruutuaika ennen nukkumaanmenoa:</div>
  <div><input type="radio" id="male2" name="given_Ruutu" value="5">
  <label for="male2">Alle tunnin</label>
  <input type="radio" id="female2" name="given_Ruutu" value="3">
  <label for="female2">1-2 tuntia</label>
  <input type="radio" id="other2" name="givenRuutu" value="-1">
  <label for="other2">2-3 tuntia</label>
  <input type="radio" id="other22" name="given_Ruutu" value="-3">
  <label for="other22">3-4 tuntia</label>
  <input type="radio" id="other222" name="given_Ruutu" value="-5">
  <label for="other222">Yli 4 tuntia</label></div>
<br>

  <div><label for="smoke"> ..tupakointi:</label>
  <input type="radio" id="smoke" name="given_Smoke" value="1"> Kyllä
  <input type="radio" id="smoke" name="given_Smoke" value="0"> En</div>
  
  <div><label for="medicine">..unilääkkeet:</label>
  <input type="radio" id="medicine" name="given_Medicine" value="1" style="background-color:red;"> Kyllä
  <input type="radio" id="medicine" name="given_Medicine" value="0"> En</div>
  

  <div> 
  <a><input href="sivurunko.php?value=Tallenna" type="submit" name="submitPaivaKysely" value="Tallenna" class="buttonit"></input></a>
  <input type="reset" name="resetPaivaKysely" value="Tyhjennä" id="reset" class="buttonit" ></input>
  </div>


  </div>
  </p>

</form>
</div>
<script src='https://kit.fontawesome.com/a076d05399.js'></script>
</body>
</html>
