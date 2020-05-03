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
        <div id="sivunNimi">AKTIIVISUUS+UNI</div>
        <a href="sivurunko.php?moveToDay=<?php echo($_SESSION['currentDay']);?>" id="closeMenu" class='fas fa-times-circle' style='text-decoration:none;'></a>      
    </nav>

    <div>
        <p class="ohjeOtsikko">Yleistä</p>
        <p>Liikunta ja fyysisesti aktiivinen toiminta pidentävät unen kestoa, parantavat sen laatua ja vähentävat yöllisiä heräämisiä.</p>
        <p>Fyysinen aktiivisuus nopeuttaa nukahtamista ja pidentää syvän unen eli palauttavan vaiheen kestoa.</p>
        <p><i class='fas fa-running' style='font-size:30px'></i>
        <p>Fyysisen aktiivisuuden unta edistävien vaikutusten on ajateltu johtuvan lihasten väsymisestä, liikunnan aiheuttamista hormoni- ja kehon lämpötilamuutoksista sekä mielen rentoutumisesta.</p>
        <br>
        <p><i class='fas fa-dumbbell' style='font-size:30px'></i>

        <p class="ohjeOtsikko">Aktiivisuuden vaikutuksia uneen</p>
        <p><i class='fas fa-smile' style='font-size:20px;color:var(--liikennevaloVihrea)'></i> Liikuntamuodolla ei tiedetä olevan merkitystä. Tärkeää unen kannalta on, että liikunta on säännöllistä ja sinulle miellyttävää ja hauskaa.</p>
        <p><i class='fas fa-frown' style='font-size:20px;color:var(--liikennevaloPunainen)'></i> Raskasta liikuntaa kannattaa välttää ennen nukkumaanmenoa, jotta elimistö ei käy ylikierroksilla nukkumaan mennessä.</p>
        <p><i class='fas fa-exclamation' style='font-size:30px;color:var(--tehosteVari)'></i> Parhaiten liikunta vaikuttaa uneen silloin, kun se kestää 1–2 tuntia ja se tapahtuu vähintään kolme–neljä tuntia ennen nukkumaanmenoa, jolloin palautumiseen jää riittävästi aikaa.</p>
           
    </div>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>  
</body>
</html>