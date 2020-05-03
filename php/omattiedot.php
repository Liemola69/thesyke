<?php
    include_once("../config/https.php");
    include_once("../config/config.php");
    include("../php/functions.php");
?>

<!DOCTYPE html>
<html>
<head>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<link rel="stylesheet" href="../styles/styles_test.css">
<link href="https://fonts.googleapis.com/css?family=Baloo+Da+2&display=swap" rel="stylesheet">
</head>
<body>

    <?php
    // Hae käyttäjän perustiedot userOlio-muuttujaan ja sessiomuuttujiin
    $userOlio = getUserData($_SESSION['user_ID'], $DBH);
    $_SESSION['got_user_ID'] = $userOlio->user_ID;
    $_SESSION['got_email'] = $userOlio->email;
    $_SESSION['got_password'] = $userOlio->password;
    $_SESSION['got_first_name'] = $userOlio->first_name;
    $_SESSION['got_last_name'] = $userOlio->last_name;
    $_SESSION['got_gender'] = $userOlio->gender;
    $_SESSION['got_height'] = $userOlio->height;
    $_SESSION['got_weight'] = $userOlio->weight;
    $_SESSION['got_birthday'] = $userOlio->birthday;

    // Hae käyttäjän parametritiedot userParametersOlio-muuttujaan ja sessiomuuttujiin
    $userParametersOlio = getUserParameters($_SESSION['user_ID'], $DBH);
    $_SESSION['got_parameters_stimulants'] = $userParametersOlio->parameters_stimulants;
    $_SESSION['got_parameters_alcohol'] = $userParametersOlio->parameters_alcohol;
    $_SESSION['got_parameters_medicine'] = $userParametersOlio->parameters_medicine;
    $_SESSION['got_parameters_drug'] = $userParametersOlio->parameters_drug;
    $_SESSION['got_parameters_screen_time'] = $userParametersOlio->parameters_screen_time;
    $_SESSION['got_parameters_smoke'] = $userParametersOlio->parameters_smoke;
    $_SESSION['got_parameters_user_agreement'] = $userParametersOlio->parameters_user_agreement;
    $_SESSION['got_parameters_email_marketing'] = $userParametersOlio->parameters_email_marketing;
    $_SESSION['got_parameters_gdpr'] = $userParametersOlio->parameters_gdpr;

    //testiprinttaus sessiomuuttujista, kommentoi pois
    //print_r($_SESSION);

    ?>

    <div class="valikkoSivuWrapper">
        <div class="valikkoSivuNavNimi">OMAT TIEDOT</div>
        <div class="valikkoSivuNavKuvake">
            <i id="closeOmattiedot" class='fas fa-times-circle'></i>
        </div>
        <div class="valikkoSivuBody">
            <form method="post">
            Sähköposti: <input type="text" name="email" value="<?php echo $_SESSION['got_email'];?>">
            <br>
            Etunimi: <input type="text" name="email" value="<?php echo $_SESSION['got_first_name'];?>">
            <br>
            Sukunimi: <input type="text" name="email" value="<?php echo $_SESSION['got_last_name'];?>">
            <br>
            Sukupuoli: <input type="text" name="email" value="<?php echo $_SESSION['got_gender'];?>">
            <br>
            Pituus: <input type="text" name="email" value="<?php echo $_SESSION['got_height'];?>">
            <br>
            Paino: <input type="text" name="email" value="<?php echo $_SESSION['got_weight'];?>">
            <br>
            Syntymäaika: <input type="text" name="email" value="<?php echo $_SESSION['got_birthday'];?>">
            <br>
            Käytän nikotiinituotteita: <input type="text" name="email" value="<?php echo $_SESSION['got_parameters_stimulants'];?>">
            <br>
            Käytän alkoholia: <input type="text" name="email" value="<?php echo $_SESSION['got_parameters_alcohol'];?>">
            <br>
            Käytän unilääkkeitä: <input type="text" name="email" value="<?php echo $_SESSION['got_parameters_medicine'];?>">
            <br>
            Käytän huumeita: <input type="text" name="email" value="<?php echo $_SESSION['got_parameters_drug'];?>">
            <br>
            Käytän tietokonetta/kännykkää: <input type="text" name="email" value="<?php echo $_SESSION['got_parameters_screen_time'];?>">
            <br>
            Käytän nikotiinituotteita: <input type="text" name="email" value="<?php echo $_SESSION['got_parameters_smoke'];?>">
            <br>
            Käyttöehdot: <input type="text" name="user_agreement" value="<?php echo $_SESSION['got_parameters_user_agreement'];?>">
            <br>
            Sähköpostimarkkinointi: <input type="text" name="email_marketing" value="<?php echo $_SESSION['got_parameters_email_marketing'];?>">
            <br>
            Henkilötietojen käsittely: <input type="text" name="gdpr" value="<?php echo $_SESSION['got_parameters_gdpr'];?>">
            <br>
        <input class="buttonGeneric" type="submit" name="saveUserDetails" value="Tallenna">
        <input class="buttonGeneric" type="reset" value="Peruuta">
        </div>
    </div>

    <script>
        document.getElementById("closeOmattiedot").addEventListener("click", function(){
        document.location = 'sivurunko.php';
        })
    </script>

<script src='https://kit.fontawesome.com/a076d05399.js'></script>
<script src="../js/sivurunko.js"></script>
</body>
</html>