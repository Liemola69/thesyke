<?php
session_start();
?>

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
    session_start();
    include_once("config/https.php");
    include_once("config/config.php");
    include("forms/formCreateAccount.php");

    print_r($data);
    echo session_id();

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

                    //$data['userName'] = $_POST['givenEmail'];
                    //$data['userPassword'] = password_hash($_POST['givenPassword'], PASSWORD_BCRYPT);
    
                } else{
                    echo("Surkee salasana, keksi pidempi");
                   ?>
                    <script>
                        document.querySelector(".registerPopup").style.visibility = "visible"; 
                        document.querySelector(".registerPopupContent").classList.toggle("registerPopupContentAnimation", false);
                        document.querySelector(".registerPopupContent").classList.toggle("registerPopupContentAnimation2", true);   
                    </script>
                    <?php
                 
                }
            } else{
                echo("Sähköposti jo käytössä, keksi uusi");
                ?>
                <script>
                    document.querySelector(".registerPopup").style.visibility = "visible";
                    document.querySelector(".registerPopupContent").classList.toggle("registerPopupContentAnimation", false);
                    document.querySelector(".registerPopupContent").classList.toggle("registerPopupContentAnimation2", true);  
                </script>
                <?php
              
            }
        } else{
            echo("Paska sposti, yritä edes");
            ?>
            <script>
                document.querySelector(".registerPopup").style.visibility = "visible";
                document.querySelector(".registerPopupContent").classList.toggle("registerPopupContentAnimation", false);
                document.querySelector(".registerPopupContent").classList.toggle("registerPopupContentAnimation2", true);
            </script>
            <?php
          
        }
    }
?>

</body>
</html>