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
        <div id="sivunNimi">UNEN MÄÄRÄ</div>
        <a href="sivurunko.php?moveToDay=<?php echo($_SESSION['currentDay']);?>" id="closeMenu" class='fas fa-times-circle' style='text-decoration:none;'></a>      
    </nav>
    <!-- Lähde: https://mieli.fi/fi/kehitt%C3%A4mistoiminta/lapset-ja-nuoret/unitehdas/unitehdas-unen-abczzz/kuinka-paljon-unta-tarpeeksi -->
    <div>
        <p class="ohjeOtsikko">Yleistä</p>
        <p>Ihmisen unentarve on hyvin yksilöllinen.</p>
        <p>Aikuisen ihmisen unentarpeen katsotaan olevan 6-9 tuntia yössä.</p>
        <p><i class='fas fa-fas fa-bed' style='font-size:30px'></i>
        <p> Osa ihmisistä kuitenkin pärjää selvästi vähemmilläkin unilla, kun taas toiset tarvitsevat selkeästi enemmän kuin keskimääräisen määrän unta. </p>
        <p>Yleinen suositus on kuitenkin nukku 7-8 tuntia yössä.</p>
        
        
        <br>

        <p class="ohjeOtsikko">Vinkkejä riittään unimäärään</p>
        
        <p><i class='fas fa-exclamation' style='font-size:30px;color:var(--tehosteVari)'></i> Nouseminen aamuisin kannattaa pitää mahdollisimman säännöllisessä ajassa, nukkumaanmenoajasta riippumatta.</p>
        <p><i class='fas fa-exclamation' style='font-size:30px;color:var(--tehosteVari)'></i> Vapaapäivinä ei kannatta nukkua enempää kuin tuntia pidempään verrattuna arkipäiviin.</p>
        <p><i class='fas fa-exclamation' style='font-size:30px;color:var(--tehosteVari)'></i> Jos uni ei tule, sängyssä ei kannata olla 15 minuuttia kauempaa pyörimässä.</p>
        <p><i class='fas fa-exclamation' style='font-size:30px;color:var(--tehosteVari)'></i> Tietokonetta, puhelinta tai televisiota ei kannata avata odotellessa väsymystä.</p>
        <p><i class='fas fa-exclamation' style='font-size:30px;color:var(--tehosteVari)'></i> Sänkyyn kannattaa mennä vasta, kun on väsynyt.</p>
    
    </div>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>  
</body>
</html>