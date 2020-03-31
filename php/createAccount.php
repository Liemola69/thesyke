<?php
    include_once("../config/https.php");
    include_once("../config/config.php");
    
    echo("Luo tili sivu");
    include("../forms/formCreateAccount.php");

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
    
                        header("Location: ../teaser.php");
                    } catch(PDOException $e){
                        file_put_contents('log/DBErrors.txt', 'Connection: ' . $e->getMessage() . "\n", FILE_APPEND);
                    }
                } else{
                    echo("Surkee salasana, keksi pidempi");
                }
            } else{
                echo("Sähköposti jo käytössä, keksi uusi");
            }
        } else{
            echo("Paska sposti, yritä edes");
        }
    }
?>