<?php
    session_start();
    include("forms/formCreateAccount.php");

    //echo session_id();
    //echo "<br>";
    //print_r($_POST);
    //print_r($_SESSION);
?>

    <i class="far fa-user"></i>
    <i class="far fa-times-circle" id="registerClose"></i>
    
<?php
session_start();    
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

                    //Tallenna syötetyt tiedot sessiomuuttujiin
                    $_SESSION['email'] = $_POST['givenEmail'];
                    $_SESSION['password'] = password_hash($_POST['givenPassword'], PASSWORD_BCRYPT);


    
                } else{
                    echo("Syöttämäsi salasana on liian lyhyt. Salasanassa tulee olla vähintään 8 merkkiä.");
                   ?>
                    <script>
                        document.querySelector(".registerPopup").style.visibility = "visible"; 
                        //document.querySelector(".registerPopupContent").classList.toggle("registerPopupContentAnimation", false);
                        //document.querySelector(".registerPopupContent").classList.toggle("registerPopupContentAnimation2", true);   
                    </script>
                    <?php

                 
                }
            } else{
                echo("Syöttämäsi sähköpostiosoite on jo käytössä. Tarkista sähköpostiosoite tai valitse Salasana unohtunut.");
                ?>
                <script>
                    document.querySelector(".registerPopup").style.visibility = "visible";
                    //document.querySelector(".registerPopupContent").classList.toggle("registerPopupContentAnimation", false);
                    //document.querySelector(".registerPopupContent").classList.toggle("registerPopupContentAnimation2", true);  
                </script>
                <?php
              
            }
        } else{
            echo("Syöttämäsi sähköpostiosoite ei ole kelvollinen. Tarkista sähköpostin kirjoitusasu.");
            ?>
            <script>
                document.querySelector(".registerPopup").style.visibility = "visible";
                //document.querySelector(".registerPopupContent").classList.toggle("registerPopupContentAnimation", false);
                //document.querySelector(".registerPopupContent").classList.toggle("registerPopupContentAnimation2", true);
            </script>
            <?php
          
        }
    }
?>