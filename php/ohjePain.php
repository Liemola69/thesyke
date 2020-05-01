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
        <div id="sivunNimi">KIPU+UNI</div>
        <a href="sivurunko.php?moveToDay=<?php echo($_SESSION['currentDay']);?>" id="closeMenu" class='fas fa-times-circle' style='text-decoration:none;'></a>      
    </nav>

    <div>
        <p class="ohjeOtsikko">Yleistä</p>
        <p>Ihmiselämään kuuluvat toisinaan kiputilat. Kivut voivat vaikeuttaa nukahtamista tai herättää kesken unien.</p>
        <p><i class='fas fa-ambulance' style='font-size:30px'></i>
  
        
        <p><i class='fas fa-exclamation' style='font-size:30px;color:var(--tehosteVari)'></i> Jos sinulla on toistuvasti kipuja tai sovelluksemme kipuja ilmoittava ikoni on jatkuvasti punaisella värillä tai alakuloisella naama-kuvakkeella, kannattaa kääntyä lääkärin tai sairaanhoitajan puoleen.</p>
    
    </div>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>  
</body>
</html>