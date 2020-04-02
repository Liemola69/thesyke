<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Baloo+Da+2&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/styles_test.css">
    <title>teh Syke</title>
</head>
<body>

    <?php
        include_once("config/https.php");
        include_once("config/config.php");
    ?>
    
<div class="teaserDiv">

    <div class="teaserGridItem">
        </div>

    <div class="teaserGridItem">
        <img class="teaserSmallImage" src="images/sleep-zzz.png" alt="ZZZ">
    </div>
    
    <div class="teaserGridItem">
        <img class="teaserImage" src="images/unicorn.png" alt="UNICORN!">
    </div>
    
    <div class="teaserGridItemButton">
        <a href="#" class="buttonDiv" id="loginButton">KIRJAUDU SISÄÄN</a>
    </div>
    
    <div class="teaserGridItemButton">
        <a href="#" class="buttonDiv" id="registerButton">REKISTERÖIDY</a>
    </div>

    <div class="teaserGridItem">
    </div>

</div>

<div class="loginPopup">
    <div class="loginPopupContent loginPopupContentAnimation">
        <i class="far fa-user"></i>
        <i class="far fa-times-circle" id="loginClose"></i>
        <?php
        include("forms/formLogIn.php");

        /** TO-DO
         * Tsekkaa isot/pienet kirjaimet */

        if(isset($_POST['logInSubmit'])){

            $data['userName'] = $_POST['givenName'];

            // Tarkista onko tunnuksia tietokannassa käyttäjätunnuksen perusteella
            $sql = "SELECT * FROM `ts_user` WHERE `email` = :userName;";

            $kysely = $DBH->prepare($sql);
            $kysely -> execute($data);
            $kysely -> setFetchMode(PDO::FETCH_OBJ);
            $vastaus = $kysely -> fetch();

            // Jos löytyi ja tunnus täsmää, sekä isot/pienet kirjaimet täsmää
            if($vastaus != NULL && ($data['userName'] == $vastaus->email)){
                
                // Pura salasanan suojaus
                if(password_verify($_POST['givenPassword'], $vastaus->password)){
                    $_SESSION['loggedIn'] = true;
                    header("Location: php/sivurunko.php");
                } else{
                    echo("Väärä salasana!");
                    ?>
                    <script>
                    document.querySelector(".loginPopup").style.visibility = "visible";
                    document.querySelector(".loginPopupContent").style.top = "5%";
                
                    </script>
                    <?php
                }
            } else{
                echo("Väärä tunnus!");
                echo"<br />";
                echo("Varmista kirjoitusasu.");
                ?>
                <script>
                document.querySelector(".loginPopup").style.visibility = "visible";
                document.querySelector(".loginPopupContent").style.top = "5%";
         
                </script>
                <?php
            }
        }
        ?>
    </div>
</div>

<div class="registerPopup">
    <div class="registerPopupContent">
    <i class="far fa-user"></i>
    <i class="far fa-times-circle" id="registerClose"></i>
    <?php

    include("forms/formCreateAccount.php");

    if(isset($_POST['createAccountSubmit'])){

        $email = $_POST['givenEmail'];
        $password = $_POST['givenPassword'];

        // Validoi sähköposti ja salasana
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){

            // Tarkista ettei sposti ole jo olemassa
            $sql = "SELECT `email` FROM `ts_user` WHERE `email`=" . "'" . $email . "';";
            $kysely = $DBH->prepare($sql);
            $kysely->execute(); 
            $emailKannassa = $kysely->fetch(); //boolean false=ei löytynyt, true=löytyi
            
            // Sähköpostia ei ole kannassa
            if(!$emailKannassa){

                // Tarkista että salasana vähintään 8 merkkiä
                if(strlen($password) > 7){

                    $data['userName'] = $_POST['givenEmail'];
                    $data['userPassword'] = password_hash($_POST['givenPassword'], PASSWORD_BCRYPT);

                    try{
                        // SQL-lause $data-taulukon tiedoille :key -> value
                        $sql = "INSERT INTO `ts_user` (`user_ID`, `email`, `password`) 
                        VALUES (NULL, :userName, :userPassword)";
                        
                        $kysely = $DBH->prepare($sql);
                        $kysely->execute($data);
    
                        header("Location: teaser.php");
                    } catch(PDOException $e){
                        file_put_contents('log/DBErrors.txt', 'Connection: ' . $e->getMessage() . "\n", FILE_APPEND);
                    }
                } else{
                    echo("Surkee salasana, keksi pidempi");
                    ?>
                    <script>
                      
                        document.querySelector(".registerPopup").style.visibility = "visible";
                        document.querySelector(".registerPopupContent").style.top = "5%";
                    </script>
                    <?php
                }
            } else{
                echo("Sähköposti jo käytössä, keksi uusi");
                ?>
                <script>
           
                    document.querySelector(".registerPopup").style.visibility = "visible";
                    document.querySelector(".registerPopupContent").style.top = "5%";
         
                </script>
                <?php
            }
        } else{
            echo("Paska sposti, yritä edes");
            ?>
            <script>

                document.querySelector(".registerPopup").style.visibility = "visible";
                document.querySelector(".registerPopupContent").style.top = "5%";
               
                
            </script>
            <?php
        }
    }
?>

    <script>
        
        document.querySelector(".loginPopupContent").classList.toggle("loginPopupContentAnimation", false);
        document.querySelector(".registerPopupContent").classList.toggle("registerPopupContentAnimation", false);

        document.getElementById("loginButton").addEventListener("click", function(){
            document.querySelector(".loginPopup").style.visibility = "visible";
            document.querySelector(".loginPopupContent").classList.toggle("loginPopupContentAnimation", true);
        })

        document.getElementById("loginClose").addEventListener("click", function(){
            document.querySelector(".loginPopup").style.visibility = "hidden";

        })

        document.getElementById("registerButton").addEventListener("click", function(){
            document.querySelector(".registerPopup").style.visibility = "visible";
            document.querySelector(".registerPopupContent").classList.toggle("registerPopupContentAnimation", true);
        })

        document.getElementById("registerClose").addEventListener("click", function(){
            document.querySelector(".registerPopup").style.visibility = "hidden";

        })







    </script>

    <script src='https://kit.fontawesome.com/a076d05399.js'></script>

</body>
</html>