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
        <div id="sivunNimi">TUPAKOINTI+UNI</div>
        <a href="sivurunko.php?moveToDay=<?php echo($_SESSION['currentDay']);?>" id="closeMenu" class='fas fa-times-circle' style='text-decoration:none;'></a>      
    </nav>

    <div>
        <p class="ohjeOtsikko">Yleistä</p>
        <p>Tupakoijat nukkuvat vähemmän ja unenlaatu on heikompaa.</p>
        <p><i class='fas fa-smoking' style='font-size:30px'></i>
        <br>

        <p class="ohjeOtsikko">Tupakoinnin vaikutuksia uneen</p>
        <p><i class='fas fa-frown' style='font-size:20px;color:var(--liikennevaloPunainen)'></i> Tupakka toimii stimulanttina ja relaksanttina samaan aikaan.</p>
        <p><i class='fas fa-frown' style='font-size:20px;color:var(--liikennevaloPunainen)'></i> Tupakoidessa tuoakoija kokee psyykkisesti rentoutuvansa, mutta fysiologisesti elimistö menee stressitilaan.</p>
        <p><i class='fas fa-frown' style='font-size:20px;color:var(--liikennevaloPunainen)'></i> Edellä kuvattua kutsutaan Nesbittin paradoksiksi. Yleisesti stressitilat voivat aiheuttaa ihmisillä unettomuutta.</p>
        <p><i class='fas fa-frown' style='font-size:20px;color:var(--liikennevaloPunainen)'></i> Tupakan ja tupakkatuotteiden sisältämä nikotiini nostaa vireystilaa ja voi näin vaikeuttaa unen saantia.</p>
        <p><i class='fas fa-smile' style='font-size:20px;color:var(--liikennevaloVihrea)'></i> Unen laatu ja määrä paranevat usein tupakoinnin lopettamisen jälkeen.</p>
        
    
    </div>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>  
</body>
</html>