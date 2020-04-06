<?php
    $user = 'minervar';
    $pass = 'piF3shua';
    $host = 'mysql.metropolia.fi';
    $dbname = 'minervar';

    try {
        // Avataan yhteys tietokantaan
        // $DBH yhteysolio on kahva tietokantaan data base handle
        $DBH = new PDO("mysql:host=$host; dbname=$dbname", $user, $pass);
        // Virheenkäsittely: virheet aiheuttavat poikkeuksen
        $DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        // Käytetään  merkistöä utf8
        $DBH->exec("SET NAMES utf8;");
    } catch(PDOException $e) {
        // Kirjoitetaan mahdollinen virheviesti tiedostoon
        file_put_contents('log/DBErrors.txt', 'Connection: '.$e->getMessage()."\n", FILE_APPEND);
    }

    session_start();
?>
