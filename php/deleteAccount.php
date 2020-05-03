<?php
    include_once("../config/https.php");
    include_once("../config/config.php");
    include("../php/functions.php");
    
?>
<!DOCTYPE html>
<html>
<head>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<link rel="stylesheet" href="../styles/kysely.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>

<nav id="ylaNavDeleteAccount">
        <div id="sivunNimi">POISTA TILI </div>
        <a href="sivurunko.php" id="closeDeleteAccount" class='fas fa-times-circle' style='text-decoration:none;'></a>      
</nav>
<?php

//jos formissa on painettu delete-nappulaa
    if(isset($_POST["delete"])){

        $paivaOljo = getUserData($_SESSION["user_ID"], $DBH);

    //hae tietokannasta tallennettu sähköpostiosoite
            $email = "SELECT `email` FROM `ts_user` WHERE `user_ID` = ". "'" . $_SESSION["user_ID"] . "';";
            
                $kysely = $DBH->prepare($email);
                $kysely->execute(); 
                $emailKannassa = $kysely->fetch();
                

            $salaSana = "SELECT `password` FROM `ts_user` WHERE `user_ID` = ". "'" . $_SESSION["user_ID"] . "';";
            //echo($salaSana);
                $kysely2 = $DBH->prepare($salaSana);
                $kysely2->execute(); 
                $salasanaKannassa = $kysely2->fetch();
               

        //kyselyn perusteella annetut tiedot
        $user_email  = $_POST['givenEmail'];
        //echo($user_email);
        $_SESSION['email'] = $_POST['givenEmail'];
        
        $user_pass  = $_POST['givenPassword'];
        
        $_SESSION['password'] = $_POST['givenPassword'];

        //tarkistetaan täsmääkö annettu sähköposti kantaan tallennetun kanssa
        if($emailKannassa[0] == $user_email){

            //poistetaan kaikki taulut erikseen

            $sql3 = "DELETE FROM `ts_day` WHERE `user_ID` = ". "'" . $_SESSION['user_ID'] . "';";
            $kysely3 = $DBH->prepare($sql3);
            $kysely3->execute();

            $sql2 = "DELETE FROM `ts_parameter_mapping` WHERE `user_ID` = ". "'" . $_SESSION['user_ID'] . "';";
            $kysely2 = $DBH->prepare($sql2);
            $kysely2->execute(); 

            $sql4 = "DELETE FROM `ts_user_parameters` WHERE `user_ID` = ". "'" . $_SESSION['user_ID'] . "';";
            $kysely4 = $DBH->prepare($sql4);
            $kysely4->execute();
            
            $sql1 = "DELETE FROM `ts_date` WHERE `date_user_ID` = ". "'" . $_SESSION['user_ID'] . "';";
            $kysely1 = $DBH->prepare($sql1);
            $kysely1->execute();

            $sql = "DELETE FROM `ts_user` WHERE `user_ID` = ". "'" . $_SESSION['user_ID'] . "';";
            $kysely = $DBH->prepare($sql);
            $kysely->execute();
           
           
           //takaisin kirjautumissivulle
            header("Location: ../teaser.php"); 
            
            //jos annettu sposti ei täsmää kannassa olevan kanssa
        }else{
            include("../forms/formDeleteAccount.php");
            echo("Antamasi tiedot eivät täsmää kirjautumistietojesi kanssa. Yritä uudelleen!");
        }

    }else{
        include("../forms/formDeleteAccount.php");
         }
      

?>
<script src='https://kit.fontawesome.com/a076d05399.js'></script>
<script src="../js/sivurunko.js"></script>
</body>
</html>