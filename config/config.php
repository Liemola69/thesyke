<?php
    $user = 'tommi';
    $pass = 't1etok4nta';
    $host = 'mysql.metropolia.fi';
    $dbname = 'tommi';

    try {
        $DBH = new PDO("mysql:host=$host; dbname=$dbname", $user, $pass);
        $DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        $DBH->exec("SET NAMES utf8;");
    } catch(PDOException $e) {
        file_put_contents('log/DBErrors.txt', 'Connection: '.$e->getMessage()."\n", FILE_APPEND);
    }

    session_start();
?>