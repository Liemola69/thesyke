<?php
    include_once("../config/https.php");
    include_once("../config/config.php");
    include("../php/functions.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/kysely.css">   
</head>
<body>

    <nav id="ylaNavDeleteAccount">
        <div id="sivunNimi">MIELIALA+UNI</div>
        <a href="sivurunko.php?moveToDay=<?php echo($_SESSION['currentDay']);?>" id="closeMenu" class='fas fa-times-circle' style='text-decoration:none;'></a>      
    </nav>

    <div>
        <p class="ohjeOtsikko">Yleistä</p>
        <!-- Lähde: https://mieli.fi/fi/mielenterveys/hyvinvointi/unen-merkitys -->
        <p>Mieli ja aivot tarvitsevat unta, joka poistaa väsymyksen, palauttaa vireyden ja havaintokyvyn sekä ylläpitää hyvää mielialaa.</p>
        <p><i class='fas fa-frown-open' style='font-size:30px'></i> <i class='fas fa-grin' style='font-size:30px'></i>
        <br>

        <p class="ohjeOtsikko">Mielialan vaikutuksia uneen</p>
        <p><i class='fas fa-frown' style='font-size:20px;color:var(--liikennevaloPunainen)'></i> Huonosti nukutun yön jälkeen, aivot eivät välttämättä jaksa pitää yllä hyvää mielialaa.</p>
        <p><i class='fas fa-smile' style='font-size:20px;color:var(--liikennevaloVihrea)'></i> Unessa aivot lajittelevat tietoa edeltävien päivien tapahtumista ja omaksutut asiat tallentuvat pitkäkestoiseen muistiin. Näin kaikkialta tulvivat virikkeet ja tieto voi jäsentyä mielekkäiksi, ymmärrettäviksi kokonaisuuksiksi.</p>
        <p><i class='fas fa-frown' style='font-size:20px;color:var(--liikennevaloPunainen)'></i> kokonaisuuksiksi. Jos unet ovat jääneet vajaiksi, eivät päivän asiat ole välttämättä ehtineet jäsentyä kokonaisuuksiksi.</p>
        <p><i class='fas fa-smile' style='font-size:20px;color:var(--liikennevaloVihrea)'></i> Unen aikana mieli käsittelee myös tunteita, jotka usein päivän askareissa jäävät vaille huomiota. Alitajunta saa unessa tilaa työskennellä.  Nukkuminen on näin myös mielikuvituksen ja luovuuden edellytys ja auttaa ihmistä sopeutumaan muuttuvissa tilanteissa.</p>
        <p><i class='fas fa-exclamation' style='font-size:30px;color:var(--tehosteVari)'></i> Jos sinulla on usein mieli maassa omasta mielestäsi, tai sovelluksessamme mielialaa kuvaava ikoni näyttää jatkuvasti punaista väriä tai alakuloista naama-kuvaketta, voisit käydä täyttämässä masennusta kartoittavan kyselyn seuraavasta linkistä
        <a href="https://www.kaypahoito.fi/pgr00029" class="fas fa-angle-double-right" style='font-size:30px;color:var(--tehosteVari);text-decoration:none;'></a> ja tarvittaessa hakea ammattilaisapua.</p>
    
    </div>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>  
</body>
</html>