<?php
    session_start();
    include("forms/formCreateUserParameters.php");

    //Session debuggaus, kommentoi pois tarvittaessa
    //echo session_id();
    //echo "<br>";
    //print_r($_SESSION);
    //print_r($_POST);

    

    //Tarkista onko Tallenna -painiketta painettu ja onko nimitiedot tallennettu sessiomuuttujiin
    if(isset($_POST['createUserDetailsSubmit'], $_SESSION['first_name'], $_SESSION['last_name']
    )){

    ?>
    <script>
        document.querySelector(".createUserParametersPopup").style.visibility = "visible";
    </script>
    <?php
    }

    //Tietojen tallennus sessiotietoihin ja session-tiedoista dataan
    //TODO, validointi

    if(isset($_POST['createUserParametersSubmit'])){

    $_SESSION['parameters_stimulants'] = $_POST['parameters_stimulants'];
    $_SESSION['parameters_alcohol'] = $_POST['parameters_alcohol'];
    $_SESSION['parameters_medicine'] = $_POST['parameters_medicine'];
    $_SESSION['parameters_drug'] = $_POST['parameters_drug'];
    $_SESSION['parameters_smoke'] = $_POST['parameters_smoke']; 

    $data['email'] = $_SESSION['email'];
    $data['password'] = $_SESSION['password'];
    $data['first_name'] = $_SESSION['first_name'];
    $data['last_name'] = $_SESSION['last_name'];
    $data['age'] = $_SESSION['age'];
    $data['gender'] = $_SESSION['gender'];
    $data['height'] = (int)$_SESSION['height'];
    $data['weight'] = (int)$_SESSION['weight'];

    $data2['email'] = $_SESSION['email'];

    $data3['parameters_stimulants'] = $_SESSION['parameters_stimulants'];
    $data3['parameters_alcohol'] = $_SESSION['parameters_alcohol'];
    $data3['parameters_medicine'] = $_SESSION['parameters_medicine'];
    $data3['parameters_drug'] = $_SESSION['parameters_drug'];
    $data3['parameters_smoke'] = $_SESSION['parameters_smoke'];

    $data3['parameters_user_agreement'] = $_SESSION['parameters_user_agreement'];
    $data3['parameters_email_marketing'] = $_SESSION['parameters_email_marketing'];
    $data3['parameters_gdpr'] = $_SESSION['parameters_gdpr'];






    try{
        // SQL-lause $data-taulukon tiedoille :key -> value
        $sql = "INSERT INTO `ts_user` (`user_ID`, `email`, `password`, `first_name`, `last_name`, `birthday`, `gender`, `height`, `weight`)            
        VALUES (NULL, :email, :password, :first_name, :last_name, :age, :gender, :height, :weight)";

        $kysely = $DBH->prepare($sql);
        $kysely->execute($data);

        // Hae user-id
        $sql = "SELECT * FROM `ts_user` WHERE `email` = :email;";

        $kysely = $DBH->prepare($sql);
        $kysely -> execute($data2);
        $kysely -> setFetchMode(PDO::FETCH_OBJ);
        $vastaus = $kysely -> fetch();
                    
        $_SESSION['user_ID'] = $vastaus->user_ID;
        $data['user_ID'] = $_SESSION['user_ID'];

        $sql = "INSERT INTO `ts_user_parameters` (`user_ID`, `parameters_ID`, `parameters_stimulants`, `parameters_alcohol`, `parameters_medicine`, `parameters_drug`, `parameters_screen_time`, `parameters_smoke`, `parameters_user_agreement`, `parameters_email_marketing`, `parameters_gdpr`, `parameters_fall_asleep_time`)
        VALUES (:user_ID, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
        
        $kysely = $DBH->prepare($sql);
        $kysely->execute($data3);

    } catch(PDOException $e){
        file_put_contents('log/DBErrors.txt', 'Connection: ' . $e->getMessage() . "\n", FILE_APPEND);
    }

    echo('<script>
                        let tunnusLuotu = document.createElement("div");
                        tunnusLuotu.setAttribute("class", "snackbar");
                        let tunnusLuotuText = document.createTextNode("Käyttäjätunnus luotu onnistuneesti! Voit kirjautua sisään luomillasi tunnuksilla.");
                        tunnusLuotu.classList.add("show");
                        tunnusLuotu.appendChild(tunnusLuotuText);
                        document.body.appendChild(tunnusLuotu);
                        setTimeout(function(){ 
                            document.body.removeChild(tunnusLuotu);
                        }, 5000);
                        </script>');
    header("Location: php/resetVariables.php");
    
}
    


     


?>