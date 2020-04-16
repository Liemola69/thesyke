<?php
session_start();

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../styles/styles_test.css">

<body>

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

<form method="get">

<br>
<p>

<div class="slidecontainer">
<div>Miten nukuit viime yönä:</div> 
 
<div><input type="range" min="-2" max="4" value="0" class="slider" id="myQuality" name="given_Quality">  Arvo: <span id="demo"></span></div>


  <div>Minkälainen vireytesi on tänään: </div> 
  <div><input type="range" min="-5" max="5" value="0" class="slider" id="myVitality" name="given_Vitality">  Arvo: <span id="demo1"></span></div>


  <div>Miten söit eilen: </div>
  <div><input type="range" min="-5" max="5" value="0" class="slider" id="myFood" name="given_Food">  Arvo: <span id="demo2"></span></div>
    

  <div>Minkälainen oli mielialasi eilen: </div>
  <div><input type="range" min="-5" max="5" value="0" class="slider" id="myMood" name="given_Mood">  Arvo: <span id="demo3"></span></div>
    

  <div>Stressitasosi eilen: </div>
  <div><input type="range" min="-5" max="5" value="0" class="slider" id="myStress" name="given_Stress">  Arvo: <span id="demo4"></span></div>
    

  <div>Kuvaile kiputilojasi eilen: </div>
  <div><input type="range" min="-5" max="5" value="0" class="slider" id="myPain" name="given_Pain">  Arvo: <span id="demo5"></span></div>
  
  
<br>
  

  </div>



  <div>Kerrohhan, kuinka monta kofeiiniannosta nautit eilen(info alkoholiannoksista):<br>
  <input type="radio" id="male" name="kofeiini" value="5">
  <label for="male">0-2 annosta</label>
  <input type="radio" id="female" name="kofeiini" value="2">
  <label for="female">3-4 annosta</label>
  <input type="radio" id="other" name="kofeiini" value="-2">
  <label for="other">4-5 annosta</label>
  <input type="radio" id="other" name="kofeiini" value="-5">
  <label for="other">Yli viisi</label>
  </div>

  <div>Kerrohhan, kuinka monta alkoholiannosta nautit eilen(info alkoholiannoksista):<br>
  <input type="radio" id="male1" name="alkoholi" value="5">
  <label for="male1">En yhtään</label>
  <input type="radio" id="female1" name="alkoholi" value="3">
  <label for="female1">Yhden</label>
  <input type="radio" id="other1" name="alkoholi" value="-1">
  <label for="other1">2-3</label>
  <input type="radio" id="other11" name="alkoholi" value="-3">
  <label for="other11">4-6</label>
  <input type="radio" id="other111" name="alkoholi" value="-5">
  <label for="other111">yli 6</label></div>

  <div>Kerrohhan, kuinka monta tuntia vietit ennen nukkumaanmenoa ruudun edessä eilen(info ruuduista):<br>
  <input type="radio" id="male2" name="kofeiini" value="5">
  <label for="male2">Alle tunnin</label>
  <input type="radio" id="female2" name="kofeiini" value="3">
  <label for="female2">1-2 tuntia</label>
  <input type="radio" id="other2" name="kofeiini" value="-1">
  <label for="other2">2-3 tuntia</label>
  <input type="radio" id="other22" name="kofeiini" value="-3">
  <label for="other22">3-4 tuntia</label>
  <input type="radio" id="other222" name="kofeiini" value="-5">
  <label for="other222">Yli 4 tuntia</label></div>
<br>

  <input type="submit" name="submitPaivaKysely" value="Tallenna"></input>
  <input type="submit" name="destroyPaivaKysely" value="Tuhoa"></input>


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
