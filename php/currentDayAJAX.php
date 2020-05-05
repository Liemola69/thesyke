<?php
    // Kuukausinäkymän AJAX-funktiota varten haetaan session muuttujista sovelluksen kuluva päivä
    session_start();
    echo $_SESSION['currentDay'];
?>