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

    <i class="far fa-user"></i>
    <i class="far fa-times-circle" id="registerClose"></i>

<?php
    include_once("config/https.php");
    include_once("config/config.php");
    include("forms/formCreateAccount.php");

    if(isset($_POST['createAccountSubmit'])){

        $email = $_POST['givenEmail'];
        $password = $_POST['givenPassword'];

        ?>
        <script>
            
            document.querySelector(".registerPopup").style.visibility = "visible";
            
        </script>

    <?php

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
                        document.querySelector(".registerPopupContent").classList.toggle("registerPopupContentAnimation", false);
                        document.querySelector(".registerPopupContent").classList.toggle("registerPopupContentAnimation2", true);   
                    </script>
                    <?php
                }
            } else{
                echo("Sähköposti jo käytössä, keksi uusi");
                ?>
                <script>
                    document.querySelector(".registerPopupContent").classList.toggle("registerPopupContentAnimation", false);
                    document.querySelector(".registerPopupContent").classList.toggle("registerPopupContentAnimation2", true);  
                </script>
                <?php
            }
        } else{
            echo("Paska sposti, yritä edes");
            ?>
            <script>
                document.querySelector(".registerPopupContent").classList.toggle("registerPopupContentAnimation", false);
                document.querySelector(".registerPopupContent").classList.toggle("registerPopupContentAnimation2", true);
            </script>
            <?php
        }
    }
?>

</body>