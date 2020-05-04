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
        <div id="sivunNimi">ALKOHOLI+UNI</div>
        <a href="sivurunko.php?moveToDay=<?php echo($_SESSION['currentDay']);?>" id="closeMenu" class='fas fa-times-circle' style='text-decoration:none;'></a>      
    </nav>

    <div>
        <p class="ohjeOtsikko">Yleistä</p>
        
        <p>Alkoholi kuuluu monen ihmisen elämään. Kohtuullisesti käytettynä alkoholilla sopii useimmille ihmisille nautittavaksi silloin tällöin.</p>
        <p><i class='fas fa-wine-glass-alt' style='font-size:30px'></i>
        <p>Alkoholin vaikutus uneen riippuu monista tekijöistä. Tekijöitä ovat muun muassa käytetyn alkoholin määrä sekä yksilölliset tekijät, kuten ikä, sukupuoli tai kehonkoostumus.</p>
        <p><i class='fas fa-wine-glass-alt' style='font-size:30px'></i>
        <p>Joillakin ihmisillä yhden tai korkeintaan kahden ravintola-annoksen ajoittainen nauttiminen illalla voi rentouttaa ja helpottaa nukahtamista. Toisilla pienikin määrä alkoholia vaikuttaa uneen heikentävästi. 
        </p><br>
        <p class="ohjeOtsikko">Alkoholin vaikutuksia uneen</p>
        
        <p><i class='fas fa-frown' style='font-size:20px;color:var(--liikennevaloPunainen)'></i> Nautittu alkoholi voi rentouttaa ja tuoda väsyneen olon. Pitää kuitenkin muistaa, että alkoholin alainen uni EI ole palauttavinta unta!!</p>
        <p><i class='fas fa-frown' style='font-size:20px;color:var(--liikennevaloPunainen)'></i> Alkoholin nauttiminen voi aiheuttaa rytmihäiriöitä ja häiritä unta tai unen saamista.</p>
        <p><i class='fas fa-frown' style='font-size:20px;color:var(--liikennevaloPunainen)'></i> Alkoholi veltostuttaa ylähengitysteiden lihaksia aiheuttaen kuorsausta ja lisäten riskiä unen aikaisiin hengityskatkoksiin (uniapneaan).</p>
        <p><i class='fas fa-frown' style='font-size:20px;color:var(--liikennevaloPunainen)'></i> Nautittu alkoholi vähentää REM-univaihetta, jolloin ihminen näkee surimman osan unista.</p>
        <p><i class='fas fa-frown' style='font-size:20px;color:var(--liikennevaloPunainen)'></i> Suuri määrä alkoholia rikkoo unen rakenteen ja lamaa keskushermostoa.</p>
        <p><i class='fas fa-frown' style='font-size:20px;color:var(--liikennevaloPunainen)'></i> Seuraavina iltoina alkoholin nauttimisen jälkeen voi ihmiselle tulla levottomuutta ja ahdistuneisuutta, jotka vaikeuttavat unen saamista.
        </p>
        <p><i class='fas fa-exclamation' style='font-size:30px;color:var(--liikennevaloPunainen)'></i> Älä käytä alkoholia unilääkkeenä!!</p>
        
    
    </div>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>  
</body>
</html>