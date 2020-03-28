<!DOCTYPE html>
<html lang="fi"> 
<head>
<title>cofig.php</title>
<link rel="stylesheet" type="text/css" href="CSS/lab4.css">
<meta charset="UTF-8"/>
</head>
<body>

    
<h1>1. Tietokantatestailua</h1>
<?php
$user = 'minervar';		// oma Käytäjänimi 
$pass = 'piF3shua';		//Salasana, ei OMAn vaan phpAdminin
$host = 'mysql.metropolia.fi';  //Tietokantapalvelin
$dbname = 'minervar';		//Tietokanta
// Muodostetaan yhteys tietokantaan
try {     //Avataan yhteys tietokantaan ($DBH on nyt  yhteysolio, nimi vapaasti valittavissa)
// $DBH yhteysolio on kahva tietokantaan data base handle
	$DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
           // virheenkäsittely: virheet aiheuttavat poikkeuksen
	$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	// käytetään  merkistöä utf8
  echo "Yhteys OK.";   //Kommentoi pois validoitavassa versiossa
  $DBH->exec("SET NAMES utf8;");
} catch(PDOException $e) {
           echo "Yhteysvirhe: " . $e->getMessage(); 
            //Kirjoitetaan mahdollinen virheviesti tiedostoon
	file_put_contents('log/DBErrors.txt', 'Connection: '.$e->getMessage()."\n", FILE_APPEND);
} 

?>

</body>
</html>