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
        <div id="sivunNimi">RAVINTO+UNI</div>
        <a href="sivurunko.php?moveToDay=<?php echo($_SESSION['currentDay']);?>" id="closeMenu" class='fas fa-times-circle' style='text-decoration:none;'></a>      
    </nav>

    <div>
        <p class="ohjeOtsikko">Yleistä</p>
        <p>Päivän aikana ja varsinkin ennen nukkumaan menoa nautitulla ravinnolla voi olla uneen ja unen laatuun vaikuttavia tekijöitä.</p>
        <p><i class='fas fa-carrot' style='font-size:30px'></i>
        <p>Aamu- ja päiväpainotteinen ruokarytmi antaa ruoansulatuselinten välityksellä aivojen sisäiselle kellolle viestejä vuorokausirytmistä eli siitä, milloin ruoansulatus on käynnissä ja keho hereillä.</p>
        <br>

        <p class="ohjeOtsikko">Ravinnon vaikutuksia uneen</p>
        <p><i class='fas fa-frown' style='font-size:20px;color:var(--liikennevaloPunainen)'></i> Illalla nautitun rasvaisen ruoan on todettu haittaavan unen laatua eli lyhentävän palauttavan syvän unen vaihetta.</p>
        <p><i class='fas fa-smile' style='font-size:20px;color:var(--liikennevaloVihrea)'></i> Illalla unta voi edistää terveellisellä ja kohtuullisen kokoisella iltapalalla, joka täyttää mahan sopivasti.</p>
        <p><i class='fas fa-smile' style='font-size:20px;color:var(--liikennevaloVihrea)'></i> Kuitupitoisia hiilihydraatteja olisi hyvä syödä illalla, sillä hiilihydraatit auttavat melatoniinin pääsyä aivoihin.</p>
        <p><i class='fas fa-frown' style='font-size:20px;color:var(--liikennevaloPunainen)'></i> Runsasta juomista illalla kannattaa välttää vessaan heräämisen takia.</p>
        <p><i class='fas fa-smile' style='font-size:20px;color:var(--liikennevaloVihrea)'></i> Nestettä kannattaa juoda paljon aamulla ja päivällä ja vähentää näin kohti iltaa.</p>
        <p><i class='fas fa-exclamation' style='font-size:30px;color:var(--tehosteVari)'></i> Vinkki: tutkimuksen mukaan kiivi ja kirsikkamehu saattavat auttaa saamaan hieman paremmat ja pidemmät une.</p>
    
    </div>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>  
</body>
</html>