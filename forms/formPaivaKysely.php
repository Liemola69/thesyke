<?php
session_start();

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../styles/kysely.css">

<body class="kyselyBody">

<nav id="ylaNav">
        <div id="sivunNimi">PÄIVÄKYSELY</div>
        <div id="hampurilaisMenu" class="fa fa-bars"></div>
        <div id="hampurilaisValikko">
            <ul id="ylaValikko">
                <li id="raportitValikkoLinkki">Raportit</li>
                <li>Omat tiedot</li>
                <li>Polar-linkitys</li>
                <li>Apua</li>
                <li>Käyttöehdot</li>
                <li></li>
                <li onclick='window.location.href="sivurunko.php?logOut=true"'>Kirjaudu ulos </li>
            </ul>
        </div>
    </nav>

<div class=slideSivu>


<form method="post">


<div class="slidecontainer">
<div>Miten nukuit viime yönä:<br>
 (-5 - +5)</div>
<div><input type="range" min="-2" max="4" value="0" class="slider" id="myQuality" name="given_Quality"> : <span id="demo"></span></div>


  <div>Minkälainen vireytesi on tänään: <br>
  (-5 - +5)
  </div> 
  <div><input type="range" min="-5" max="5" value="0" class="slider" id="myVitality" name="given_Vitality">  Arvo: <span id="demo1"></span></div>


  <div>Miten söit eilen: <br>
  (-5 - +5)
  </div>
  <div><input type="range" min="-5" max="5" value="0" class="slider" id="myFood" name="given_Food">  Arvo: <span id="demo2"></span></div>
    

  <div>Minkälainen oli mielialasi eilen: <br>
  (-5 - +5)
  </div>
  <div><input type="range" min="-5" max="5" value="0" class="slider" id="myMood" name="given_Mood">  Arvo: <span id="demo3"></span></div>
    

  <div>Stressitasosi eilen: <br>
  (-5 - +5)
  </div>
  <div><input type="range" min="-5" max="5" value="0" class="slider" id="myStress" name="given_Stress">  Arvo: <span id="demo4"></span></div>
    

  <div>Kuvaile kiputilojasi eilen: <br>
  (-5 - +5)
  </div>
  <div><input type="range" min="-5" max="5" value="0" class="slider" id="myPain" name="given_Pain">  Arvo: <span id="demo5"></span></div>
  

  <div>Eilen nautitut kofeiini:</div>
  <div><input type="radio" id="male" name="given_Kofeiini" value="5">
  <label for="male">0-2 annosta</label>
  <input type="radio" id="female" name="given_Kofeiini" value="2">
  <label for="female">3-4 annosta</label><br>
  <input type="radio" id="other" name="given_Kofeiini" value="-2">
  <label for="other">4-5 annosta</label>
  <input type="radio" id="other" name="given_Kofeiini" value="-5">
  <label for="other">Yli viisi</label></div>
  

  <div>Eilen nautitut alkoholiannokset:</div>
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

  <div>Ruutuaika ennen nukkumaanmenoa:</div>
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

  <div><label for="smoke"> Tupakka eilen?</label>
  <input type="radio" id="smoke" name="given_Smoke" value="1"> Kyllä
  <input type="radio" id="smoke" name="given_Smoke" value="0"> En</div>
  
  <div><label for="medicine">Unilääkkeitä eilen?</label>
  <input type="radio" id="medicine" name="given_Medicine" value="1"> Kyllä
  <input type="radio" id="medicine" name="given_Medicine" value="0"> En</div>
  

  <div><input type="submit" name="submitPaivaKysely" value="Tallenna"></input>
  <input type="submit" name="destroyPaivaKysely" value="Tuhoa"></input></div>


  </div>
  </p>

</form>

</div>


<script>
var slider = document.getElementById("myQuality");
var output = document.getElementById("demo");
output.innerHTML = slider.value;

slider.oninput = function() {
  output.innerHTML = this.value;
}

var slider1 = document.getElementById("myVitality");
var output1 = document.getElementById("demo1");
output1.innerHTML = slider1.value;

slider1.oninput = function() {
  output1.innerHTML = this.value;
}

var slider2 = document.getElementById("myFood");
var output2 = document.getElementById("demo2");
output2.innerHTML = slider2.value;

slider2.oninput = function() {
  output2.innerHTML = this.value;
}

var slider3 = document.getElementById("myMood");
var output3 = document.getElementById("demo3");
output3.innerHTML = slider3.value;

slider3.oninput = function() {
  output3.innerHTML = this.value;
}

var slider4 = document.getElementById("myStress");
var output4 = document.getElementById("demo4");
output4.innerHTML = slider4.value;

slider4.oninput = function() {
  output4.innerHTML = this.value;
}

var slider5 = document.getElementById("myPain");
var output5 = document.getElementById("demo5");
output5.innerHTML = slider5.value;

slider5.oninput = function() {
  output5.innerHTML = this.value;
}


</script>
</body>
</html>
