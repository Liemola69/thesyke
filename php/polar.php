<?php
    include_once("../config/https.php");
    include_once("../config/config.php");
    include_once("functions.php");

    $client_id = "2162ed96-e5cf-4253-b576-b9002418a1b8";
    $client_secret = "716efb59-b9ea-4edb-ab98-01c6d8287662";
    
    // Tarkista onko käyttäjällä tietokannassa polar_ID, jos on, ei vaadita kirjautumista Polariin
    $polarID = getPolarID($DBH, $_SESSION['user_ID']);

    if(isset($_GET['code'])){ // Suoritetaan kun Polar lupa annettu
        $authCode = $_GET['code'];
        $clientEncoded = base64_encode($client_id . ":" . $client_secret);

        // Hae token käyttäjälle Polarilta ja rekisteröi sovelluksen käyttäjäksi
        createToken($authCode, $clientEncoded, $DBH, $_SESSION['user_ID']);
        $serverResponse = registerUser($DBH, $_SESSION['user_ID']);

        if($serverResponse == "200"){
            $_SESSION['polarRegisterationTrue'] = true;
        } else{
            $_SESSION['polarRegisterationTrue'] = false;
        }
        
        header("Location: sivurunko.php");

    } elseif($polarID != null){
        $_SESSION['polarAccountTrue'] = true;
        header("Location: sivurunko.php");
    } else{ // Ensimmäistä kertaa linkittämässä -> siirretään antamaan lupa Polarin sivuille
        header("Location: https://flow.polar.com/oauth2/authorization?response_type=code&client_id=" . $client_id);
    }

?>