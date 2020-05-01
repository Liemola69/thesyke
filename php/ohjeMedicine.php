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
        <div id="sivunNimi">UNILÄÄKKEET+UNI</div>
        <a href="sivurunko.php?moveToDay=<?php echo($_SESSION['currentDay']);?>" id="closeMenu" class='fas fa-times-circle' style='text-decoration:none;'></a>      
    </nav>

    <div>
        <p class="ohjeOtsikko">Yleistä</p>
        <p>Nukahtamiseen tai uneen liittyviä lääkkeitä on hyvin suuri määrä.</p>
        <p><i class='fas fa-capsules' style='font-size:30px'></i>
        <p>Nukkumiseen tai nukahtamiseen liittyvien lääkkeiden käytöstä on aina syytä keskustella lääkärin kanssa.</p>
        
        <p><i class='fas fa-exclamation' style='font-size:30px;color:var(--tehosteVari)'></i> Nukahtamiseen tai uneen vaikuttavia lääkkeitä on turvallista ja järkevää käyttää lääkärin ohjeiden mukaan.</p>
        <p><i class='fas fa-exclamation' style='font-size:30px;color:var(--tehosteVari)'></i> Melatoniinia voi koettaa ottaa avuksi nukahtamiseen. Sitä saa apteekista. Melatoniinia voi käyttää 1 mg ravintolisänä nukahtamisajan nopeuttamiseksi.</p>
        
    
    </div>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>  
</body>
</html>