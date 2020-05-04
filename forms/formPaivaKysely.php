<form method="post">


<div class="slidecontainer">

<div style ="text-align:end" class = "popupInfo" onclick="myInfoFunction()"><i id="questonmark" class='fas fa-question-circle'></i>
  <span class="popupInfotext" id="myInfoPopup">Tietoja päiväkyselystä:
  <ul style="list-style-type:disc;">
  <li>Kartoittaa unitottumuksia</li><br>
  <li>Tarkoitettu täytettäväksi päivittäin</li><br>
  <li>Sovellusta voi käyttää, vaikka kyselyä ei täyttäisi joka päivä</li><br>
  <li>Vastausten perusteella sovellus tekee analyysiä ja antaa ohjeita</li><br>
  <li>Minkä tahansa kohdan kyselystä voi jättää tyhjäksi</li><br>
  <li>Tyhjiksi jätettyjä kohtia ei otetan mukaan analyysiin</li><br>
  </ul></span></div>

<div><label for="myQuality">Miten nukuit viime yönä:</label><br></div>
<div><span class="fas fa-frown" style="color: var(--liikennevaloPunainen);"></span>&ensp;
<input type="range" min="-5" max="5" value = "<?php echo($paivaOlio->user_sleep_quality); ?>" step="1" class="slider" id="myQuality" name="given_Quality">&ensp;<span class="fas fa-grin" style="color: var(--liikennevaloVihrea);font-size:1.1em" ></span></div>


<div><label for="myVitality">Minkälainen vireytesi on tänään:</label><br></div>
<div><span class="fas fa-frown" style="color: var(--liikennevaloPunainen);"></span>&ensp;
<input type="range" min="-5" max="5" value="<?php echo($paivaOlio->user_vitality); ?>" step="1" class="slider" id="myVitality" name="given_Vitality">&ensp;<span class="fas fa-grin" style="color: var(--liikennevaloVihrea);font-size:1.1em" ></span></div>


<div><label for="myFood">Miten söit eilen:</label><br></div>
  <div><span class="fas fa-frown" style="color: var(--liikennevaloPunainen);"></span>&ensp;
  <input type="range" min="-5" max="5" value="<?php echo($paivaOlio->user_food); ?>" step="1" class="slider" id="myFood" name="given_Food"></span>&ensp;<span class="fas fa-grin" style="color: var(--liikennevaloVihrea);font-size:1.1em" ></span></div>
    

  <div><label for="myMood">Minkälainen mielialasi on tänään:</label><br></div>
  <div><span class="fas fa-frown" style="color: var(--liikennevaloPunainen);"></span>&ensp;
  <input type="range" min="-5" max="5" value="<?php echo($paivaOlio->user_mood); ?>" step="1" class="slider" id="myMood" name="given_Mood">&ensp;<span class="fas fa-grin" style="color: var(--liikennevaloVihrea);font-size:1.1em" ></span></div>
    

  <div><label for="myStress">Stressitasosi eilen:</label><br></div>
  <div><span class="fas fa-frown" style="color: var(--liikennevaloPunainen);"></span>&ensp;
  <input type="range" min="-5" max="5" value="<?php echo($paivaOlio->user_stress); ?>" step="1" class="slider" id="myStress" name="given_Stress"></span>&ensp;<span class="fas fa-grin" style="color: var(--liikennevaloVihrea);font-size:1.1em" ></span></div>
    

  <div><label for="myPain">Kuvaile kiputilojasi eilen:</label><br></div>
  <div><span class="fas fa-frown" style="color: var(--liikennevaloPunainen);"></span>&ensp;
  <input type="range" min="-5" max="5" value="<?php echo($paivaOlio->user_pain); ?>" step="1" class="slider" id="myPain" name="given_Pain"></span>&ensp;<span class="fas fa-grin" style="color: var(--liikennevaloVihrea);font-size:1.1em" ></span></div>
  
  <div style ="text-align:start;margin-left:10px">Eilen...</div>

  <div class = "popup" onclick="myKofeinFunction()">..nautittu kofeiinimäärä:&ensp;<i id="kysymys1" class='fas fa-question-circle'></i> 
  <span class="popuptext" id="myKofeiiniPopup">Kofeiinia sisältäviä tuotteita:
  <ul style="list-style-type:disc;">
  <li>Muki (2 dl) kahvia&nbsp; 125 mg</li><br>
  <li>Muki (2 dl) teetä&nbsp; 34 mg</li><br>
  <li>Pullo (0,5l) kolajuomaa&nbsp; 55 mg</li><br>
  <li>Tölkki (0,33l) energiajuomaa&nbsp; 106 mg</li><br>
  <li>Energiapatukka (45 g)&nbsp; 115 mg</li><br>
  <li>Kofeiinitabletti (1 kpl)&nbsp; 100 mg</li><br>
  <li>Tumma suklaa (100 g)&nbsp; 55 mg</li><br>
  <li>Maitosuklaa (100 g)&nbsp; 17 mg</li>
  </ul></span></div>

  <label for="kofeiini51" class="container" >En halua vastata
  <input type="radio" id="kofeiini51" checked="checked" name="given_Kofeiini" value="0">
  <span class="checkmark"></span>
</label>
  <label for="kofeiini5" class="container" >0-200 mg
  <input type="radio" id="kofeiini5" name="given_Kofeiini" value="5">
  <span class="checkmark"></span>
