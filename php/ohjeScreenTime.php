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
        <div id="sivunNimi">RUUTUAIKA+UNI</div>
        <a href="sivurunko.php?moveToDay=<?php echo($_SESSION['currentDay']);?>" id="closeMenu" class='fas fa-times-circle' style='text-decoration:none;'></a>      
    </nav>
    <!-- Lähde: https://tekniikanmaailma.fi/sininen-valo-ei-ole-paasyyllinen-vasyneisiin-silmiin-ja-unenpuutteeseen-vaikka-moni-niin-luulee-tassa-selitys-miksi-ei/ -->
    <div>
        <p class="ohjeOtsikko">Yleistä</p>
        <p>Ruutuajalla tarkoitetaan aikaa, jonka on viettänyt katsoessa televisiota, ollessa tietokoneella tai tabletilla tai selatessa älypuhelinta.</p>
        <p><i class='fas fa-laptop' style='font-size:30px'></i>
        <p>Nämä laitteet heijastavat sinistä valoa. Sininen valo saattaa piristää ja näin pitää sinut päivätasoisen valppaana.</p>
        
        <p><i class='fas fa-mobile-alt' style='font-size:30px'></i>
        <br>
        <p class="ohjeOtsikko">Vinkkejä</p>
        <p><i class='fas fa-exclamation' style='font-size:30px;color:var(--tehosteVari)'></i> Minimoi ruutuaika viimeiseksi illalla.</p>
        <p><i class='fas fa-exclamation' style='font-size:30px;color:var(--tehosteVari)'></i> Asenna puhelimeen sinivaloa suodattava sovellus ja laita se illalla päälle.</p>
        <p><i class='fas fa-exclamation' style='font-size:30px;color:var(--tehosteVari)'></i> Illalla voi olla hyvä lukea esimerkiksi kirjaa tai lehteä.</p>
        <br>
        <p class="ohjeOtsikko">Sininen valo</p>
        <p>Sininen valonsäde on yksi valon aallonpituus.</p>
        <p><i class='fas fa-tv' style='font-size:30px'></i>
        <p>Sinisellä valolla on lyhyt aallonpituus, mikä tarkoittaa sitä, että se on korkeaenergistä ja voi vahingoittaa silmän herkkiä kudoksia. Se voi myös kulkea läpi silmän verkkokalvoon, hermosolujen kokoelmaan, joka muuttaa valon signaaleiksi, jotka ovat näköaistin perusta. 
        </p>
        <p>Aallonpituutensa takia sininen valo tosiaankin häiritsee tervettä unen fysiologiaa.</p>
        <p><i class='fas fa-tablet-alt' style='font-size:30px'></i>
        <p>Siniselle valolle herkät solut, jotka tunnetaan luonnostaan valoherkkinä verkkokalvon gangliosoluina tai nimellä ipRGC, kertovat aivojen keskuskellolle, kuinka valoisaa ympäristössä on.</p>
        <p>Tämä tarkoittaa sitä, että kun katsot kirkkaasti valaistua näyttöä, nämä solut auttavat tahdistamaan sisäisen kellosi päiväaikaisen valppauden tasolle.
</p>
    </div>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>  
</body>
</html>