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
        <div id="sivunNimi">KOFEIINI+UNI</div>
        <a href="sivurunko.php?moveToDay=<?php echo($_SESSION['currentDay']);?>" id="closeMenu" class='fas fa-times-circle' style='text-decoration:none;'></a>      
    </nav>

    <div>
        <p class="ohjeOtsikko">Yleistä</p>
        <p>Kofeiinin nauttimisen ennen nukkumaanmenoa on todettu pidentävän nukahtamisviivettä, aiheuttavan heräilyjä, vähentävän unen kokonaisaikaa ja heikentävän unen laatua. Tämä on kuitenkin hyvin yksilöllistä.</p>
        <p><i class='fas fa-coffee' style='font-size:30px'></i>
        <p>Kofeiini imeytyy nopeasti ruoansulatuskanavasta vereen. Maksimivaikutus on nähtävissä jo puolen tunnin kuluttua. Vereen imeytyneen kofeiinin määrä puolittuu 3–6 tunnissa. Jos nukut huonosti, kannattaa miettiä kofeiinituotteen nauttimisen ajankohtaa.</p>
        <br>

        <p class="ohjeOtsikko">Kofeiinin vaikutuksia uneen</p>
        <p><i class='fas fa-smile' style='font-size:20px;color:var(--liikennevaloVihrea)'></i> Kofeiini stimuloi keskushermostoa, mistä johtuu kofeiinituotteiden piristävä vaikutus.</p>
        <p><i class='fas fa-smile' style='font-size:20px;color:var(--liikennevaloVihrea)'></i> Väsyneillä ihmisillä kofeiinin on todettu lisäävän tarkkaavaisuutta.</p>
        <p><i class='fas fa-frown' style='font-size:20px;color:var(--liikennevaloPunainen)'></i> Kofeeini vaikeuttaa nukahtamista, heikentää unen laatua ja lyhentää unta monilla keskushermostoa stimuloivan vaikutuksen takia.</p>
        <p><i class='fas fa-smile' style='font-size:20px;color:var(--liikennevaloVihrea)'></i> Sopivana annoksena kofeiini parantaa kestävyysurheilun suoritusta kolmella prosentilla eli lisää myös jaksavuutta.</p>
        <p><i class='fas fa-frown' style='font-size:20px;color:var(--liikennevaloPunainen)'></i> Kofeiini aiheuttaa riippuvuutta. Riippuvuudesta puhutaan silloin, kun kofeiinin saannin lopettaminen aiheuttaa vierotusoireita, kuten <ul><li>päänsärkyä</li>
        <li>vetämättömyyttä</li><li>väsymystä</li><li>alakuloista mielialaa</li></ul></p>
        <p><i class='fas fa-frown' style='font-size:20px;color:var(--liikennevaloPunainen)'></i> Myrkytyksen oireita voi osalle käyttäjistä ilmaantua, kun kofeiinin päivittäinen saanti ylittää 400 mg.</p>
        <br>
        <p class="ohjeOtsikko">Faktatietoa kofeiinista</p>
        <p>Useilla ihmisillä runsas kofeiinin käyttö vaikuttaa unta heikentävästi. Tämä haitallinen vaikutus liittyy adenosiini-nimiseen välittäjäaineeseen, joka säätelee aivoissa uni-valverytmiä.</p>
        <p><i class='fas fa-coffee' style='font-size:30px'></i>
        <p>Valveilla olon aikana adenosiinin määrä aivoissa lisääntyy ja alkaa vähitellen vaimentamaan aivojen aktiivisuutta vireyden kannalta keskeisillä aivoalueilla.</p>
        <p><i class='fas fa-coffee' style='font-size:30px'></i>
        <p>Runsas kofeiinin käyttö salpaa adenosiinireseptoreita ja sen takia aivot pysyvät tavallista aktiivisempina eikä normaalia uneliaisuuden tunnetta illalla tule tai se viivästyy.</p>
        <br>
    </div>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>  
</body>
</html>