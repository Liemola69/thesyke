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
  <div><input type="radio" id="kofeiini5" name="given_Kofeiini" value="5">
  <label for="kofeiini5">0-2 annosta</label>
  <input type="radio" id="kofeiini2" name="given_Kofeiini" value="2">
  <label for="kofeiini2">3-4 annosta</label><br>
  <input type="radio" id="kofeiini-2" name="given_Kofeiini" value="-2">
  <label for="kofeiini-2">4-5 annosta</label>
  <input type="radio" id="kofeiini-5" name="given_Kofeiini" value="-5">
  <label for="kofeiini-5">Yli viisi</label></div>
  
  <br>
  <div>..nautitut alkoholiannokset:</div>
  <div><input type="radio" id="alkoholi5" name="given_Alkoholi" value="5">
  <label for="alkoholi5">En yhtään</label>
  <input type="radio" id="alkoholi3" name="given_Alkoholi" value="3">
  <label for="alkoholi3">Yhden</label>
  <input type="radio" id="alkoholi-1" name="given_Alkoholi" value="-1">
  <label for="alkoholi-1">2-3</label><br>
  <input type="radio" id="alkoholi-3" name="given_Alkoholi" value="-3">
  <label for="alkoholi-3">4-6</label>
  <input type="radio" id="alkoholi-5" name="given_Alkoholi" value="-5">
  <label for="alkoholi-5">yli 6</label></div>
  <br>

  <div>..ruutuaika ennen nukkumaanmenoa:</div>
  <div><input type="radio" id="ruutu5" name="given_Ruutu" value="5">
  <label for="ruutu5">Alle tunnin</label>
  <input type="radio" id="ruutu3" name="given_Ruutu" value="3">
  <label for="ruutu3">1-2 tuntia</label>
  <input type="radio" id="ruutu-1" name="given_Ruutu" value="-1">
  <label for="ruutu-1">2-3 tuntia</label>
  <input type="radio" id="ruutu-3" name="given_Ruutu" value="-3">
  <label for="ruutu-3">3-4 tuntia</label>
  <input type="radio" id="ruutu-5" name="given_Ruutu" value="-5">
  <label for="ruutu-5">Yli 4 tuntia</label></div>
<br>

<div>..tupakointi eilen:
<input type="radio" id="smokeYes" name="given_Smoke" value="1"> Kyllä 
<label for="smokeYes"></label>
<input type="radio" id="smokeNo" name="given_Smoke" value="2"> Ei
<label for="smokeNo"></label></div>
  
  <div>
  <label for="medicine">..unilääkkeet:</label>
  <input type="radio" id="medicineYes" name="given_Medicine" value="1" style="background-color:red;"> Kyllä
  <input type="radio" id="medicineNo" name="given_Medicine" value="0"> En</div>
  

  
  <input type="submit" name="submitPaivaKysely" value="Tallenna" class="buttonit"></input>
  <input type="reset" name="resetPaivaKysely" value="Tyhjennä" id="reset" class="buttonit" ></input>
 


  </div> 

</form>