</label>
<label for="kofeiini2" class="container">200-300 mg
  <input type="radio" id="kofeiini2" name="given_Kofeiini" value="2">
  <span class="checkmark"></span>
</label>
<label for="kofeiini-2" class="container">300-400 mg
  <input type="radio" id="kofeiini-2" name="given_Kofeiini" value="-2">
  <span class="checkmark"></span>
</label>
<label for="kofeiini-5" class="container">Yli 400 mg
  <input type="radio" id="kofeiini-5" name="given_Kofeiini" value="-5">
  <span class="checkmark"></span>
</label>

  
  <br> 
  <div class = "popup" onclick="myAlcoholFunction()">..nautitut alkoholiannokset:&ensp;<i id="kysymys1" class='fas fa-question-circle'></i> 
  <span class="popuptext" id="myAlkoholiPopup">Yksi alkoholiannos tarkoittaa 12 grammaa 100 prosenttista alkoholia, eli esimerkiksi:
  <ul style="list-style-type:disc;">
  <li>pullollinen (0,33 l) keskiolutta tai siideriä</li><br>
  <li>ravintola-annos (12 cl) viiniä</li><br>
  <li>ravintola-annos (4 cl) väkevää alkoholia</li>
  </ul></span></div>

  <label for="alkoholi51" class="container">En halua vastata
  <input type="radio" id="alkoholi51" checked="checked" name="given_Alkoholi" value="0">
  <span class="checkmark"></span>
</label>  
<label for="alkoholi5" class="container">En yhtään
  <input type="radio" id="alkoholi5" name="given_Alkoholi" value="5">
  <span class="checkmark"></span>
</label>
<label for="alkoholi3" class="container">Yhden annoksen
  <input type="radio" id="alkoholi3" name="given_Alkoholi" value="3">
  <span class="checkmark"></span>
</label>
<label for="alkoholi-1" class="container">2-3 annosta
  <input type="radio" id="alkoholi-1" name="given_Alkoholi" value="-1">
  <span class="checkmark"></span>
</label>
<label for="alkoholi-3" class="container">4-6 annosta
  <input type="radio" id="alkoholi-3" name="given_Alkoholi" value="-3">
  <span class="checkmark"></span>
</label>
<label for="alkoholi-5" class="container">Yli kuusi annosta
  <input type="radio" id="alkoholi-5" name="given_Alkoholi" value="-5">
  <span class="checkmark"></span>
</label>

 <br>

  <div class = "popup" onclick="myScreenTimeFunction()">..ruutuaika ennen nukkumaan menoa:&ensp;<i id="kysymys1" class='fas fa-question-circle'></i> 
  <span class="popuptext" id="myScreenTimePopup">Ilmoita kyselyssä, kuinka monta tuntia 
  <ul style="list-style-type:disc;">
  <li>katsoit televisiota</li><br>
  <li>olit tietokoneella tai tabletilla</li><br>
  <li>selasit älypuhelinta</li><br>
  </ul>viiden tunnin aikana ennen nukkumaanmenoa</span></div>

<label for="ruutu51" class="container">En halua vastata
  <input type="radio" id="ruutu51" checked="checked" name="given_Ruutu" value="0">
  <span class="checkmark"></span>
</label>
<label for="ruutu5" class="container">Alle tunnin
  <input type="radio" id="ruutu5" name="given_Ruutu" value="5">
  <span class="checkmark"></span>
</label>
<label for="ruutu3" class="container">1-2 tuntia
  <input type="radio" id="ruutu3" name="given_Ruutu" value="3">
  <span class="checkmark"></span>
</label>
<label for="ruutu-1" class="container">2-3 tuntia
  <input type="radio" id="ruutu-1" name="given_Ruutu" value="-1">
  <span class="checkmark"></span>
</label>
<label for="ruutu-3" class="container">3-4 tuntia
  <input type="radio" id="ruutu-3" name="given_Ruutu" value="-3">
  <span class="checkmark"></span>
</label>
<label for="ruutu-5" class="container">Yli 4 tuntia
  <input type="radio" id="ruutu-5" name="given_Ruutu" value="-5">
  <span class="checkmark"></span>
</label>

<br>
<div>..tupakoitko eilen:</div>
<label for="smokeYes" class="container">Kyllä
  <input type="radio" id="smokeYes" name="given_Smoke" value="1">
  <span class="checkmark"></span>
</label>
<label for="smokeNo" class="container">En
  <input type="radio" id="smokeNo" name="given_Smoke" value="2">
  <span class="checkmark"></span>
</label>
<label for="smokeMaybe" class="container">En muista
  <input type="radio" id="smokeMaybe" checked="checked" name="given_Smoke" value="0">
  <span class="checkmark"></span>
</label>

<br>
<div>..unilääkkeet eilen:</div>
<label for="medicineYes" class="container">Kyllä
  <input type="radio" id="medicineYes" name="given_Medicine" value="1">
  <span class="checkmark"></span>
</label>
<label for="medicineNo" class="container">En 
  <input type="radio" id="medicineNo" checked="checked" name="given_Medicine" value="0">
  <span class="checkmark"></span>
</label>

    
<br>
  
  <input type="submit" name="submitPaivaKysely" value="Tallenna" class="buttonit"></input>
  <input type="reset" name="resetPaivaKysely" value="Tyhjennä" id="reset" class="buttonit" ></input>
 


  </div> 

</form>



