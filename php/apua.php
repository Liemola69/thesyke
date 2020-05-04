<?php
    include_once("../config/https.php");
    include_once("../config/config.php");
    include("../php/functions.php");
?>

<!DOCTYPE html>
<html>
<head>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<link rel="stylesheet" href="../styles/styles_test.css">
<link href="https://fonts.googleapis.com/css?family=Baloo+Da+2&display=swap" rel="stylesheet">
</head>
<body>

<div class="valikkoSivuWrapper">
    <div class="valikkoSivuNavNimi">APUA</div>
    <div class="valikkoSivuNavKuvake">
        <i id="closeApua" class='fas fa-times-circle'></i>
    </div>
    <div class="valikkoSivuBody">
        <h3 class="apua">Yleistä sovelluksesta</h3>
        <p class="apua">Tämä on unisovellus, jonka analyysissä huomioidaan käyttäjän päivittäinen toiminta sekä kokemus. Sovellus tekee uneen liittyvää analyysiä täytetyn päiväkyselyn tulosten sekä Polarin aktiivisuusdatan perusteella.<br>
        Yleisesti sovelluksessa vihreä väri kuvaa uneen postiiivisesti vaikuttaneita tekijöitä ja punainen väri taas negatiivisesti vaikuttaneita tekijöitä. Naama-emojin ilmeellä indikoidaan samoja asioita.
        Polarin datan pääsee synkronoimaan menusta. Päiväkyselyn pääsee täyttämään päänäkymän hymiö-kuvakkeesta. </p>
        <br>
        <h3 class="apua">Päivänäkymä</h3>
        <p class="apua">Päivänäkymän hymiö-kuvake kertoo värillä sekä ilmeellä oman kokemuksesi edellisen yön unen laadusta. Vihreä ja naurava naama kertovat hyvästä unen laadusta, keltainen ja tyytymätön naama kertovat keskinkertaisesta unen laadusta ja punainen sekä surullinen naama kertovat huonosta unen laadusta.<br>
        Palkeissa kerrotaan Polardatan perusteella arvioitu nukuttu aika ja sen perusteella lasketut unisyklit. Uniaikaa pääsee muokkaamaan klikkaamalla palkkia. Toisessa palkissa pääsee asettamaan seuraavan päivän heräämisajan ja sovellus arvioi asettamasi uniaikatavoitteen perusteella ajan, jolloin nukkumaan kannattaa mennä.<br>
        Uneen vaikuttavat tekijät- kuvaaja kuvaa uneen hyvin tai huonosti vaikuttavien tekijöiden suhdetta prosentuaalisesti.</p>
        <br>
        <h3 class="apua">Viikkonäkymä</h3>
        <p class="apua">Viikkonäkymä kokoaa halutun viikon unenlaadut sekä uneen vaikuttavien tekijöiden kuvaajat. Näkymässä pääsee selailemaan viikkotasolla omaa nukkumista.</p>
        <br>
        <h3 class="apua">Kuukausinäkymä</h3>
        <p class="apua">Kuukausinäkymässä pääsee näkemään halutun kuukauden unenlaadut kuukausitasolla. Näkymässä pääsee näkemään pidemmän jakson tasolla omaa nukkumistaan.</p>
        <br>
        <h3 class="apua">Tulos-sivut</h3>
        <p class="apua">Jokaisella näkymällä on oma tulos-sivu, joka löytyy, kun skrollaa alapäin tai painaa turkoosista nuolesta sivun alalaidassa. Sivulla pääsee näkemään kyselyn perusteella, miten eri tekijät ovat uneen mahdollisesti vaikuttaneet.<br>
        Sovelluksessa vihreä väri kuvaa uneen postiiivisesti vaikuttaneita tekijöitä ja punainen väri taas negatiivisesti vaikuttaneita tekijöitä. Naama-emojin ilmeellä indikoidaan samoja asioita.<br>
        Jokaista kuvaketta klikatessa avautuu ruutu, joka kertoo, mistä kuvakkeesta on kyse. Sivulta pääsee myös ohjesivulle, josta voi lukea ohjeita ja vinkkejä kyseisen tekijän vaikutukista uneen.</p>
        <br>
        <h3 class="apua">Valikko</h3>
        <p class="apua">Valikko löytyy sovelluksen oikeasta yläkulmasta. Sieltä pääsee synkronoimaan Polar-datan, muuttamaan omia tietoja, tarkastelemaan raportit-sivua, kirjautumaan ulos sovelluksesta sekä poistamaan mahdollisesti tilin.</p>
        
    </div>
</div>

<script>
    document.getElementById("closeApua").addEventListener("click", function(){
    document.location = 'sivurunko.php';
    })
</script>

<script src='https://kit.fontawesome.com/a076d05399.js'></script>
<script src="../js/sivurunko.js"></script>
</body>
</html>