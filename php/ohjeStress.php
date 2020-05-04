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
        <div id="sivunNimi">STRESSI+UNI</div>
        <a href="sivurunko.php?moveToDay=<?php echo($_SESSION['currentDay']);?>" id="closeMenu" class='fas fa-times-circle' style='text-decoration:none;'></a>      
    </nav>

    <div>
        <p class="ohjeOtsikko">Yleistä</p>
        <p>Stressi vaikuttaa haitallisesti unen laatuun lisäämällä stressihormonien kasvua ja sitä kautta nostaa vireystasoa.</p>
        <p><i class='fas fa-head-side-virus' style='font-size:30px'></i>
        <p>Pitkään jatkunut stressitila on tavallisimpia unettomuuden aiheuttajia ja se vaikeuttaa terveiden elintapojen ylläpitämistä.</p>
        <p>Pitkään jatkuvat korkeat stressihormonipitoisuudet heikentävät autonomisen hermoston toimintaa, jolloin palautuminen ja unen laatu heikkenevät.</p>
   
        <p><i class='fas fa-frown' style='font-size:20px;color:var(--liikennevaloPunainen)'></i> Jos sovelluksen stressiä kuvaava kuvake on jatkuvasti punaisella, kannattaa omia elämäntapoja miettiä.</p>
        <p><i class='fas fa-smile' style='font-size:20px;color:var(--liikennevaloVihrea)'></i> Hetkellisesti stressi voi auttaa ihmistä puskemaan jakson läpi.</p>
        
        <p><i class='fas fa-frown' style='font-size:20px;color:var(--liikennevaloPunainen)'></i> Pitkäaikaisena stressi voi tehdä tuhoja kantajalleen.</p>
        
        <p><i class='fas fa-exclamation' style='font-size:20px;color:var(--tehosteVari)'></i> Seuraavasta linkistä voi olla apua stressin hallintaan 
        <a href="https://www.terveyskyla.fi/naistalo/lis%C3%A4%C3%A4ntymisterveys/elintavoista-apua-hedelm%C3%A4llisyyteen/uni/stressin-vaikutus-unettomuuteen" class="fas fa-angle-double-right" style='font-size:30px;color:var(--tehosteVari);text-decoration:none;'></a></p>
    
    </div>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>  
</body>
</html>